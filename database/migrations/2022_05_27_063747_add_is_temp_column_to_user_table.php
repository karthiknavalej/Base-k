<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsTempColumnToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'is_temp'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('is_temp')->nullable()->comment('0: True 1: False')->after('reset_password_email_sent_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'is_temp'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_temp');
            });
        }
    }
}
