<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColumnInIdeasTable extends Migration
{
    /**
     * Menjalankan migrasi untuk mengubah kolom status.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ideas', function (Blueprint $table) {
            // Mengubah kolom status menjadi ENUM
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();
        });
    }

    /**
     * Membalikkan migrasi ini (untuk rollback).
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ideas', function (Blueprint $table) {
            // Jika rollback, kembalikan kolom status ke tipe data string atau lainnya
            $table->string('status')->default('pending')->change();
        });
    }
}
