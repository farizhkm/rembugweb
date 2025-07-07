<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'category')) {
                $table->string('category')->nullable()->after('description');
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
            if (!Schema::hasColumn('projects', 'needs')) {
                $table->text('needs')->nullable()->after('lng');
            }
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('projects', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('projects', 'lat')) {
                $table->dropColumn('lat');
            }
            if (Schema::hasColumn('projects', 'lng')) {
                $table->dropColumn('lng');
            }
            if (Schema::hasColumn('projects', 'needs')) {
                $table->dropColumn('needs');
            }
        });
    }
}
