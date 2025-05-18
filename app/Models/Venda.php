<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_venda')
                    ->withPivot('quantidade', 'preco_unitario')
                    ->withTimestamps();
    }

    public function parcelas()
    {
        return $this->hasMany(Parcela::class);
    }

    protected $fillable = [
        'cliente_id',
        'data',
        'valor_total',
    ];
}