<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

class CaoClienteController extends Controller
{
    //
    public function index() {
        $usuariocontroller = new CaoUsuarioController();

        return view('layouts.index')->with(
            ['clientes'=> $this->getClientes(),
            'consultores' => $usuariocontroller->getConsultores()
        ]);
    }

    public function getData(Request $request) {

        $validate = Validator::make($request->all(), [
            "clientes" => "required"
        ], [
            "clientes.required" => 'Seleccione pelo menos 1 cliente.'
        ])->validate();

        switch($request->submitButton) {
            case 'report':
                $result = 'tabela';
                break;
            case 'barChart':
                $result = 'barra';
                break;
            case 'pieChart':
                $result = 'pizza';
                break;
        }

       $clientesSeleccionados = $request->clientes;

        $meses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho',
            'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];

        foreach ($meses as $key => $mes) {
            if ($mes === $request->mesInicio) {
                $mes_inicio = $key + 1;
            }
        }

        foreach ($meses as $key => $mes) {
            if ($mes === $request->mesFim) {
                $mes_fim = $key + 1;
            }
        }

        $ano_inicio = $request->anoInicio;
        $ano_fim = $request->anoFim;

        $consultorcontroller = new CaoUsuarioController();

        return view('perfomance.clientes')
            ->with(
                [
                    'clientes' => $this->getClientes(),
                    'clientesSeleccionados' => $this->getClientesSeleccionados($clientesSeleccionados),
                    'receita_liquida' => $this->getReceitaLiquida(
                        $clientesSeleccionados, $mes_inicio, $ano_inicio, $mes_fim, $ano_fim),
                     'consultores' => $consultorcontroller->getConsultores(),
                     'mes_inicio' => $mes_inicio,
                     'mes_fim' => $mes_fim,
                     'ano_inicio' => $ano_inicio,
                     'ano_fim' => $ano_fim,
                     'meses' => $meses,
                     'result' => $result

                ]
            );

    }

    public function getClientesSeleccionados(array $clientes) {
        $clientesDB = array();

        foreach ($clientes as $cliente) {
            # code...
            $dbClientes = DB::select("
                SELECT
                    no_fantasia AS no_cliente
                FROM
                    cao_cliente
                WHERE
                    no_fantasia = :cliente", ['cliente' => $cliente]);

            array_push($clientesDB, $dbClientes);
        }

        return $clientesDB;
    }


    public function getClientes()
    {
        $clientes = DB::select("
        SELECT
            no_fantasia AS no_cliente
        FROM
            cao_cliente
        WHERE
            tp_cliente = 'A'"
        );

        return $clientes;
    }

    public function getReceitaLiquida(
        array $clientes,
        int $mes_inicio,
        int $ano_inicio,
        int $mes_fim,
        int $ano_fim) {

        $receitasLiquidas = array();
        $data_inicio = $ano_inicio ."-" .$mes_inicio ."-" ."01";
        $data_fim = $ano_fim ."-" .$mes_fim ."-" ."31";

        foreach ($clientes as $cliente) {
            # code...
            $receitaLiquida = DB::select(
                "SELECT
                    cao_cliente.no_fantasia AS cliente,
                    SUM(cao_fatura.valor - (cao_fatura.valor * (cao_fatura.total_imp_inc/100))) AS receita_liquida,
                    MONTH(cao_fatura.data_emissao) AS mes_emissao,
                    YEAR(cao_fatura.data_emissao) AS ano_emissao
                FROM
                    cao_cliente
                INNER JOIN
                    (cao_fatura)
                INNER JOIN
                    (cao_os)
                ON
                    cao_fatura.co_cliente = cao_cliente.co_cliente
                AND
                    cao_os.co_os = cao_fatura.co_os
                AND
                    cao_cliente.no_fantasia = :nome_cliente
                AND
                    cao_fatura.data_emissao BETWEEN :data_inicio AND :data_fim
                GROUP BY cliente, mes_emissao, ano_emissao
                ORDER BY mes_emissao
                ", [
                    'nome_cliente' => $cliente,
                    'data_inicio' => $data_inicio,
                    'data_fim' => $data_fim
                ]);

                array_push($receitasLiquidas, $receitaLiquida);
        }

        return $receitasLiquidas;
    }

}

