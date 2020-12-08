<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocaleColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function(Blueprint $table) {
            $table->string('locale')
                ->default('ru')
                ->after('category_id')
                ->index()
                ->nullable();

            $table->string('status')
                ->nullable()
                ->default(\App\Enums\PostStatuses::PUBLISHED)
                ->after('locale');
        });

        Schema::table('categories', function(Blueprint $table) {
            $table->string('locale')
                ->default('ru')
                ->after('parent_id')
                ->index()
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function(Blueprint $table) {
            $table->dropColumn('locale');
            $table->dropColumn('status');
        });

        Schema::table('categories', function(Blueprint $table) {
            $table->dropColumn('locale');
        });
    }
}
