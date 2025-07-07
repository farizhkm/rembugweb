<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToIdeasTable extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom `image` ke tabel `ideas`.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->string('image')->nullable()->after('category');  // Kolom image ditambahkan setelah category
        });
    }

    /**
     * Kebalikan dari migrasi ini (untuk rollback).
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropColumn('image');  // Hapus kolom image jika rollback
        });
    }
}
