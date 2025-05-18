<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_venda')
                    ->withPivot('quantidade', 'preco_unitario')
                    ->withTimestamps();
    }

    protected $fillable = [
        'cliente_id',
        'data',
        'valor_total',
    ];
}
