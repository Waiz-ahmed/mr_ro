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
        Schema::table('credit_customers', function (Blueprint $table) {
            $table->unsignedBigInteger('daily_sale_id')->after('customer_id');

            // Optional: add foreign key constraint if needed
            $table->foreign('daily_sale_id')->references('id')->on('daily_sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('credit_customers', function (Blueprint $table) {
            $table->dropForeign(['daily_sale_id']);
            $table->dropColumn('daily_sale_id');
        });
    }
};
