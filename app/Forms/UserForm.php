<?php

namespace App\Forms;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserForm extends AbstractForm
{
    private const SUBSCRIBER_ROLE_ID = 2;

    protected $fieldsDefinitions = [];

    protected function buildForm()
    {
        $this->formBuilder
            ->add('text', 'name', trans('admin_panel.users.name'),
                [
                    'validationRule' => 'required',
                ]);

        $this->formBuilder
            ->add('email', 'email', trans('admin_panel.users.email'),
                [
                    'validationRule' => 'required|email',
                ]
            );

        $this->formBuilder
            ->add('password', 'password', trans('admin_panel.users.password'),
                [
                    'validationRule' => 'required|min:6',
                ]
            );

        $this->formBuilder
            ->add('select', 'role', trans('admin_panel.users.role'),
                [
                    'options' => $this->getUserRoles(),
                    'validationRule' => 'required',
                ]);
    }

    private function getUserRoles()
    {
        return  Role::all()->map(function($role) {
            return [
                'id' => $role->id,
                'name' => trans("admin_panel.roles.$role->name"),
            ];
        });
    }

    public function fill(User $user)
    {
        foreach ($this->formBuilder->getFields() as $field) {
            if ($value = $user->{$field->getName()}) {
                $field->setValue($value);
            }
            if ($field->getName() === 'role') {
                $role = $user->roles->first()->id;
                $field->setValue($role);
            }
            if ($field->getName() === 'password') {
                $field->setValidationRule('');
                $field->setValue('');
            }
        }

        return $this;
    }
}
