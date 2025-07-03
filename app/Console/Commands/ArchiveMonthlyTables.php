<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArchiveMonthlyTables extends Command
{
    protected $signature = 'archive:monthly-tables';
    protected $description = 'Create monthly tables for credit_customers and daily_sales';

    public function handle()
    {
        $month = strtolower(Carbon::now()->subMonth()->format('F'));
        $year = Carbon::now()->subMonth()->year;

        $creditTable = "credit_customers_{$month}_{$year}";
        $saleTable = "daily_sale_{$month}_{$year}";

        // Check if they already exist
        if (Schema::hasTable($creditTable) || Schema::hasTable($saleTable)) {
            $this->warn("Tables for {$month} {$year} already exist.");
            return;
        }

        // Clone daily_sales
        DB::statement("CREATE TABLE {$saleTable} LIKE daily_sales");
        DB::statement("INSERT INTO {$saleTable} SELECT * FROM daily_sales WHERE MONTH(sale_date) = ? AND YEAR(sale_date) = ?", [Carbon::now()->subMonth()->month, $year]);

        // Clone credit_customers
        DB::statement("CREATE TABLE {$creditTable} LIKE credit_customers");
        DB::statement("INSERT INTO {$creditTable} SELECT * FROM credit_customers WHERE MONTH(credit_date) = ? AND YEAR(credit_date) = ?", [Carbon::now()->subMonth()->month, $year]);

        $this->info("Tables {$saleTable} and {$creditTable} created successfully.");
    }
}
