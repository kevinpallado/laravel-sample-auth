<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserAddtnlInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->boolean('is_suspended')->default(false);
            $table->boolean('is_login')->default(false);
            $table->boolean('is_approve')->default(false);
            $table->boolean('is_agent')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('has_system_access')->default(false);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn(['is_suspended', 'is_login', 'is_approve', 'is_agent', 'is_admin','has_system_access']);
        });
    }
}
