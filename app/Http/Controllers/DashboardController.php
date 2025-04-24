<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{public function index()
    {
        $totalFuncionarios = Funcionario::count();
        $faltasHoje = Falta::whereDate('data', today())->count();

        // Gráfico de faltas nos últimos 7 dias
        $faltasSemana = Falta::where('data', '>=', now()->subDays(7))
            ->selectRaw('DATE(data) as dia, COUNT(*) as total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->pluck('total', 'dia');

        // Dados por funcionário
        $funcionarios = Funcionario::with(['pontos', 'faltas'])->get();

        return view('dashboard', compact(
            'totalFuncionarios', 'faltasHoje', 'faltasSemana', 'funcionarios'
        ));
    }
}


