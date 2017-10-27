<?php

namespace App\Console\Commands;

use App\Models\Blockchain\BlockchainBlocks;
use App\Models\Blockchain\BlockchainTransactionDetails;
use App\Models\Blockchain\BlockchainTransactions;
use Denpa\Bitcoin\Client as BitcoinClient;
use Illuminate\Console\Command;

class StoreBlockchain extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:store-blockchain';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(BitcoinClient $bitcoin)
    {
        $index = BlockchainBlocks::orderBy('id', 'desc')->first()->id + 1;

        while ($index < $bitcoin->getblockcount()->get()) {

            $blockhash = $bitcoin->getblockhash($index)->get();

            $block = $bitcoin->getblock($blockhash)->get();

            // store the block information
            $this->createBlock($block);

            foreach ($block['tx'] as $transaction) {

                try
                {
                    // raw transaction
                    $rawTransaction = $bitcoin->getrawtransaction($transaction, 1)->get();

                    $this->createTransaction($rawTransaction);

                    // transaction
                    $transaction = $bitcoin->gettransaction($transaction)->get();

                    foreach ($transaction['details'] as $details) {
                        $this->createTransactionDetails($transaction, $details); // store the raw details
                    }

                } catch (\Denpa\Bitcoin\Exceptions\BitcoindException $ex) {
                    //ignore error
                }

            }

            $index++;
        }

    }

    /**
     * Store the block information
     *
     * @param $blockInformation
     * @return void
     */
    protected function createBlock($blockInformation)
    {
        $blockAttributes = [
            'hash'              => $blockInformation['hash'] ?? null,
            'confirmations'     => $blockInformation['confirmations'] ?? null,
            'size'              => $blockInformation['size'] ?? null,
            'height'            => $blockInformation['height'] ?? null,
            'version'           => $blockInformation['version'] ?? null,
            'merkleroot'        => $blockInformation['merkleroot'] ?? null,
            'time'              => $blockInformation['time'] ?? null,
            'nonce'             => $blockInformation['nonce'] ?? null,
            'bits'              => $blockInformation['bits'] ?? null,
            'difficulty'        => $blockInformation['difficulty'] ?? null,
            'previousblockhash' => $blockInformation['previousblockhash'] ?? null,
            'nextblockhash'     => $blockInformation['nextblockhash'] ?? null,
            'created_at'        => \Carbon\Carbon::now()->toDateTimeString(),
        ];

        try
        {
            \DB::transaction(function () use ($blockAttributes) {
                BlockchainBlocks::insert($blockAttributes);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->getMessage());
        }

    }

    /**
     * Store the transaction
     *
     * @param $transaction
     * @return void
     */
    protected function createTransaction($transaction)
    {
        $blockchainAttributes = [
            'hex'           => $transaction["hex"],
            'txid'          => $transaction["txid"],
            'version'       => $transaction["version"],
            'locktime'      => $transaction["confirmations"],
            'blockhash'     => $transaction["blockhash"],
            'confirmations' => $transaction["confirmations"],
            'time'          => $transaction["time"],
            'blocktime'     => $transaction["blocktime"],
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ];

        try
        {
            \DB::transaction(function () use ($blockchainAttributes) {
                BlockchainTransactions::insert($blockchainAttributes);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // ignore the error.
        }

    }

    /**
     * Store the transaction details
     *
     * @param $transaction
     * @return void
     */
    protected function createTransactionDetails($transaction, $details)
    {
        $blockchainAttributes = [
            'txid'          => $transaction["txid"],
            'account'       => $details["account"],
            'address'       => $details["address"],
            'category'      => $details["category"],
            'confirmations' => $transaction["confirmations"],
            'amount'        => $details["amount"],
            'label'         => $transaction["label"] ?? null,
            'vout'          => $details["vout"],
            'fee'           => $transaction["fee"] ?? null,
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ];

        try
        {
            \DB::transaction(function () use ($blockchainAttributes) {
                BlockchainTransactionDetails::insert($blockchainAttributes);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // ignore the error
        }

    }

}
