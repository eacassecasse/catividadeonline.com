@extends('layouts.index')


@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                @if($result === 'tabela')
                    @include('inc.report_consultor')
                @else
                    @if ($result === 'barra')
                        @include('inc.bar_consultor')
                    @else
                        @if ($result === 'pizza')
                            @include('inc.pie_consultor')
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
