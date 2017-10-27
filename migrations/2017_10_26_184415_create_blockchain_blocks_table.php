<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockchainBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash')->unique();
            $table->integer('confirmations');
            $table->integer('size');
            $table->integer('height');
            $table->integer('version');
            $table->string('merkleroot');
            $table->integer('time');
            $table->integer('nonce');
            $table->string('bits');
            $table->decimal('difficulty', 15, 8);
            $table->string('previousblockhash');
            $table->string('nextblockhash');
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
        Schema::dropIfExists('blockchain_blocks');
    }
}
