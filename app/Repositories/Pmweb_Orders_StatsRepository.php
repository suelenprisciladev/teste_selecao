<?php
namespace App\Repositories;

use App\Model\{Order_Items};
use DB;

class Pmweb_Orders_StatsRepository
{
    public static function lista(){
        return 'entrou';
    }

    public static function getOrdersCount($date_start, $date_end)
    {
        return Order_Items::whereBetween('order_date', [$date_start, $date_end])->count();
    }

    public static function getOrdersRevenue($date_start, $date_end)
    {
        return Order_Items::select(DB::raw('sum(quantity * price) as total'))->whereBetween('order_date', [$date_start, $date_end])->first();
    }

    public static function getOrdersQuantity($date_start, $date_end)
    {
        return Order_Items::select(DB::raw('sum(quantity) as quantidade'))->whereBetween('order_date', [$date_start, $date_end])->first();
    }
}
    
