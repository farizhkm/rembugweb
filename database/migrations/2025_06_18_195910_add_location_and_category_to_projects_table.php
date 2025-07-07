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
    Schema::table('projects', function (Blueprint $table) {
        if (!Schema::hasColumn('projects', 'category')) {
            $table->string('category')->nullable()->after('status');
        }
        if (!Schema::hasColumn('projects', 'address')) {
            $table->text('address')->nullable()->after('category');
        }
        if (!Schema::hasColumn('projects', 'lat')) {
            $table->decimal('lat', 10, 6)->nullable()->after('address');
        }
        if (!Schema::hasColumn('projects', 'lng')) {
            $table->decimal('lng', 10, 6)->nullable()->after('lat');
        }
    });
}

public function down()
{
    Schema::table('projects', function (Blueprint $table) {
        $table->dropColumn(['category', 'address', 'lat', 'lng']);
    });
}
};
