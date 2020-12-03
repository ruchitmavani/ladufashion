<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('party_id')->nullable();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('gst')->nullable();
            $table->date('bill_date');
            $table->date('due_date');
            $table->integer('bill_no');
            $table->string('shipping')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_place')->nullable();
            $table->string('challan')->nullable();
            $table->date('challan_date')->nullable();
            $table->text('products');
            $table->float('total_amount');
            $table->float('discount');
            $table->float('cgst');
            $table->float('sgst');
            $table->float('igst');
            $table->float('final_amount');
            $table->string('bank')->nullable();
            $table->string('account_no')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('file_name');
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
        Schema::dropIfExists('bills');
    }
}
