@php
    // Objecto que armazena os dados que serão passados para a pizza
    $dataContent = new StdClass();
    $dataContent->name = 'Participacao';
    $dataContent->colorByPoint = true;
    $receitas = array();
    $participacoesNaReceita = array();
    $receitaGeral = 0;
@endphp

@foreach($consultoresSeleccionados as $cons)

    @php
        $receitaPessoal = 0;

    @endphp

        @foreach ($receita_comissao as $receitasIndividuais)
            @foreach ($receitasIndividuais as $receita)
                @if($receita->consultor === $cons[0]->no_usuario)
                    @php
                        $receitaPessoal += $receita->receita_liquida;
                    @endphp
                @endif
            @endforeach
        @endforeach

        @if($receitaPessoal > 0)
            @php
                $receitas[$cons[0]->no_usuario] = round($receitaPessoal, 2);
            @endphp
        @endif
@endforeach


<!-- Soma as receitas para obter a receita geral -->
@foreach ($receitas as $receita)
    @php
        $receitaGeral += $receita;
    @endphp
@endforeach


@foreach ($consultoresSeleccionados as $consultor)
    @foreach ($receitas as $nome => $receita)
       @if ($nome === $consultor[0]->no_usuario)
           @php
               array_push($participacoesNaReceita, [
                'consultor' => $consultor[0]->no_usuario,
                'percentagem' => ($receita/$receitaGeral)*100
                ]);
           @endphp
       @endif
    @endforeach
@endforeach

@php
    //Variavel que agrupa os objectos que serão exibidos
    $dadosDosConsultores = array();
@endphp

 @foreach ($participacoesNaReceita as $participacao)
     @php
        $consultantPercent = new StdClass();
        $consultantPercent->name = $participacao['consultor'];
        $consultantPercent->y = $participacao['percentagem'];

        array_push($dadosDosConsultores, $consultantPercent);
     @endphp
 @endforeach

@php
   $dataContent->data = $dadosDosConsultores;

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


