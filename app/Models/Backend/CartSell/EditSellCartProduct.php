<?php

namespace App\Models\Backend\CartSell;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\Sell\SellProductStock;
use App\Models\Backend\CartSell\EditSellCartProductStock;

class EditSellCartProduct extends Model
{
    
    public function sellProductStocks()
    {
        return $this->hasMany(SellProductStock::class,'sell_product_id','id');
    }

    public function editSellCartProductStocks()
    {
        return $this->hasMany(EditSellCartProductStock::class,'edit_sell_cart_product_id','id')->where('status',1);
    }

    
}
