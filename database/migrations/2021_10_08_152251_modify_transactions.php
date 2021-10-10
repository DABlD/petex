<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table){
            DB::statement("ALTER TABLE transactions CHANGE COLUMN status status ENUM(
                'To Process', 
                'Finding Driver',
                'For Pickup',
                'For Delivery',
                'Delivered',
                'Cancelled'
            ) DEFAULT 'To Process' NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table){
            DB::statement("ALTER TABLE transactions CHANGE COLUMN status status ENUM(
                'To Pay', 
                'Finding Driver',
                'For Pickup',
                'For Delivery',
                'Delivered',
                'Cancelled'
            ) DEFAULT 'To Pay' NOT NULL");
        });
    }
}
