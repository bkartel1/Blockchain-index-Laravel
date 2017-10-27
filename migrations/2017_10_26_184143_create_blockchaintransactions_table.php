<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockchaintransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('hex');
            $table->string('txid');
            $table->integer('version');
            $table->integer('locktime');
            $table->string('blockhash');
            $table->integer('confirmations');
            $table->integer('time');
            $table->integer('blocktime');
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
        Schema::dropIfExists('blockchaintransactions');
    }
}
