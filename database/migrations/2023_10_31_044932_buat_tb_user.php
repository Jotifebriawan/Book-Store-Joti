<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user'); 
            $table->string('nama_user', 255);
            $table->string('username', 100)->unique();
            $table->string('password', 100);
            $table->string('telpon', 16)->nullable();
            $table->string('email', 100)->unique();
            $table->string('level', 16);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('tb_user');
    }
};
