<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('customer_email')->nullable();
            $table->string('customer_first_name')->nullable();
            $table->string('customer_last_name')->nullable();
            //pending: 部分功能有待完善
            $table->string('shipping_method')->nullable();
            $table->boolean('is_gift')->default(0);
            $table->integer('items_count')->nullable();
            $table->decimal('items_qty', 12, 4)->nullable();
            $table->string('cart_currency_code')->nullable();

            $table->decimal('grand_total', 12, 4)->default(0)->nullable();
            $table->decimal('base_grand_total', 12, 4)->default(0)->nullable();

            $table->decimal('sub_total', 12, 4)->default(0)->nullable();
            $table->decimal('base_sub_total', 12, 4)->default(0)->nullable();

            $table->decimal('tax_total', 12, 4)->default(0)->nullable();
            $table->decimal('base_tax_total', 12, 4)->default(0)->nullable();

            $table->decimal('discount', 12, 4)->default(0)->nullable();
            $table->decimal('base_discount', 12, 4)->default(0)->nullable();

            $table->string('checkout_method')->nullable();
            $table->boolean('is_guest')->nullable();
            $table->boolean('is_active')->nullable()->default(1);
            $table->dateTime('conversion_time')->nullable();

            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('carts');
    }
}
