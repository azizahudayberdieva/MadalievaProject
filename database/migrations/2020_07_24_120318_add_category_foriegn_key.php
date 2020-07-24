<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryForiegnKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('id');
            $table->foreign('category_id')
                ->on('categories')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
           $table->dropForeign(['category_id']);
           $table->dropForeign(['user_id']);
           $table->dropColumn(['category_id', 'user_id']);
        });
    }
}
