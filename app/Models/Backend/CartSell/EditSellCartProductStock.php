<?php

namespace App\Models\Backend\CartSell;

use App\Models\Backend\Stock\ProductStock;
use App\Models\Backend\Stock\Stock;
use Illuminate\Database\Eloquent\Model;

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
}
