<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('project_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->boolean('is_available')->default(false); // apakah item sudah tersedia
        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_items');
    }
};
