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
            $table->string('invoice_no');
            $table->integer('customer_id');
            $table->string('productimei_id')->nullable();
            $table->integer('stock_id');
            $table->integer('quantity');
            $table->integer('discount')->default(0);
            $table->integer('due')->default(0);
            $table->integer('total_amount');
            $table->string('gifts')->nullable();
            $table->string('service')->nullable();
            $table->integer('user_id');
            $table->timestamps();
			$table->softDeletes();
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
