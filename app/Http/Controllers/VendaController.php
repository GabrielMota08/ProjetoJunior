<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Item;
use App\Models\Parcela;
use App\Models\ItemVenda;

class VendaController extends Controller
{
    public function index(){

        $vendas = Venda::with(['cliente', 'items', 'parcelas'])
                    ->orderBy('data', 'desc')
                    ->paginate(50);

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

    public function store(Request $request)
    {
        $itens = json_decode($request->itens_adicionados, true);
        $parcelas = json_decode($request->parcelas, true);

        $valor_total = 0;
        foreach ($itens as $item) {
            $valor_total += $item['valor'] * $item['quantidade'];
        }

        $venda = new Venda();
        $venda->cliente_id = $request->cliente_id;
        $venda->valor_total = $valor_total;
        $venda->data = now();
        $venda->save();

        foreach ($itens as $item) {
            ItemVenda::create([
                'venda_id' => $venda->id,
                'item_id' => $item['id'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $item['valor'],
            ]);
        }

        foreach ($parcelas as $index => $parcela) {
            $dataVencimento = \Carbon\Carbon::now()->startOfMonth()->addMonths($index)->day($parcela['dia']);

            Parcela::create([
                'venda_id' => $venda->id,
                'numero' => $index + 1,
                'valor' => $parcela['valor'],
                'data_vencimento' => $dataVencimento,
            ]);
        }

        return redirect('/')->with('msg', 'Venda registrada com sucesso!');
    }

    public function paymentIndex(Request $request){       

        $itens = json_decode($request ->itens_adicionados, true);
        $cliente_id = $request->cliente_id;

        $valor_total = 0;
        foreach($itens as $item){
            $valor_total += $item['valor'] * $item['quantidade'];
        }

        $cliente = Cliente::find($cliente_id);

        return view('pagamento.index', compact('itens', 'cliente', 'valor_total'));

    }

    public function destroy($venda_id){

        Venda::destroy($venda_id);
        return redirect('/vendas')->with('msg', 'Projeto excluído com suceso!');

    }
}
