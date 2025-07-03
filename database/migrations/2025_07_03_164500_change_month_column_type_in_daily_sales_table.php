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
        Schema::table('daily_sales', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->string('month')->change();
        });
    }

    public function down()
    {
        Schema::table('daily_sales', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->integer('month')->change(); // revert to original
        });
    }

};
