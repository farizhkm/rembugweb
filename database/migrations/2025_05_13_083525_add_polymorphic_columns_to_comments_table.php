<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPolymorphicColumnsToCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->morphs('commentable'); // Ini akan menambahkan commentable_id dan commentable_type
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropMorphs('commentable');
        });
    }
}