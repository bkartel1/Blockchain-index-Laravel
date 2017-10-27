<?php

namespace App\Models\Blockchain;

use Illuminate\Database\Eloquent\Model;

class BlockchainTransactionDetails extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blockchain_transaction_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tx',
        'account', 
        'address', 
        'category', 
        'confirmations', 
        'amount', 
        'label',
        'vout',
        'fee',
        'abandoned',
        'created_at'
    ];
}
