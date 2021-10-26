<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTransactionAddRiderCancel extends Migration
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
                'Cancelled',
                'Rider Cancel'
            ) DEFAULT 'To Process' NOT NULL");
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->timestamp('rider_cancel')->nullable()->after('status');
            $table->smallInteger('rating')->nullable();
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
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('rider_cancel');
            $table->dropColumn('rating');
        });
    }
}
