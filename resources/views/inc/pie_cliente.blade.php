@php
    // Objecto que armazena os dados que serão passados para a pizza
    $dataContent = new StdClass();
    $dataContent->name = 'Participacao';
    $dataContent->colorByPoint = true;
    $receitas = array();
    $participacoesNaReceita = array();
    $receitaGeral = 0;
@endphp

@foreach($clientesSeleccionados as $client)

    @php
        $receitaPessoal = 0;
        
    @endphp
        
        @foreach ($receita_liquida as $receitasIndividuais)
            @foreach ($receitasIndividuais as $receita)
                @if($receita->cliente === $client[0]->no_cliente)
                    @php
                        $receitaPessoal += $receita->receita_liquida;
                    @endphp
                @endif
            @endforeach 
        @endforeach

        @if($receitaPessoal > 0)
            @php
                $receitas[$client[0]->no_cliente] = round($receitaPessoal, 2);
            @endphp
        @endif
@endforeach


<!-- Soma as receitas para obter a receita geral -->
@foreach ($receitas as $receita)
    @php
        $receitaGeral += $receita;   
    @endphp
@endforeach


@foreach ($clientesSeleccionados as $cliente)
    @foreach ($receitas as $nome => $receita)
       @if ($nome === $cliente[0]->no_cliente)
           @php
               array_push($participacoesNaReceita, [
                'cliente' => $cliente[0]->no_cliente,
                'percentagem' => ($receita/$receitaGeral)*100
                ]);
           @endphp
       @endif
    @endforeach
@endforeach

@php
    //Variavel que agrupa os objectos que serão exibidos
    $dadosDosClientes = array();   
@endphp

 @foreach ($participacoesNaReceita as $participacao)
     @php
        $clientPercent = new StdClass();
        $clientPercent->name = $participacao['cliente'];
        $clientPercent->y = $participacao['percentagem'];
        
        array_push($dadosDosClientes, $clientPercent);
     @endphp
 @endforeach

@php
   $dataContent->data = $dadosDosClientes;
   
   $data = array($dataContent);
@endphp
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6 mx-auto">
        <div id="charts"></div>
        </div>
    </div>
</div>
@endsection

@push('footer-scripts')
 <script>

var data = <?php echo json_encode($data) ?>;

Highcharts.chart('charts', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Participação na Receita'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: data
});

 </script>   
@endpush


