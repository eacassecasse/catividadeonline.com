@php
    $receitasGerais = array();

    $labels = [
        'Jan',
        'Fev',
        'Mar',
        'Abr',
        'Maio',
        'Jun',
        'Jul',
        'Ago',
        'Set',
        'Out',
        'Nov',
        'Dez'
    ];

    $subtitle = $meses[$mes_inicio - 1] ." de " .$ano_inicio ." a " .$meses[$mes_fim - 1] ." de " .$ano_fim;
    $custoMedio = 0;
    $somaCustoFixo = 0;


@endphp

@foreach($consultoresSeleccionados as $cons)

    @foreach($custo_fixo as $custo)
        @if (count($custo) > 0)
            @if($cons[0]->no_usuario === $custo[0]->no_usuario)
                @php
                    $somaCustoFixo += $custo[0]->brut_salario;
                @endphp
            @endif
        @endif
    @endforeach

    @php
        $somaReceita = 0;
        $receitasPessoais = array();
    @endphp


    @foreach ($receita_comissao as $receitasIndividuais)

        @php
            $receitaLiquidaMensal = [];
        @endphp

        @foreach ($receitasIndividuais as $receita)
            @if($receita->consultor === $cons[0]->no_usuario)

                @php
                    array_push($receitaLiquidaMensal,
                    array(
                        $cons[0]->no_usuario,
                        $receita->mes_emissao,
                        round($receita->receita_liquida, 2)
                        )
                        );
                @endphp

            @endif
        @endforeach

        @php
            array_push($receitasPessoais, $receitaLiquidaMensal);
        @endphp
    @endforeach

    @php
        array_push($receitasGerais, $receitasPessoais);
    @endphp

@endforeach

@php
    $jsonArray = array();
@endphp

@foreach ($consultoresSeleccionados as $cs)

    @php
        $floatZero = round(0, 2);
        $data = array();

        for($i = 0; $i < 12; $i++) {
            array_push($data, $floatZero);
        }
    @endphp

    @foreach ($receitasGerais as $rPessoais)
        @foreach ($rPessoais as $rLiquida)
            @foreach ($rLiquida as $receita)
                @if ($cs[0]->no_usuario === $receita[0])
                    @php
                        $data[$receita[1] - 1] = $receita[2];
                    @endphp
                @endif
            @endforeach
        @endforeach
    @endforeach

    @php
        $tooltip = new StdClass();
        $tooltip->valueSuffix = '';
        $object = new StdClass();
        $object->name = $cs[0]->no_usuario;
        $object->data = $data;
        $object->type = "column";
        $object->yAxis = 1;
        $object->tooltip = $tooltip;

        array_push($jsonArray, $object);
    @endphp
@endforeach

@php
    $custoMedio = round(($somaCustoFixo/count($consultoresSeleccionados)), 2);

    $linhaDeCustoMedio = array();
    for($i = 0; $i < 12; $i++) {
        array_push($linhaDeCustoMedio, $custoMedio);
    }

    $spline = new StdClass();
    $spline->name = 'Custo Medio';
    $spline->type = 'spline';
    $spline->data = $linhaDeCustoMedio;
    $spline->tooltip = $tooltip;

    array_push($jsonArray, $spline);
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 mx-auto">
                <!-- Chart Rendering area -->
                <div id="charts"></div>
            </div>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>

        var data = <?php echo json_encode($jsonArray) ?>;
        var labels = <?php echo json_encode($labels) ?>;
        var custoMedio = <?php echo json_encode($linhaDeCustoMedio) ?>;
        var subtitle = <?php echo json_encode($subtitle) ?>

        Highcharts.chart('charts', {
            chart: {
                zoomType: 'xy',
                marginBottom: 100,
                options3d: {
                    enabled: false,
                    alpha: 0,
                    beta: 0,
                    depth: 20,
                    viewDistance: 100
                }
            },
            title: {
                text: 'Perfomance Comercial'
            },
            subtitle: {
                text: subtitle
            },
            xAxis: [{
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Custo Medio',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Receita Liquida',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'center',
                x: 0,
                verticalAlign: 'bottom',
                y: 0,
                floating: false,
                type: 'line',
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || // theme
                    'rgba(255,255,255,0.25)'
            },
            series: data
        });

    </script>
@endpush


