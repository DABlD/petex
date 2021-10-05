<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('sid');
            // $table->string('tid', 13);
            $table->string('fname');
            $table->string('lname');
            $table->string('contact');

            $table->text('address');
            $table->text('lat');
            $table->text('lng');

            $table->float('price', 8, 2);
            $table->enum('status', ['To Pay', 'Finding Driver', 'For Pickup', 'For Delivery', 'Delivered', 'Cancelled'])->defaut('To Pay');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
