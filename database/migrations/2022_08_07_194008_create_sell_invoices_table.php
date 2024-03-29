<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sell_invoices')){
            Schema::create('sell_invoices', function (Blueprint $table) {
                $table->id();
                $table->integer('branch_id')->nullable();
                $table->tinyInteger('sell_type')->nullable()->comment('1=final sell, 2=quatation , 3=draft, 4=others');
                $table->tinyInteger('sold_type')->nullable()->comment('1 = direct sold, 2 = sold from quotation, 3 = quotation - this quotation is sold, 4 = quotation');
                $table->string('reference_invoice_no',50)->nullable()->comment('reference previous sell invoice no or sell from quotation invoice no');
                $table->string('invoice_no',50)->nullable();
                $table->decimal('total_sell_item',20,2)->default(0)->comment('sell creating time, total sell item');
                $table->decimal('total_refunded_item',20,2)->default(0)->comment('sell refunded time, total refunded item');
                $table->decimal('total_item',20,2)->default(0)->comment('total_sell_item - total_refunded_item');
                $table->decimal('sell_quantity',20,2)->default(0);
                $table->decimal('subtotal',20,2)->default(0)->comment('only total product sell price, before discount and others cost');
                $table->decimal('discount_amount',20,2)->default(0);
                $table->string('discount_type',12)->nullable()->comment('percentage, fixed');
                $table->decimal('total_discount',20,2)->default(0);
                $table->decimal('total_discount_amount',20,2)->default(0);
                $table->decimal('vat_amount',20,2)->default(0);
                $table->decimal('total_vat',20,2)->default(0);
                $table->decimal('shipping_cost',20,2)->default(0);
                $table->decimal('others_cost',20,2)->default(0);
                $table->decimal('round_amount',20,2)->default(0);
                $table->string('round_type',2)->nullable()->comment('plus(+), minus(-)');
                $table->decimal('total_invoice_amount',20,2)->default(0)->comment('(subtotal + total_vat) - (discount + shipping_cost + others_cost +- round_amount)');
                $table->decimal('total_payable_amount',20,2)->default(0)->comment('(subtotal + total_vat) - (discount + shipping_cost + others_cost +- round_amount)');
                $table->decimal('paid_amount',20,2)->default(0)->comment('total paid amount before refunded');
                $table->decimal('due_amount',20,2)->default(0)->comment('total due amount before refunded');
                $table->decimal('overall_discount_amount',20,2)->default(0)->comment('invoice final less from customer');
                //$table->decimal('refunded_amount',20,2)->nullable();
                
                $table->decimal('refund_charge',20,2)->default(0)->comment('take from customer(company profit)');
                $table->decimal('total_paid_amount',20,2)->default(0)->comment('total paid amount after refunded');
                $table->decimal('total_due_amount',20,2)->default(0)->comment('total due amount after refunded');
                $table->decimal('reference_amount',20,2)->default(0);
                //$table->decimal('total_purchase_amount',20,2)->nullable();
                
                $table->decimal('total_quantity',20,3)->default(0)->comment('sell_quantity - total_refunded_qty');
                $table->decimal('total_refunded_qty',20,3)->default(0)->comment('refunded time, refunded qty');
                
                $table->decimal('total_delivered_qty',20,3)->default(0)->comment('delivered total qty');
                $table->decimal('refunded_received_qty',20,3)->default(0)->comment('refunded received qty');
                
                $table->decimal('total_selling_amount',20,2)->default(0)->comment('sell creating time.Its from sell products tables all sum(sold_price * total_sell_qty)');
                $table->decimal('refundable_amount',20,2)->default(0);
                $table->decimal('total_refunded_amount',20,2)->default(0)->comment('refunded time sell. Its from sell products tables all sum(sold_price * total_refunded_qty)');
                $table->decimal('total_sold_amount',20,2)->default(0)->comment('total_selling_amount - total_refunded_amount');
                
                $table->decimal('total_selling_purchase_amount',20,2)->default(0)->comment('sell creating time.Its from sell products tables all sum(purchase_price * total_sell_qty)');
                $table->decimal('total_refunding_purchase_amount',20,2)->default(0)->comment('refunded time sell. Its from sell products tables all sum(purchase * total_refunded_qty)');
                $table->decimal('total_purchase_amount',20,2)->default(0)->comment('total_selling_purchase_amount - total_refunding_purchase_amount');
                
                $table->decimal('total_selling_profit',20,2)->default(0)->comment('sell creating time totoal profit');
                $table->decimal('total_refunded_reduced_profit',20,2)->default(0)->comment('refunded time reduce profit');
                $table->decimal('total_profit_from_product',20,2)->default(0)->comment('without extra cost.. total_selling_profit - total_refunded_reduced_profit');
                $table->decimal('total_profit',20,2)->default(0)->comment('total_selling_profit - total_refunded_reduced_profit (should be- without extra all cost)');


                $table->tinyInteger('payment_status',2)->nullable()->comment('Full Paid, Full Due, Partial Paid');
                $table->string('payment_type',20)->nullable()->comment('parital payment, full payment');
                
                $table->integer('customer_id')->nullable();
                $table->string('customer_phone',20)->nullable();
                $table->integer('customer_type_id')->nullable()->comment('1=Permanent, 2=Temporary');
                $table->integer('shipping_id')->nullable();
                $table->text('shipping_note')->nullable();
                $table->text('receiver_details')->nullable();
                $table->integer('reference_id')->nullable();
                $table->text('sell_note')->nullable();
                $table->string('sell_date',25)->nullable();
                //$table->tinyInteger('product_stock_type')->nullable()->comment('1=single, 2=multiple');
            
                $table->tinyInteger('total_edit_count')->default(0);
                $table->tinyInteger('total_return_count')->default(0);
                $table->tinyInteger('total_delivered_count')->default(0);

                $table->tinyInteger('status')->nullable();
                $table->tinyInteger('delivery_status')->nullable();

                $table->integer('created_by')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_invoices');
    }
}
