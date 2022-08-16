@extends('layouts.index')


@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                @if($result === 'tabela')
                    @include('inc.report_cliente')
                @else
                    @if ($result === 'barra')
                        @include('inc.line_cliente')
                    @else
                        @if ($result === 'pizza')
                            @include('inc.pie_cliente')
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
