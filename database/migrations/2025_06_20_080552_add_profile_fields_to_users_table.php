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
        Schema::table('users', function (Blueprint $table) {
    if (!Schema::hasColumn('users', 'address')) {
        $table->string('address')->nullable();
    }
    if (!Schema::hasColumn('users', 'phone_number')) {
        $table->string('phone_number')->nullable();
    }
    if (!Schema::hasColumn('users', 'birthdate')) {
        $table->date('birthdate')->nullable();
    }
    if (!Schema::hasColumn('users', 'profile_picture')) {
        $table->string('profile_picture')->nullable();
    }
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
