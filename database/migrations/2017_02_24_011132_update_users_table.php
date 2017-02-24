<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('gender')->nullable();
            $table->string('avatar');
            $table->string('phone');
            $table->string('address');
            $table->text('introduce')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'avatar',
                'phone',
                'address',
                'introduce',
                'status',
                'is_admin',
            ]);
        });
    }
}
