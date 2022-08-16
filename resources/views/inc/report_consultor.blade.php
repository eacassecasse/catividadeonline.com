@foreach($consultoresSeleccionados as $cons)

    @php
        $somaReceita = 0;
        $somaCustoFixo = 0;
        $somaComissao = 0;
        $somaLucro = 0;
    @endphp

<table class="table table-striped table-hover my-5">
    <thead>
        <tr>
            <th scope="row" colspan="5">{{ $cons[0]->no_usuario}}</th>
        </tr>
        <tr>
            <th scope="col">Per&iacute;odo</th>
            <th scope="col">Receita L&iacute;quida</th>
            <th scope="col">Custo Fixo</th>
            <th scope="col">Comiss&atilde;o</th>
            <th scope="col">Lucro</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($receita_comissao as $receitasIndividuais)
            @foreach ($receitasIndividuais as $receita)
                @if($receita->consultor === $cons[0]->no_usuario)
                    @php
                        $somaReceita += $receita->receita_liquida;

                        $somaComissao += $receita->comissao;

                        foreach ($custo_fixo as $custo) {
                            # code...
                            if (count($custo) > 0) {
                                if ($receita->consultor === $custo[0]->no_usuario) {
                                    $somaCustoFixo += $custo[0]->brut_salario;
                                    $somaLucro += $receita->receita_liquida - ($custo[0]->brut_salario + $receita->comissao);
                                }
                            }
                        }
                    @endphp

                    <tr>
                        <td>{{ $meses[$receita->mes_emissao - 1 ] ."-" .$receita->ano_emissao }}</td>
                        <td>{{ number_format($receita->receita_liquida, 2) }}</td>
                        @foreach($custo_fixo as $custo)
                            @if (count($custo) > 0)
                                @if($receita->consultor === $custo[0]->no_usuario)
                                    <td>{{ number_format($custo[0]->brut_salario, 2) }}</td>
                                @endif
                            @endif
                        @endforeach
                        <td>{{ number_format($receita->comissao, 2) }}</td>

                        @foreach($custo_fixo as $custo)
                            @if (count($custo) > 0)
                                @if($receita->consultor === $custo[0]->no_usuario)
                                    <td>{{ number_format($receita->receita_liquida - ($custo[0]->brut_salario + $receita->comissao), 2)}}</td>
                                @endif
                            @endif
                        @endforeach
                    </tr>

                @endif
            @endforeach
        @endforeach

        <tr>
            <td><strong class="strong">SALDO</strong></td>
            <td>{{ number_format($somaReceita, 2) }}</td>
            <td>{{ number_format($somaCustoFixo, 2) }}</td>
            <td>{{ number_format($somaComissao, 2) }}</td>
            <td>{{ number_format($somaLucro, 2) }}</td>
        </tr>

    </tbody>
</table>
@endforeach

