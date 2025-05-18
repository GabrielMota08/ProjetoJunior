<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessLog;
use Illuminate\Support\Facades\Log;

class AccessLogController extends Controller
{
    public function store(Request $request, $dadosSolicitados)
    {
        $data = json_decode(file_get_contents(storage_path('app/dados.json')), true);
        $sicad = $data['SICAD'];

        $dadosSolicitados = json_decode($dadosSolicitados, true);
        $dadosSolicitados = collect($sicad['dadosSolicitados'])->whereIn('id', $request->ids)->toArray();
        $cpf_viewed = array_column($dadosSolicitados, 'cpf');

        $log = AccessLog::create([
            'user_ip' => $request->ip(),
            'user_token' => $request->header('Authorization'),
            'cpf_viewed' => $cpf_viewed,
            'viewed' => $dadosSolicitados
        ]);

        return response()->json($log, 201);
    }

    public function index()
    {
        $logs = AccessLog::all();
        return view('accessLogs.index', compact('logs'));
    }
}