<?php

namespace App\Http\Repositories;


use Illuminate\Support\Facades\DB;

class StopLimitRepository extends CommonRepository
{
    function __construct($model) {
        parent::__construct($model);
    }

    public function getOrders()
    {
        return DB::select("SELECT users.email as email, base_coin_table.coin_type as base_coin, trade_coin_table.coin_type as trade_coin, limit_price as price, amount, stop_limits.order as order_type, stop_limits.created_at FROM stop_limits join users on users.id = stop_limits.user_id join coins as base_coin_table on base_coin_id = base_coin_table.id join coins as trade_coin_table on trade_coin_id = trade_coin_table.id
            where stop_limits.status = 0"
        );
    }

    public function getOnOrderBalance($baseCoinId, $tradeCoinId,$userId,$type)
    {
        if($type == 'sell'){
            return  DB::table('stop_limits')
                ->where(['user_id' => $userId, 'base_coin_id' => $baseCoinId, 'trade_coin_id' => $tradeCoinId, 'status' => '0', 'deleted_at' => null, 'order' => $type, 'is_conditioned' => 0])
                ->select( DB::raw('TRUNCATE(SUM(amount),8) as total'))
                ->get();
        }else{
            return  DB::table('stop_limits')
                ->where(['user_id' => $userId, 'base_coin_id' => $baseCoinId, 'trade_coin_id' => $tradeCoinId, 'status' => '0', 'deleted_at' => null, 'order' => $type])
                ->select( DB::raw('SUM(TRUNCATE((amount)*limit_price,8)+ TRUNCATE((amount)*limit_price,8)*0.01*case when (maker_fees > taker_fees)  then (maker_fees) else (taker_fees) end ) as total'))
                ->get();
        }
    }

}
