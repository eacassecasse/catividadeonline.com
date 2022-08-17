@extends('layouts.app')

@section('forms')
    <div class="row">
        <div class="col-12 my-2 py-4 container">
            <form action="{{ route('consultores') }}" class="needs-validation" id="search">

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="btn-group" role="group" id="group-selector"
                             aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnOptions" id="btnConsultores"
                                   value="consultores" autocomplete="off"
                                   @if(old('btnOptions') === null)
                                       {{ 'checked' }}
                                   @elseif(old('btnOptions') === 'consultores')
                                       {{'checked'}}
                                   @endif data-url="{{ route('consultores') }}">
                            <label class="btn btn-outline-secondary" for="btnConsultores">Consultores</label>

                            <input type="radio" class="btn-check" name="btnOptions" id="btnClientes" value="clientes"
                                   autocomplete="off"
                                   @if(old('btnOptions') === 'clientes')
                                       {{ 'checked' }}
                                   @endif data-url="{{ route('clientes') }}">
                            <label class="btn btn-outline-secondary" for="btnClientes">Clientes</label>
                        </div>
                    </div>
                </div>


                <div class="form-group row" id="consultor-group">
                    <label class="col-7 col-lg-3 ms-2 ms-lg-0 py-2 py-lg-1" for="consultores">
                        <strong>Selecciona o(s) Consultor(es)</strong>
                    </label>

                    <div class="col-12 col-lg-4 px-3 pe-4 ps-lg-0">
                        <select
                            class="form-control select-picker custom-select @error('consultores') is-invalid @enderror"
                            name="consultores[]" id="consultores" multiple>
                            @foreach($consultores as $consultor)
                                <option>{{$consultor->no_usuario}}</option>
                            @endforeach
                        </select>
                        @error('consultores')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row d-none" id="cliente-group">
                    <label class="col-7 col-lg-3 ms-2 ms-lg-0 py-2 py-lg-1" for="clientes">
                        <strong>Selecciona o(s) Cliente(s)</strong>
                    </label>

                    <div class="col-12 col-lg-4 px-3 pe-4 ps-lg-0">
                        <select class="form-control select-picker custom-select @error('clientes') is-invalid @enderror"
                                name="clientes[]" id="clientes" multiple>
                            @foreach ($clientes as $cliente)
                                <option>
                                    {{ $cliente->no_cliente }}
                                </option>
                            @endforeach
                        </select>

                        @error('clientes')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                @php
                    $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

                    $anos = [2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022];
                @endphp

                    <!-- Data de Inicio da Analise -->
                <div class="form-group row my-3">
                    <!--Mês de Inicio-->
                    <label class="col-3 col-lg-1 pe-0 ms-2 ms-lg-0 py-2" for="mesInicio">
                        <strong>M&ecirc;s In&iacute;cio</strong>
                    </label>

                    <div class="col-3 col-lg-2 ps-0">
                        <select class="form-control custom-select" name="mesInicio" id="mesInicio">
                            @foreach ($meses as $mes)
                                <option>
                                    {{ $mes }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Ano de Inicio-->
                    <label class="col-3 col-lg-2 pe-0 ms-1 ms-lg-0 py-2" for="anoInicio">
                        <strong>Ano de In&iacute;cio</strong>
                    </label>

                    <div class="col-2 col-lg-1 px-0">
                        <select class="form-control custom-select mx-0" name="anoInicio" id="anoInicio">
                            @foreach ($anos as $ano)
                                <option>
                                    {{ $ano }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Data de Fim da Analise -->
                <div class="form-group row my-3">
                    <!--Mês de Fim-->
                    <label class="col-3 col-lg-1 pe-0 ms-2 ms-lg-0 py-2" for="mesFim">
                        <strong>M&ecirc;s Fim</strong>
                    </label>

                    <div class="col-3 col-lg-2 ps-0">
                        <select class="form-control custom-select" name="mesFim" id="mesFim">
                            @foreach ($meses as $mes)
                                <option>
                                    {{ $mes }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Ano de Fim-->
                    <label class="col-3 col-lg-2 pe-0 ms-1 ms-lg-0 py-2" for="anoFim">
                        <strong>Ano de Fim</strong>
                    </label>

                    <div class="col-2 col-lg-1 px-0">
                        <select class="form-control custom-select mx-0" name="anoFim" id="anoFim">
                            @foreach ($anos as $ano)
                                <option>
                                    {{ $ano }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <span class="text-danger error-text date_error"></span>
                </div>

                <!-- Botões de Escolha do Resultado-->
                <div class="btn-group btn-group-toggle">
                    <button class="btn btn-outline-primary" type="submit" name="submitButton"
                            value="report">Relat&oacute;rio
                    </button>
                    <button class="btn btn-outline-primary" type="submit" name="submitButton"
                            value="barChart">Gr&aacute;fico
                    </button>
                    <button class="btn btn-outline-primary" type="submit" name="submitButton"
                            value="pieChart">Pizza
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection
