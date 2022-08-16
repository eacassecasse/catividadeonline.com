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

@foreach($clientesSeleccionados as $client)

    @php
        $somaReceita = 0;
        $receitasPessoais = array();
    @endphp


        @foreach ($receita_liquida as $receitasIndividuais)

            @php
                $receitaLiquidaMensal = [];
            @endphp

            @foreach ($receitasIndividuais as $receita)
                @if($receita->cliente === $client[0]->no_cliente)

                    @php
                        array_push($receitaLiquidaMensal, array($client[0]->no_cliente, $receita->mes_emissao, round($receita->receita_liquida, 2)));
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

@foreach ($clientesSeleccionados as $cs)

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
                        @if ($cs[0]->no_cliente === $receita[0])
                            @php
                                $data[$receita[1] - 1] = $receita[2];
                            @endphp
                        @endif
                    @endforeach
                @endforeach
            @endforeach

            @php
                $object = new StdClass();
                $object->name = $cs[0]->no_cliente;
                $object->data = $data;

                array_push($jsonArray, $object);
            @endphp
        @endforeach


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

 var data = <?php echo json_encode($jsonArray)?>;
 var labels = <?php echo json_encode($labels) ?>;
 var subtitle = <?php echo json_encode($subtitle) ?>

var colors = Highcharts.getOptions().colors;

Highcharts.chart('charts', {
    chart: {
        type: 'spline'
    },

    legend: {
        symbolWidth: 40
    },

    title: {
        text: 'Receita Liquida dos Clientes'
    },

    subtitle: {
        text: subtitle
    },

    yAxis: {
        title: {
            text: 'Receita Liquida'
        },
        accessibility: {
            description: 'Receita Liquida'
        }
    },

    xAxis: {
        title: {
            text: 'Clientes'
        },
        accessibility: {
            description: 'Clientes'
        },
        categories: labels
    },

    tooltip: {
        valueSuffix: ''
    },

    plotOptions: {
        series: {
            point: {
                events: {
                    click: function () {
                        window.location.href = this.series.options.website;
                    }
                }
            },
            cursor: 'pointer'
        }
    },

    series: data,

    responsive: {
        rules: [{
            condition: {
                maxWidth: 550
            },
            chartOptions: {
                chart: {
                    spacingLeft: 3,
                    spacingRight: 3
                },
                legend: {
                    itemWidth: 150
                },
                xAxis: {
                    categories: labels,
                    title: ''
                },
                yAxis: {
                    visible: false
                }
            }
        }]
    }
});

 </script>
@endpush


