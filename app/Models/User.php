<?php

namespace App\Models;

use App\Enums\AccessTypes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    protected $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-m-d h:m';
    /**
     * @param $password
     */
    public function setPasswordAttribute($password)  : void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims() : array
    {
        return [];
    }

    /**
     * @return HasMany
     */
    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function accessLevel(): array
    {
        if ($this->hasAllPermissions(['view_office_posts', 'view_production_posts'])) {
            return AccessTypes::getTypes();
        }

        if ($this->hasPermissionTo('view_office_posts')) {
            return [AccessTypes::OFFICE];
        }

        if ($this->hasPermissionTo('view_production_posts')) {
            return [AccessTypes::PRODUCTION];
        }

        return [];
    }
}
