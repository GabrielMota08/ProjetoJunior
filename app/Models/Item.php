<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function vendas()
    {
        return $this->belongsToMany(Venda::class, 'item_venda')
                    ->withPivot('quantidade', 'preco_unitario')
                    ->withTimestamps();
    }

    protected $fillable = [
    'nome',
    'valor',
   ];
}
