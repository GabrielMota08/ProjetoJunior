<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{

    public function create(){
        return view('clientes.create');
    }

    public function store(Request $request){
        $request->validate([
            'cpf' => ['required', 'string', 'max:14', function ($attribute, $value, $fail) {
                if (!self::validarCPF($value)) {
                    $fail('O CPF informado não é válido.');
                }
            }],
        ]);

        $cliente = new Cliente;
        $cliente->nome = $request->nome;
        $cliente->cpf = $request->cpf;
        $cliente->save();

        return redirect('/')->with('msg', 'Cliente cadastrado com sucesso');
    }
    public static function validarCPF($cpf){
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
