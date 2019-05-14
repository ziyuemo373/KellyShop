<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku')->nullable();
            $table->string('type')->nullable();
            $table->string('name')->nullable();

            $table->decimal('weight', 12,4)->default(0)->nullable();
            $table->decimal('total_weight', 12,4)->default(0)->nullable();

            $table->integer('qty_ordered')->default(0)->nullable();
            $table->decimal('price', 12,4)->default(0);
            $table->decimal('base_price', 12,4)->default(0);
            $table->decimal('total', 12,4)->default(0);
            $table->decimal('base_total', 12,4)->default(0);

            $table->integer('product_id')->unsigned()->nullable();
            $table->string('product_type')->nullable();
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->json('additional')->nullable();
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
        Schema::dropIfExists('order_items');
    }
}
