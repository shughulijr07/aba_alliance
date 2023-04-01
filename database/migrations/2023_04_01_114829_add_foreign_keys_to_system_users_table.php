<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system_users', function (Blueprint $table) {
            $table->foreign(['system_role_id'])->references(['id'])->on('system_roles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('system_users', function (Blueprint $table) {
            $table->dropForeign('system_users_system_role_id_foreign');
            $table->dropForeign('system_users_user_id_foreign');
        });
    }
};
