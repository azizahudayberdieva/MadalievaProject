<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachmentTypeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->integer('attachable_id')->after('id');
            $table->string('attachable_type')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropColumn(['attachable_id', 'attachable_type']);
        });
    }
}
