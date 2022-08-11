<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('matricule')->nullable();
            $table->string('company')->nullable();
            $table->string('service')->nullable();
            $table->string('city')->nullable();
            $table->string('cin')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('picture')->nullable();
            $table->enum('role', [1, 2, 3]); // '1' => Admin , '2' => customer , '3' => provider
            $table->boolean('enabled')->default(0);
            $table->boolean('email_verified')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
