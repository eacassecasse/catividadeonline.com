@php
    $receitas = [];
@endphp

@foreach ($clientesSeleccionados as $cliente)
    @php
        $somaReceita = 0;
    @endphp

    @foreach ($receita_liquida as $receita)
        @if(count($receita) > 0)
            @if ($receita[0]->cliente === $cliente[0]->no_cliente)
                @php
                    $somaReceita += $receita[0]->receita_liquida;
                @endphp
            @endif
        @endif    
    @endforeach

    @php
        array_push($receitas, [
            'cliente' => $cliente[0]->no_cliente,
            'receitaTotal' => $somaReceita]);
    @endphp
@endforeach

@section('content')


<table class="table table-striped my-5">
    <thead>
        <tr>
            <th scope="col">Per&iacute;odo</th>
            @foreach ($clientesSeleccionados as $cliente)
                <th scope="col">{{ $cliente[0]->no_cliente }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

        @foreach ($receita_liquida as $receita)
            <tr>
                @if (count($receita) > 0) 
                    <td>{{ $meses[$receita[0]->mes_emissao - 1] ."-" .$receita[0]->ano_emissao }}</td>
                

                    @foreach ($clientesSeleccionados as $cliente)
                        @if ($receita[0]->cliente === $cliente[0]->no_cliente)
                            <td>{{ number_format($receita[0]->receita_liquida, 2) }}</td>
                        @else
                            <td>0.00</td>
                        @endif
                    @endforeach
                @endif
            </tr>
        @endforeach
        <tr>
            <td><strong class="strong">TOTAL</strong></td>
            @foreach($clientesSeleccionados as $cliente)
                @foreach($receitas as $receita)
                    @if($cliente[0]->no_cliente === $receita['cliente'])
                        <td>{{ number_format($receita['receitaTotal'], 2) }}</td>
                    @endif
                @endforeach
            @endforeach
        </tr>

    </tbody>
</table>
@endsection
