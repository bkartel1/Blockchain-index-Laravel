<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockchainTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_transaction_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('txid')->nullable();
            $table->string('account')->nullable();
            $table->string('address')->nullable();
            $table->string('category')->nullable();
            $table->integer('confirmations')->nullable();
            $table->decimal('amount', 12,6)->nullable();
            $table->decimal('fee', 12,6)->nullable();
            $table->string('label')->nullable();
            $table->string('vout')->nullable();
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
        Schema::dropIfExists('blockchain_transaction_details');
    }
}
