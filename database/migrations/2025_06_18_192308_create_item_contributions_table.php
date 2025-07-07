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
         Schema::create('item_contributions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('project_item_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->boolean('confirmed')->default(false); // apakah user benar menyediakan
        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_contributions');
    }
};
