<?php

namespace App\Models\Backend\Stock;

use App\Models\Backend\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\Stock\StockChangingType;
use App\User;

class StockHistory extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    protected $table = 'stock_histories';
    //protected $primaryKey = 'GROUP_ROLE_ID';
    /* protected $fillable = [
        'customer_type_id','branch_id','custom_id','name','email','email_verified_at','password','gender','phone','phone_2','blood_group','religion','unique_id_no','company_name','address','previous_due','previous_due_date','next_payment_date','note','verified','deleted_at','verified_by','created_by'
    ]; */


    
    /*
    |-------------------------------------------------------
    | Stock History
    |-------------------------------------------------------
    */
        public function stockChangingType(){
            return $this->belongsTo(StockChangingType::class,'stock_changing_type_id','id');
        } 
        public function stockLabel(){
            return $this->belongsTo(Stock::class,'stock_id','id');
        } 
        public function product(){
            return $this->belongsTo(Product::class,'product_id','id');
        }        
        public function createdBY(){
            return $this->belongsTo(User::class,'created_by','id');
        }
    /*
    |-------------------------------------------------------
    | Stock History
    |-------------------------------------------------------
    */
    
}
