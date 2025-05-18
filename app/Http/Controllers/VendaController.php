<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Item;

class VendaController extends Controller
{
    public function index(){

        $vendas = Venda::all();
        return view('vendas.index', compact('vendas'));
    }

    public function create(Request $request){
        $clientes = Cliente::all();
        $items = Item::all();
        if ($request->has('cliente_id')) {
            $cliente_selecionado = Cliente::find($request->cliente_id);
        } else {
            $cliente_selecionado = null;
        }

        return view('vendas.create', compact('clientes', 'items', 'cliente_selecionado'));
    }

    public function store(Request $request){

        $venda = new Venda;

        $venda->cliente_id = $request->cliente_id;
        $venda->valor_total = $request->valor_total;

        $venda->save();

        $items = json_decode($request->input('items'[0], true));
        $itemsIds = [];

        foreach($items as $i){
            $item = Item::where(['nome' => $i['value']]);
            $itemsIds[] = $item->id;
        }
        $venda->items()->attach($itemsIds);

        return redirect('/')->with("msg", "Venda registrada com sucesso");
    }

    public function destroy(){

    }
}
