<?php

namespace App\Models\Backend\Sell;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\Sell\SellProductStock;

class SellProduct extends Model
{
    
    //only active data :- except deleted data
    public function sellProductStocks()
    {
        return $this->hasMany(SellProductStock::class,'sell_product_id','id')->whereNull('deleted_at');
    }

    //all data with deleted data
    public function sellProductStocksAllData()//with deleted data
    {
        return $this->hasMany(SellProductStock::class,'sell_product_id','id');
    }

    
}
