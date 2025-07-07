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
        Schema::create('activities', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('action'); // misalnya: 'created_idea', 'deleted_project'
    $table->string('subject_type'); // contoh: App\Models\Idea
    $table->unsignedBigInteger('subject_id'); // ID data yang dimaksud
    $table->text('description')->nullable(); // deskripsi singkat
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
