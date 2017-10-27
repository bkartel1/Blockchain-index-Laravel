<?php

namespace App\Models\Blockchain;

use Illuminate\Database\Eloquent\Model;

class BlockchainTransactions extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blockchain_transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hex', 'version', 'locktime', 'block', 'confirmations', 'tx', 'blocktime', 'created_at'];


}


