<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stockin_id')->unique();
            $table->integer('product_id')->unsigned();
            $table->string('color')->nullable();
            $table->integer('buying_price')->unsigned();
            $table->integer('selling_price')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->bigInteger('amount')->unsigned();
            $table->bigInteger('paid')->nullable();
            $table->bigInteger('due')->nullable();
            $table->date('date');
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('stocks');
    }
}
