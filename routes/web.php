<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('cache-clear', function() {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    return '<a href='.env('APP_LIVE_URL').'>Home '.'</a>'; //.env('APP_LIVE_URL').' - '. config('app.name')
});

Route::get('storage-link', function() {
    Artisan::call('storage:link');
    return redirect()->route('home')->with('success', 'Created Storage Link');
});


Route::get('/', 'Landing\LandingController@index')->name('landing');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/test', 'HomeController@test')->name('test');






#,'routeCheck'
Route::group(['middleware' => ['auth']], function ()
{

    /*
    |----------------------------------------
    |   prodct attribute : Unit  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.unit.', 'prefix'=>'admin/unit','namespace'=>'Backend\ProductAttribute'],function(){
            Route::get('list','UnitController@index')->name('index');//;//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','UnitController@unitListByAjaxResponse')->name('list.ajaxresponse');//;//->middleware(['permissions:unit|index']);
            Route::get('create','UnitController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','UnitController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','UnitController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','UnitController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','UnitController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   prodct attribute : Unit  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */

    /*
    |----------------------------------------
    |   prodct attribute : Category  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.category.', 'prefix'=>'admin/category','namespace'=>'Backend\ProductAttribute'],function(){
            Route::get('list','CategoryController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','CategoryController@categoryListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','CategoryController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','CategoryController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','CategoryController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','CategoryController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','CategoryController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   prodct attribute : Category  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */

    /*
    |----------------------------------------
    |   prodct attribute : SubCategory  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.subcategory.', 'prefix'=>'admin/sub/category','namespace'=>'Backend\ProductAttribute'],function(){
            Route::get('list','SubCategoryController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','SubCategoryController@subCategoryListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','SubCategoryController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','SubCategoryController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','SubCategoryController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','SubCategoryController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','SubCategoryController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        

            //sub category by category id
            Route::get('category/id','SubCategoryController@subCategoryByCategoryId')->name('by.category.id');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   prodct attribute : SubCategory  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */

    /*
    |----------------------------------------
    |   prodct attribute : Brand  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.brand.', 'prefix'=>'admin/brand','namespace'=>'Backend\ProductAttribute'],function(){
            Route::get('list','BrandController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','BrandController@brandListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','BrandController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','BrandController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','BrandController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','BrandController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','BrandController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   prodct attribute : Brand  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */

    /*
    |----------------------------------------
    |   prodct attribute : Color  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.color.', 'prefix'=>'admin/color','namespace'=>'Backend\ProductAttribute'],function(){
            Route::get('list','ColorController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','ColorController@colorListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','ColorController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','ColorController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','ColorController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','ColorController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','ColorController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   prodct attribute : Color  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */


    /*
    |----------------------------------------
    |   prodct attribute : Product grade  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.product.grade.', 'prefix'=>'admin/product/grade','namespace'=>'Backend\ProductAttribute'],function(){
            Route::get('list','ProductGradeController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','ProductGradeController@productGradeListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','ProductGradeController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','ProductGradeController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','ProductGradeController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','ProductGradeController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','ProductGradeController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   prodct attribute : Product grade  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */


    /*
    |----------------------------------------
    |   prodct attribute : Supplier Group  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.supplier.group.', 'prefix'=>'admin/supplier/group','namespace'=>'Backend\Supplier'],function(){
            Route::get('list','SupplierGroupController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','SupplierGroupController@supplierGroupListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','SupplierGroupController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','SupplierGroupController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','SupplierGroupController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','SupplierGroupController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','SupplierGroupController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   prodct attribute : Supplier Group  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */

    /*
    |----------------------------------------
    |   Supplier  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.supplier.', 'prefix'=>'admin/supplier','namespace'=>'Backend\Supplier'],function(){
            Route::get('list','SupplierController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','SupplierController@supplierListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','SupplierController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','SupplierController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('show','SupplierController@show')->name('show');//->middleware(['permissions:unit|index']);
            Route::get('edit','SupplierController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','SupplierController@update')->name('update');//->middleware(['permissions:unit|index']);
            
            //for temporary
            Route::get('history/{id}','SupplierController@history')->name('history');//->middleware(['permissions:unit|index']);
            
            Route::get('delete','SupplierController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   Supplier  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */

    /*
    |----------------------------------------
    |   Customer  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.customer.', 'prefix'=>'admin/customer','namespace'=>'Backend\Customer'],function(){
            Route::get('list','CustomerController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','CustomerController@customerListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','CustomerController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','CustomerController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','CustomerController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','CustomerController@update')->name('update');//->middleware(['permissions:unit|index']);
            
            //delete
            Route::get('delete','CustomerController@delete')->name('delete');//->middleware(['permissions:unit|index']);

            //for temporary
            Route::get('history/{id}','CustomerTransactionalController@history')->name('history');//->middleware(['permissions:unit|index']);
            Route::get('transaction/statement','CustomerTransactionalController@customerTransactionalStatement')->name('transactional.statement');//->middleware(['permissions:unit|index']);
            //render next payment date modal
            Route::get('render/next/payment/date/modal','CustomerTransactionalController@renderNextPaymentDateModal')->name('render.next.payment.date.modal');
            Route::post('store/next/payment/date','CustomerTransactionalController@storeNextPaymentDate')->name('store.next.payment.date');
            //render add loan modal
            Route::get('render/add/loan/modal','CustomerTransactionalController@renderAddLoanModal')->name('render.add.loan.modal');
            Route::post('store/add/loan','CustomerTransactionalController@storeAddLoanData')->name('store.add.loan');
            //render add advance modal
            Route::get('render/add/advance/modal','CustomerTransactionalController@renderAddAdvanceModal')->name('render.next.add.advance.modal');
            Route::post('store/add/advance','CustomerTransactionalController@storeAddAdvance')->name('store.next.add.advance');
            //render receive previous due  modal
            Route::get('render/receive/previous/due/modal','CustomerTransactionalController@renderReceivePreviousDueModal')->name('render.receive.previous.due.modal');
            Route::post('store/receive/previous/due','CustomerTransactionalController@storeReceivePreviousDue')->name('store.receive.previous.due');
            //render return advance amount modal
            Route::get('render/return/advance/amount/modal','CustomerTransactionalController@renderReturnAdvanceAmountModal')->name('render.return.advance.amount.modal');
            Route::post('store/return/advance/amount','CustomerTransactionalController@storeReturnAdvanceAmount')->name('store.return.advance.amount');
            //render receive loan amount  modal
            Route::get('render/receive/loan/amount/modal','CustomerTransactionalController@renderReceiveLoanAmountModal')->name('render.receive.loan.amount.modal');
            Route::post('store/receive/loan/amount','CustomerTransactionalController@storeReceiveLoanAmount')->name('store.receive.loan.amount');
            
            Route::get('render/receive/all/invoice/dues/modal','CustomerTransactionalController@renderReceiveAllInvoiceDueModal')->name('render.receive.all.invoice.dues.modal');
            Route::post('store/receiving/all/invoice/dues','CustomerTransactionalController@storeReceivingAllInvoiceDues')->name('store.receiving.all.invoice.dues');
        });
    /*
    |----------------------------------------
    |   Customer  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */

        
    /*
    |----------------------------------------
    |   Reference  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.reference.', 'prefix'=>'admin/reference','namespace'=>'Backend\Reference'],function(){
            Route::get('list','ReferenceController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','ReferenceController@referenceListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','ReferenceController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','ReferenceController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','ReferenceController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','ReferenceController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','ReferenceController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        

        });  
        Route::group(['as'=> 'admin.reference.history.', 'prefix'=>'admin/reference/history','namespace'=>'Backend\Reference'],function(){
            //reference wise sell list
            Route::get('/ref/{id}/wise/sell/list','ReferenceHistoryController@referenceWiseSellList')->name('reference.wise.sell.list');//->middleware(['permissions:unit|index']);
        });        
    /*
    |----------------------------------------
    |   Reference  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */



        
    /*
    |----------------------------------------
    |   prodct attribute : warehouse  
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.warehouse.', 'prefix'=>'admin/warehouse','namespace'=>'Backend\Warehouse'],function(){
            Route::get('list','WarehouseController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','WarehouseController@warehouseListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','WarehouseController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','WarehouseController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','WarehouseController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','WarehouseController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','WarehouseController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   prodct attribute : warehouse  
    |---------------------------------------
    */

    /*
    |----------------------------------------
    |   prodct attribute : SubCategory  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.warehouse.rack.', 'prefix'=>'admin/warehouse/rack','namespace'=>'Backend\Warehouse'],function(){
            Route::get('list','WarehouseRackController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','WarehouseRackController@warehouseRackListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','WarehouseRackController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','WarehouseRackController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('edit','WarehouseRackController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','WarehouseRackController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','WarehouseRackController@delete')->name('delete');//->middleware(['permissions:unit|index']);
        

            //warehouse rack by warehouse id
            Route::get('warehouse/id','WarehouseRackController@warehouseRackByWarehouseId')->name('by.warehouse.id');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   prodct attribute : SubCategory  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */



    /*
    |----------------------------------------
    |   Product  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.product.', 'prefix'=>'admin/product','namespace'=>'Backend\Product'],function(){
            Route::get('list','ProductController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('list/by/ajr','ProductController@productListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('create','ProductController@create')->name('create');//->middleware(['permissions:unit|index']);
            Route::post('store','ProductController@store')->name('store');//->middleware(['permissions:unit|index']);

            Route::get('show','ProductController@show')->name('show');//->middleware(['permissions:unit|index']);
            
            Route::get('edit','ProductController@edit')->name('edit');//->middleware(['permissions:unit|index']);
            Route::post('update','ProductController@update')->name('update');//->middleware(['permissions:unit|index']);
        
            Route::get('delete','ProductController@delete')->name('delete');//->middleware(['permissions:unit|index']);
            
            //product price
            Route::get('price/update','ProductPriceController@index')->name('price.index');//->middleware(['permissions:unit|index']);
            Route::post('price/updating','ProductPriceController@store')->name('price.store');//->middleware(['permissions:unit|index']);
        });
    /*
    |----------------------------------------
    |   Product  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */


    /*
    |----------------------------------------
    |  session setting (sell)
    |---------------------------------------
    */
        Route::group(['prefix'=>'admin/session/setting','as'=> 'admin.session.','namespace'=>'Backend\Session'],function(){
            Route::post('creating/selling/new/cart/session','SessionController@creatingSellingCartSession')->name('setting.create.selling.new.session');
            Route::get('changing/selling/cart/{sessionname?}','SessionController@changingSellingCartSession')->name('changing.selling.cart.session');
            Route::get('delete/selling/customer/name/{sessionname?}','SessionController@deleteingSellingCartSession')->name('deleting.selling.cart.session');
        });   
    /*
    |----------------------------------------
    |  session setting (sell)
    |---------------------------------------
    */


    /*
    |----------------------------------------
    |   Sell  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        //pos sell
        Route::group(['as'=> 'admin.sell.regular.pos.', 'prefix'=>'admin/regular/sell','namespace'=>'Backend\Sell\Pos'],function(){
            Route::get('display/product/list','PosController@displayProductList')->name('display.product.list');
            Route::get('create','PosController@create')->name('create');
            Route::get('show/single/product/details','PosController@singleProductDetails')->name('show.single.product.details');
            
            Route::get('display/single/price/list/by/product/stock/id','PosController@displaySinglePriceListByProductStockId')->name('display.sigle.price.list.by.product.stock.id');
            
            //display product stock and price, when sell create. more than stock, from others stock
            Route::get('display/quantity/wise/single/product/sotck/by/product/id','PosController@displayQuantityWiseSingleProductStockByProductId')->name('display.quantity.wise.sigle.product.stock.by.product.id');
            
            Route::post('store','PosController@store')->name('store');
            //display addted to product list
            Route::get('display/sell/create/added/to/cart/product/list','PosController@displaySellCreateAddedToCartProductList')->name('display.sell.created.added.to.cart.product.list');
            
            //sell final invoice calculation summery [save in session]
            Route::get('/sell/final/invoice/calculation/summery','PosController@invoiceFinalSellCalculationSummery')->name('sell.final.invoice.calculation.summery');

            //remove single item from sell added to cart list
            Route::get('remove/confirm-req/for/single/item/from/sell/added/to/cart/list','PosController@removeConfirmationRequiredForSingleItemFromSellAddedToCartList')->name('remove.confirmation.required.single.item.from.sell.added.to.cart.list');
            Route::get('remove/single/item/from/sell/added/to/cart/list','PosController@removeSingleItemFromSellAddedToCartList')->name('remove.single.item.from.sell.added.to.cart.list');
            
            //remove all item from sell added to cart list
            Route::get('remove/confirm-req/for/all/item/from/sell/added/to/cart/list','PosController@removeConfirmationRequiredForAllItemFromSellAddedToCartList')->name('remove.confirmation.required.all.item.from.sell.added.to.cart.list');
            Route::get('remove/all/item/from/sell/added/to/cart/list','PosController@removeAllItemFromSellAddedToCartList')->name('remove.all.item.from.sell.added.to.cart.list');
            //change quantity [plus or minus]
            Route::get('change/quantity/from/added/to/cart/list','PosController@changeQuantity')->name('change.quantity.from.sell.added.to.cart.list');
            

            // Store data from sell cart
            Route::post('store/data/from/sell/cart','PosController@storeDataFromSellCart')->name('store.data.from.sell.cart');

            //customer shipping address
            Route::post('customer/shipping/address','PosController@customerShippingAddress')->name('customer.shipping.address');
            
            
            //sell payment modal open 
            Route::get('sell/payment/modal/open','PosController@paymentModalOpen')->name('sell.payment.modal.open');
            Route::get('sell/quotation/modal/open','PosController@quotationModalOpen')->name('sell.quotation.modal.open');
            
        });
        
        //Payment options
        Route::group(['as'=> 'admin.payment.', 'prefix'=>'admin/payment','namespace'=>'Backend\Payment'],function(){
            Route::get('payment/banking/option/data','PaymentController@paymentBankingOptionData')->name('common.banking.option.data');
        });
        //Payment options

        //customer shipping address
        Route::group(['as'=> 'admin.customer.', 'prefix'=>'admin/customer/shipping','namespace'=>'Backend\Customer'],function(){
            Route::get('address/details/by','ShippingAddressController@getCustomerShippingAddressDetailsByCustomerId')->name('shipping.address.details.by.customer.id');
        });
        //customer shipping address

        Route::group(['as'=> 'admin.sell.regular.pos.', 'prefix'=>'admin/regular/sell','namespace'=>'Backend\Sell\Prints'],function(){
            //print sell invoice :- pos print
            Route::get('pos/print/from/direct/sell/cart','InvoicePrintController@posPrintFromDirectSellCart')->name('pos.print.from.direct.sell.cart');
            Route::get('normal/print/from/direct/sell/cart','InvoicePrintController@normalPrintFromDirectSellCart')->name('normal.print.from.direct.sell.cart');
        });

        /*
        |-----------------------------------
        | Sell list, print  and others
        |-----------------------------------
        */
            Route::group(['prefix'=>'admin/sell/regular','as'=> 'admin.sell.regular.sell.', 'namespace'=>'Backend\Sell\Details'],function(){
                Route::get('sell/list','SellController@index')->name('index');//->middleware(['permissions:unit|index']);
                Route::get('sell/list/by/ajr','SellController@sellListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
                Route::get('sell/single/view','SellController@singleView')->name('single.view');//->middleware(['permissions:unit|index']);
                Route::get('sell/single/invoice/profit/loss','SellController@viewSingleInvoiceProfitLoss')->name('view.single.invoice.profit.loss');
                //over all invoice adjustment discount
                Route::get('sell/single/invoice/overall/discount','SellController@viewSingleInvoiceForOverallDiscount')->name('view.single.invoice.for.overall.discount');
                Route::get('sell/single/invoice/overall/discount/receiving','SellController@receivingInvoiceWiseOverallDiscount')->name('view.single.invoice.for.overall.discount.receiving');
                
                //sell update calculation summery
                Route::get('sell/single/invoice/update/calculation/summery/{id}','SellController@updateSellCalculation')->name('update.sell.calculation');
                Route::get('update/all/sell/invoice','SellController@updatePreviousSellInvoice')->name('update.sell.invoice');
                
                //payment
                Route::get('sell/receive/payment/','SellController@receiveSingleInvoiceWisePayment')->name('view.single.invoice.receive.payment.modal');
                Route::post('/sell/receive/invoice/wise/payment/','SellController@receivingSingleInvoiceWisePayment')->name('view.single.invoice.receiving.payment.modal');
                Route::get('single/invoice/wise/sell/payment/details','SellController@viewSingleInvoicePaymentDetails')->name('view.single.invoice.wise.payment.details.modal');
            });
            //quotation
            Route::group(['prefix'=>'admin/sell/regular','as'=> 'admin.sell.regular.quotation.', 'namespace'=>'Backend\Sell\Details'],function(){
                Route::get('quotation/list','QuotationController@index')->name('index');//->middleware(['permissions:unit|index']);
                Route::get('quotation/list/by/ajr','QuotationController@quotationListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
                Route::get('quotation/single/view','QuotationController@singleView')->name('single.view');//->middleware(['permissions:unit|index']);
                Route::get('quotation/single/invoice/profit/loss','QuotationController@viewSingleInvoiceProfitLoss')->name('view.single.invoice.profit.loss');
            });

            //print
            Route::group(['prefix'=>'admin/sell/regular','as'=> 'admin.sell.regular.','namespace'=>'Backend\Sell\Prints'],function(){
                //print sell invoice :- pos print
                Route::get('pos/print/from/sell/list/by/{invoiceId}','InvoicePrintController@posPrintFromSellList')->name('pos.print.from.sell.list');
                Route::get('normal/print/from/sell/list/by/{invoiceId}','InvoicePrintController@normalPrintFromSellList')->name('normal.print.from.sell.list');
                Route::get('normal/print/from/sell/quotation/list/by/{sellInvoiceId}','InvoicePrintController@normalPrintFromSellQuotationList')->name('normal.print.from.sell.quotation.list');    
                
                //download sell list pdf file
                //Route::post('list/normat/print/','InvoicePrintController@sellListNormalPrint')->name('sell.list.normal.print');
                Route::post('list/pdf/download/','InvoicePrintController@sellListPdfDownload')->name('sell.list.pdf.download');
            });
        /*
        |-----------------------------------
        | Sell list, print  and others
        |-----------------------------------
        */
        

        /*
        |-----------------------------------
        | Sell product Edit 
        |-----------------------------------
        */ 
            /*
            |-----------------------------------
            | Sell  Edit - POS 
            |-----------------------------------
            */    
                Route::group(['as'=> 'admin.sell.edit.regular.pos.', 'prefix'=>'admin/regular/sell/edit','namespace'=>'Backend\Sell\SellEdit'],function(){
                    Route::get('display/product/list','EditPosController@displayProductList')->name('display.product.list');
                    Route::get('create','EditPosController@create')->name('create');
                    Route::get('show/single/product/details','EditPosController@singleProductDetails')->name('show.single.product.details');
                    
                    Route::get('display/single/price/list/by/product/stock/id','EditPosController@displaySinglePriceListByProductStockId')->name('display.sigle.price.list.by.product.stock.id');
                    
                    //display product stock and price, when sell create. more than stock, from others stock
                    Route::get('display/quantity/wise/single/product/sotck/by/product/id','EditPosController@displayQuantityWiseSingleProductStockByProductId')->name('display.quantity.wise.sigle.product.stock.by.product.id');
                    
                    Route::post('store','EditPosController@store')->name('store');
                    //display addted to product list
                    Route::get('display/sell/edit/create/added/to/cart/product/list','EditPosController@displaySellEditCreateAddedToCartProductList')->name('display.sell.edit.created.added.to.cart.product.list');
                    
                    //sell final invoice calculation summery [save in session]
                    Route::get('/sell/edit/final/invoice/calculation/summery','EditPosController@invoiceFinalSellEditCalculationSummery')->name('sell.edit.final.invoice.calculation.summery');

                    //remove single item from sell added to cart list
                    Route::get('remove/confirm-req/for/single/item/from/sell/edit/added/to/cart/list','EditPosController@removeConfirmationRequiredForSingleItemFromSellEditAddedToCartList')->name('remove.confirmation.required.single.item.from.sell.edit.added.to.cart.list');
                    Route::get('remove/single/item/from/sell/edit/added/to/cart/list','EditPosController@removeSingleItemFromSellEditAddedToCartList')->name('remove.single.item.from.sell.edit.added.to.cart.list');
                    
                    //remove all item from sell added to cart list
                    Route::get('remove/confirm-req/for/all/item/from/sell/edit/added/to/cart/list','EditPosController@removeConfirmationRequiredForAllItemFromSellEditAddedToCartList')->name('remove.confirmation.required.all.item.from.sell.edit.added.to.cart.list');
                    Route::get('remove/all/item/from/sell/edit/added/to/cart/list','EditPosController@removeAllItemFromSellEditAddedToCartList')->name('remove.all.item.from.sell.edit.added.to.cart.list');
                    //change quantity [plus or minus]
                    Route::get('change/quantity/from/added/to/cart/list','EditPosController@changeQuantity')->name('change.quantity.from.sell.edit.added.to.cart.list');
                    

                    // Store data from sell cart
                    Route::post('store/data/from/sell/edit/cart','EditPosController@storeDataFromSellEditCart')->name('store.data.from.sell.edit.cart');

                    //customer shipping address
                    Route::post('customer/shipping/address','EditPosController@customerShippingAddress')->name('customer.shipping.address');
                    
                    
                    //sell payment modal open 
                    Route::get('sell/edit/payment/modal/open','EditPosController@paymentModalOpen')->name('sell.edit.payment.modal.open');
                    Route::get('sell/edit/quotation/modal/open','EditPosController@quotationModalOpen')->name('sell.edit.quotation.modal.open');
                    
                });
                
            /*
            |-----------------------------------
            | Sell  Edit - POS 
            |-----------------------------------
            */

            Route::group(['prefix'=>'admin/sell/edit','as'=> 'admin.sell.edit.', 'namespace'=>'Backend\Sell\SellEdit'],function(){
                Route::get('cart/product/list','SellEditController@index')->name('product.cart.list');//->middleware(['permissions:unit|index']);
                Route::post('by/sell/invoice/store','SellEditController@store')->name('invoice.wise.quantity.store');//->middleware(['permissions:unit|index']);
                
            });
        /*
        |-----------------------------------
        | Sell product Edit 
        |-----------------------------------
        */

        /*
        |-----------------------------------
        | Sell product delivery
        |-----------------------------------
        */
            Route::group(['prefix'=>'admin/sell/product/delivery','as'=> 'admin.sell.product.delivery.', 'namespace'=>'Backend\Sell\Delivery'],function(){
                Route::get('by/sell/invoice','SellProductDeliveryController@index')->name('invoice.wise.list.index');//->middleware(['permissions:unit|index']);
                Route::post('by/sell/invoice/store','SellProductDeliveryController@store')->name('invoice.wise.quantity.store');//->middleware(['permissions:unit|index']);
                
                Route::get('print/sell/product/delivered/invoice/wise/product/list/{invoiceId}','SellProductDeliveryController@printSellProductDeliveredInvoiceWiseDeliveredProductList')->name('print.product.delivered.invoice.wise.delivered.list');//->middleware(['permissions:unit|index']);
                //Route::get('invoice/wise/list','SellProductDeliveryController@index')->name('list.index');//->middleware(['permissions:unit|index']);
                //Route::get('list/by/ajr','SellProductDeliveryController@sellListByAjaxResponse')->name('sell.list.ajaxresponse');//->middleware(['permissions:unit|index']);
                //Route::get('single/view','SellProductDeliveryController@singleView')->name('sell.single.view');//->middleware(['permissions:unit|index']);
            });
        /*
        |-----------------------------------
        | Sell product delivery
        |-----------------------------------
        */

        /*
        |-----------------------------------
        | Sell product return 
        |-----------------------------------
        */
            Route::group(['prefix'=>'admin/sell/product/return','as'=> 'admin.sell.product.return.', 'namespace'=>'Backend\Sell\SellReturn'],function(){
                Route::get('by/sell/invoice','SellProductReturnController@index')->name('invoice.wise.list.index');//->middleware(['permissions:unit|index']);
                Route::post('by/sell/invoice/store','SellProductReturnController@store')->name('invoice.wise.quantity.store');//->middleware(['permissions:unit|index']);
                
                Route::get('print/sell/product/return/invoice/wise/product/list/{invoiceId}','SellProductReturnController@printSellReturnProducInvoiceWisedProductList')->name('print.product.returned.invoice.wise.returned.list');//->middleware(['permissions:unit|index']);
                //Route::get('invoice/wise/list','SellProductReturnController@index')->name('list.index');//->middleware(['permissions:unit|index']);
                //Route::get('list/by/ajr','SellProductReturnController@sellListByAjaxResponse')->name('sell.list.ajaxresponse');//->middleware(['permissions:unit|index']);
                //Route::get('single/view','SellProductReturnController@singleView')->name('sell.single.view');//->middleware(['permissions:unit|index']);
            });
        /*
        |-----------------------------------
        | Sell product return 
        |-----------------------------------
        */

    /*
    |----------------------------------------
    |   Sell  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */   


    /*
    |-----------------------------------
    | product stock 
    |-----------------------------------
    */
        Route::group(['prefix'=>'admin/product/stock','as'=> 'admin.product.stock.', 'namespace'=>'Backend\Stock'],function(){
            Route::get('list','StockController@index')->name('index');
            Route::get('list/by/ajr','StockController@stockListByAjaxResponse')->name('list.ajaxresponse');
            
            //initial stock
            Route::get('add/initial/stock','StockController@addInitialStock')->name('add.initial.stock');
            Route::get('render/single/product/details','StockController@renderSingleProductDetial')->name('render.single.product.details');
            Route::post('store/initial/stock','StockController@storeInitialStock')->name('store.initial.stock');
            
            //stock history
            Route::get('stock/history/list','StockController@stockHistoryList')->name('stock.history.list');
            Route::get('show/single/product/stock/history','StockController@showSingleProductStockHistory')->name('show.single.product.stock.history');
            
            //check stock to others branch : before start api call
            Route::get('check/stock/from/other/branch','StockController@checkStockFromOtherBranch')->name('check.stock.from.other.branch');
        });

        //stock check api
        Route::group(['prefix'=>'admin/product/stock','as'=> 'admin.product.stock.', 'namespace'=>'Backend\Stock'],function(){
            //Route::get('add/initial/stock','StockController@addInitialStock')->name('add.initial.stock');
        });
    /*
    |-----------------------------------
    | product stock 
    |-----------------------------------
    */



    /*
    |----------------------------------------
    |   Purchase  middleware(['permissions:unit|index','auth_only:auth|yes'])
    |---------------------------------------
    */
        Route::group(['as'=> 'admin.purchase.regular.pos.', 'prefix'=>'admin/regular/purchase','namespace'=>'Backend\Purchase\PurchasePos'],function(){
            Route::get('display/product/list','PurchasePosController@displayProductList')->name('display.product.list');
            Route::get('create','PurchasePosController@create')->name('create');
            Route::get('show/single/product/details','PurchasePosController@singleProductDetails')->name('show.single.product.details');
            
            Route::post('store','PurchasePosController@store')->name('store');
            //display addted to product list
            Route::get('display/purchase/create/added/to/cart/product/list','PurchasePosController@displayPurchaseCreateAddedToCartProductList')->name('display.purchase.created.added.to.cart.product.list');
            
            //purchase final invoice calculation summery [save in session]
            Route::get('/purchase/final/invoice/calculation/summery','PurchasePosController@invoiceFinalPurchaseCalculationSummery')->name('purchase.final.invoice.calculation.summery');

            //remove single item from purchase added to cart list
            Route::get('remove/confirm-req/for/single/item/from/purchase/added/to/cart/list','PurchasePosController@removeConfirmationRequiredForSingleItemFromPurchaseAddedToCartList')->name('remove.confirmation.required.single.item.from.purchase.added.to.cart.list');
            Route::get('remove/single/item/from/purchase/added/to/cart/list','PurchasePosController@removeSingleItemFromPurchaseAddedToCartList')->name('remove.single.item.from.purchase.added.to.cart.list');
            
            //remove all item from purchase added to cart list
            Route::get('remove/confirm-req/for/all/item/from/purchase/added/to/cart/list','PurchasePosController@removeConfirmationRequiredForAllItemFromPurchaseAddedToCartList')->name('remove.confirmation.required.all.item.from.purchase.added.to.cart.list');
            Route::get('remove/all/item/from/purchase/added/to/cart/list','PurchasePosController@removeAllItemFromPurchaseAddedToCartList')->name('remove.all.item.from.purchase.added.to.cart.list');
            //change quantity [plus or minus]
            Route::get('change/quantity/from/added/to/cart/list','PurchasePosController@changeQuantity')->name('change.quantity.from.purchase.added.to.cart.list');
            
            //purchase payment modal open 
            Route::get('purchase/payment/modal/open','PurchasePosController@paymentModalOpen')->name('purchase.payment.modal.open');
                        
            // Store data from purchase cart
            Route::post('store/data/from/purchase/cart','PurchasePosController@storeDataFromPurchaseCart')->name('store.data.from.purchase.cart');

            //customer shipping address
            Route::post('shipping/cost/with/other','PurchasePosController@purchaseShippingCostAndOther')->name('shipping.cost.and.others.store.in.session');
        });
        //have to process later
        Route::group(['as'=> 'admin.purchase.regular.purchase.', 'prefix'=>'admin/regular/purchase','namespace'=>'Backend\Sell\Prints'],function(){
            //print purchase invoice :- pos print
            Route::get('pos/print/from/direct/purchase/cart','InvoicePrintController@posPrintFromDirectPurchaseCart')->name('pos.print.from.direct.purchase.cart');
            Route::get('normal/print/from/direct/purchase/cart','InvoicePrintController@normalPrintFromDirectPurchaseCart')->name('normal.print.from.direct.purchase.cart');
        });

    /*
    |-----------------------------------
    | Purchase list, print  and others
    |-----------------------------------
    */
        Route::group(['as'=> 'admin.purchase.regular.purchase.','prefix'=>'admin/purchase/regular', 'namespace'=>'Backend\Purchase\Details'],function(){
            Route::get('purchase/list','PurchaseController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('purchase/list/by/ajr','PurchaseController@purchaseListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('purchase/single/view','PurchaseController@singleView')->name('single.view');//->middleware(['permissions:unit|index']);
            
            //payment
            Route::get('purchase/making/payment/','PurchaseController@makeSingleInvoiceWisePayment')->name('view.single.invoice.make.payment.modal');
            Route::post('single/invoice/wise/purchase/making/payment/','PurchaseController@makingSingleInvoiceWisePayment')->name('view.single.invoice.wise.payment.making.modal');
            Route::get('single/invoice/wise/purchase/payment/details/','PurchaseController@viewSingleInvoicePaymentDetails')->name('view.single.invoice.wise.payment.details.modal');
        });

        //quotation
        Route::group(['prefix'=>'admin/purchase/regular','as'=> 'admin.purchase.regular.quotation.', 'namespace'=>'Backend\Purchase\Details'],function(){
            Route::get('quotation/list','QuotationController@index')->name('index');//->middleware(['permissions:unit|index']);
            Route::get('quotation/list/by/ajr','QuotationController@quotationListByAjaxResponse')->name('list.ajaxresponse');//->middleware(['permissions:unit|index']);
            Route::get('quotation/single/view','QuotationController@singleView')->name('single.view');//->middleware(['permissions:unit|index']);
        });

        Route::group(['prefix'=>'admin/purchase/regular','as'=> 'admin.purchase.regular.','namespace'=>'Backend\Sell\Prints'],function(){
            //print purchase invoice :- pos print
            Route::get('pos/print/from/purchase/list/by/{invoiceId}','InvoicePrintController@posPrintFromPurchaseList')->name('pos.print.from.purchase.list');
            Route::get('normal/print/from/purchase/list/by/{invoiceId}','InvoicePrintController@normalPrintFromPurchaseList')->name('normal.print.from.purchase.list');
        });
    /*
    |-----------------------------------
    | Purchase list, print  and others
    |-----------------------------------
    */

    /*
    |-----------------------------------
    | Purchase product receive/delivery
    |-----------------------------------
    */
        Route::group(['as'=> 'admin.purchase.product.receive.','prefix'=>'admin/purchase/product/receive', 'namespace'=>'Backend\Purchase\Receive'],function(){
            Route::get('by/purchase/invoice','PurchaseProductReceiveController@index')->name('invoice.wise.list.index');//->middleware(['permissions:unit|index']);
            Route::post('by/purchase/invoice/store','PurchaseProductReceiveController@store')->name('invoice.wise.quantity.store');//->middleware(['permissions:unit|index']);
            
            Route::get('print/purchase/product/delivered/invoice/wise/product/list/{invoiceId}','PurchaseProductReceiveController@printPurchaseProductReceivedInvoiceWiseReceivedProductList')->name('print.product.received.invoice.wise.received.list');//->middleware(['permissions:unit|index']);
            //Route::get('invoice/wise/list','PurchaseProductReceiveController@index')->name('list.index');//->middleware(['permissions:unit|index']);
            //Route::get('list/by/ajr','PurchaseProductReceiveController@sellListByAjaxResponse')->name('sell.list.ajaxresponse');//->middleware(['permissions:unit|index']);
            //Route::get('single/view','PurchaseProductReceiveController@singleView')->name('sell.single.view');//->middleware(['permissions:unit|index']);
        });
    /*
    |-----------------------------------
    | Purchase product receive/delivery
    |-----------------------------------
    */

        

    /*
    |-----------------------------------
    | Report
    |-----------------------------------
    */
        Route::group(['as'=> 'admin.report.','prefix'=>'admin/report', 'namespace'=>'Backend\Report'],function(){
            Route::get('daily/transactional/summary','AllReportController@dalilyTransactionalReportSummary')->name('daily.transactional.report.summary');//->middleware(['permissions:unit|index']);
            Route::get('daily/transactional/details','AllReportController@dalilyReportTransactionalSummaryDetails')->name('daily.report.transactional.details');//->middleware(['permissions:unit|index']);
            Route::get('daily/transactional/profit/report','AllReportController@dailyTransactionalProfitReport')->name('daily.transactional.profit.report');//->middleware(['permissions:unit|index']);
            Route::get('daily/transactional/ladger/report','AllReportController@dailyTransactionalLadgerReport')->name('daily.transactional.ledger.report');//->middleware(['permissions:unit|index']);
        });
    /*
    |-----------------------------------
    | Report
    |-----------------------------------
    */  


    

});//end auth middleware


