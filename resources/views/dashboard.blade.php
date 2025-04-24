use App\Http\Controllers\DashboardController.php;
@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
    <h1>Dashboard</h1>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ \$faltasHoje }}</h3>
                <p>Faltas Hoje</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-times"></i>
            </div>
            <a href="#" class="small-box-footer">Ver mais <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ \$totalFuncionarios }}</h3>
                <p>Funcionários Ativos</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">Detalhes <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Faltas na Semana</div>
            <div class="card-body">
                <canvas id="faltasSemanaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach(\$funcionarios as \$funcionario)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ \$funcionario->nome }}</div>
                <div class="card-body">
                    <p><strong>Cargo:</strong> {{ \$funcionario->cargo }}</p>
                    <p><strong>Entradas Recentes:</strong></p>
                    <ul>
                        @foreach(\$funcionario->pontos->sortByDesc('data')->take(5) as \$ponto)
                            <li>{{ \$ponto->data }} - Entrada: {{ \$ponto->entrada }} | Saída: {{ \$ponto->saida }}</li>
                        @endforeach
                    </ul>
                    <p><strong>Faltas Recentes:</strong></p>
                    <ul>
                        @foreach(\$funcionario->faltas->sortByDesc('data')->take(3) as \$falta)
                            <li>{{ \$falta->data }} - Motivo: {{ \$falta->motivo }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Chart.js para o gráfico -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('faltasSemanaChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($faltasSemana->keys()) !!},
            datasets: [{
                label: 'Faltas por Dia',
                data: {!! json_encode($faltasSemana->values()) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.6)'
            }]
        }
    });
</script>
@endsection
