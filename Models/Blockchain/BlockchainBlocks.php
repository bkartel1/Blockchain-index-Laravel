<?php

namespace App\Models\Blockchain;

use Illuminate\Database\Eloquent\Model;

class BlockchainBlocks extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blockchain_blocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash', 
        'confirmations', 
        'size', 
        'height', 
        'version', 
        'merkleroot', 
        'time', 
        'nonce', 
        'bits', 
        'difficulty', 
        'previousblockhash', 
        'nextblockhash',
        'created_at',
    ];
}
