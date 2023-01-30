<?php

namespace App\Models\Backend\CartSell;

use App\Models\Backend\Stock\Stock;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\Stock\ProductStock;
use App\Models\Backend\CartSell\EditSellCartProduct;

class EditSellCartProductStock extends Model
{
    
    public function stock()
    {
        return $this->belongsTo(Stock::class,'stock_id','id');
    }
    public function productStock()
    {
        return $this->belongsTo(ProductStock::class,'product_stock_id','id');
    }

    //
    public function editSellCartProduct()
    {
        return $this->belongsTo(EditSellCartProduct::class,'edit_sell_cart_product_id','id');
    }
    //only edit sell product related  
    public function editSellCartProductOnly()
    {
        return $this->belongsTo(EditSellCartProduct::class,'edit_sell_cart_product_id','id')->where('product_id',$this->product_id);
    }

}
