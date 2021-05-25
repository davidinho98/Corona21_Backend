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
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('password');
            $table->integer('svnr');
            $table->date('bdate');
            $table->string('email')->unique();
            $table->string('phone');
            $table->boolean('vaccinated');
            $table->boolean('admin');
            $table->boolean('termin');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->foreignId('vaccination_id')->constrained()->onDelete('cascade');
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
