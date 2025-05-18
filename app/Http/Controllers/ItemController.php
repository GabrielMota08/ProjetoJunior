<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function create(){
        return view('items.create');
    }

    public function store(Request $request){

        $item = new Item;

        $item->nome = $request->nome;
        $item->valor = $request->valor; 
        
        $item->save();

        return redirect('/')->with("msg", "Item cadastrado com sucesso");;
    }
}
