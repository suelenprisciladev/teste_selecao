<?php
namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Repositories\Pmweb_Orders_StatsRepository;

class Pmweb_Orders_StatsController extends Controller
{
    public function lista(){
        return Pmweb_Orders_StatsRepository::lista();
    }
    /**
     * Define o período inicial da consulta.
     * @param String $date Data de início, formato `Y-m-d` (ex, 2017-08-24).
     **
    @return void
     */
    public function setStartDate($date) {
        return $date;
    }

    /**
     * Define o período final da consulta.
     **
    @param String $date Data final da consulta, formato `Y-m-d` (ex,
    2017-08-24).
     **
    @return void
     */
    public function setEndDate($date) {
        return $date;
    }

    /**
     * Retorna o total de pedidos efetuados no período.
     **
    @return integer Total de pedidos.
     */
    public function getOrdersCount(Request $request) {
        $retorno = Pmweb_Orders_StatsRepository::getOrdersCount($request->data_start,$request->data_end);
        return $retorno;
    }

    /**
     * Retorna a receita total de pedidos efetuados no período.
     **
    @return float Receita total no período.
     */
    public function getOrdersRevenue(Request $request)
    {
        $retorno = Pmweb_Orders_StatsRepository::getOrdersRevenue($request->data_start,$request->data_end);
        return $retorno->total;
    }

    /**
     * Retorna o total de produtos vendidos no período (soma de quantidades).
     **
    @return integer Total de produtos vendidos.
     */
    public function getOrdersQuantity(Request $request)
    {
        $retorno = Pmweb_Orders_StatsRepository::getOrdersQuantity($request->data_start,$request->data_end);
        return $retorno->quantidade;
    }

    /**
     * Retorna o preço médio de vendas (receita / quantidade de produtos).
     **
    @return float Preço médio de venda.
     */
    public function getOrdersRetailPrice(Request $request) {
        $receita = self::getOrdersRevenue($request);
        $quantidade = self::getOrdersQuantity($request);

        $preco_medio = $receita/$quantidade;
        return $preco_medio;
    }

    /**
     * Retorna o ticket médio de venda (receita / total de pedidos).
     **
    @return float Ticket médio.
     */
    public function getOrdersAverageOrderValue(Request $request) {

        $receita = self::getOrdersRevenue($request);
        $total_pedidos = self::getOrdersCount($request);

        $ticket_medio = $receita/$total_pedidos;
        return $ticket_medio;
    }

    /**
     * Retorna json encapsulando os métodos anteriores.
     * @param String $startDate Data de início, formato `Y-m-d` (ex, 2017-08-24).
     * @param String $endDate Data final, formato `Y-m-d` (ex, 2017-08-24).
     **
    @return json
     */
    public function returnOrders(Request $request){

        $request = new Request ([
            'data_start' => self::setStartDate($request->startDate),
            'data_end' => self::setEndDate($request->endDate)
        ]);

        return response()->json(['orders'=>[
            "count"=> self::getOrdersCount($request),
            "revenue"=> self::getOrdersRevenue($request),
            "quantity"=> self::getOrdersQuantity($request),
            "averageRetailPrice"=> self::getOrdersRetailPrice($request),
            "AverageOrderValue"=> self:: getOrdersAverageOrderValue($request)
        ]], Response::HTTP_OK);
    }
}
