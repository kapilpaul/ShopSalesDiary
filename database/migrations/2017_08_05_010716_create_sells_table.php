<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no')->unique();
            $table->integer('customer_id');
            $table->string('product_code')->nullable()->unique();
            $table->integer('stock_id');
            $table->integer('quantity');
            $table->integer('discount');
            $table->integer('total_amount');
            $table->string('gifts')->nullable();
            $table->string('service')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('sells');
    }
}
