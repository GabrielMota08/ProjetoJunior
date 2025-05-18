<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVenda extends Model
{
    protected $table = 'item_venda';

    protected $fillable = [
        'venda_id',
        'item_id',
        'quantidade',
        'preco_unitario',
    ];
}