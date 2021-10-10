<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->timestamp('assigned_time')->nullable()->after('status');
            $table->timestamp('pickup_time')->nullable()->after('assigned_time');
            $table->timestamp('delivery_time')->nullable()->after('pickup_time');
            $table->string('eta')->nullable()->after('delivery_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('assigned_time');
            $table->dropColumn('pickup_time');
            $table->dropColumn('delivery_time');
            $table->dropColumn('eta');  
        });
    }
}
