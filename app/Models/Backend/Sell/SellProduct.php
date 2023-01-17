<?php

namespace App\Models\Backend\Sell;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\Sell\SellProductStock;

class SellProduct extends Model
{
    
    public function sellProductStocks()
    {
        return $this->hasMany(SellProductStock::class,'sell_product_id','id')->whereNull('deleted_at');
    }

    public function sellProductStocksAllData()//with deleted data
    {
        return $this->hasMany(SellProductStock::class,'sell_product_id','id');
    }

    
}
