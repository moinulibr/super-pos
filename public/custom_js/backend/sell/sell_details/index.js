    
    $(document).ready(function(){
        sellList();
    });

    function sellList()
    {
        var createUrl = $('.sellListUrl').val();
        var page_no     = parseInt($('.page_no').val());
        var pagination  = $('.paginate :selected').val();
        var payment_status  = $('.payment_status :selected').val();
        var sold_type  = $('.sold_type :selected').val();
        var delivery_status  = $('.delivery_status :selected').val();

        var date_from = $('.date_from').val();
        var date_to = $('.date_to').val();

        var search = $('.search').val();
        var customer = $('.customer').val();
        var url  =  createUrl+"?page="+page_no;

        $.ajax({
            url:url,
            data:{
                pagination:pagination,search:search,customer:customer,page_no:page_no,date_from:date_from,date_to:date_to,payment_status:payment_status,sold_type:sold_type,delivery_status:delivery_status
            },
            success:function(response){
                if(response.status == true)
                {
                    $('.sellListAjaxResponseResult').html(response.html);
                }
            }
        });
    }


    $(document).on("click",".pagination li a",function(e){
        e.preventDefault();
        var page = $(this).attr('href');
        var pageNumber = page.split('?page=')[1]; 
        return getPagination(pageNumber);
    });

    function getPagination(pageNumber){
        var createUrl = $('.sellListUrl').val();
        var url =  createUrl+"?page="+pageNumber;

        var createUrl = $('.sellListUrl').val();
        var page_no     = parseInt($('.page_no').val());
        var pagination  = $('.paginate :selected').val();
        var payment_status  = $('.payment_status :selected').val();
        var sold_type  = $('.sold_type :selected').val();
        var delivery_status  = $('.delivery_status :selected').val();

        var date_from = $('.date_from').val();
        var date_to = $('.date_to').val();

        var search = $('.search').val();
        var customer = $('.customer').val();

        $.ajax({
            url: url,
            data:{
                pagination:pagination,search:search,customer:customer,page_no:page_no,date_from:date_from,date_to:date_to,payment_status:payment_status,sold_type:sold_type,delivery_status:delivery_status
            },
            type: "GET",
            datatype:"HTML",
            success: function(response){
                if(response.status == true)
                {
                    $('.sellListAjaxResponseResult').html(response.html);
                }
            },
        });
    }
//-----------------------------------------------------------------------

    $(document).on('click change','.date_from,.date_to,.paginate,.payment_status,.sold_type,.delivery_status',function(){
        sellList();
    });




//-----------------------------------------------------------------------
    //search
    var ctrlDown = false,ctrlKey = 17,cmdKey = 91,vKey = 86,cKey = 67;xKey = 88;
    $(document).on('keypress keyup','.search, .customer',function(e){
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
        if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey || e.keyCode == xKey)) return false;
        var search = $('.search').val();
        var createUrl = $('.sellListUrl').val();
        var page_no     = parseInt($('.page_no').val());
        var pagination  = $('.paginate :selected').val();
        var payment_status  = $('.payment_status :selected').val();
        var sold_type  = $('.sold_type :selected').val();
        var delivery_status  = $('.delivery_status :selected').val();

        var date_from = $('.date_from').val();
        var date_to = $('.date_to').val();
        var customer = $('.customer').val();

        var url  =  createUrl+"?page="+page_no;
        $.ajax({
            url: url,
            data:{
                pagination:pagination,search:search,customer:customer,page_no:page_no,date_from:date_from,date_to:date_to,payment_status:payment_status,sold_type:sold_type,delivery_status:delivery_status
            },
            type: "GET",
            datatype:"HTML",
            success: function(response){
                if(response.status == true)
                {
                    $('.sellListAjaxResponseResult').html(response.html);
                }
            },
        });
    });
//-----------------------------------------------------------------------


//-----------------------------------------------------------------------
    $(document).on('click','.singleSellView',function(e){
        e.preventDefault();
        var url = $('.singleViewModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                if(response.status == true)
                {
                    $('#singleModalView').html(response.html).modal('show');
                }
            }
        });
    });
//-----------------------------------------------------------------------

//-----------------------------------------------------------------------
    $(document).on('click','.singleSellInvoiceProfitLossView',function(e){
        e.preventDefault();
        var url = $('.singleSellInvoiceProftLossModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                if(response.status == true)
                {
                    $('#singleSellInvoiceProftLossModalView').html(response.html).modal('show');
                }
            }
        });
    });
//-----------------------------------------------------------------------


//-----------------------------------------------------------------------
    $(document).on('click','.singleViewSellInvoiceWisePaymentDetailsModal',function(e){
        e.preventDefault();
        var url = $('.viewSellSingleInvoiceReceivePaymentModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                if(response.status == true)
                {
                    $('#viewSellSingleInvoiceReceivePaymentModal').html(response.html).modal('show');
                }
            }
        });
    });
//-----------------------------------------------------------------------


//-----------------------------------------------------------------------
    $(document).on('click','.singleViewSellInvoiceOverallDiscountDetailsModal',function(e){
        e.preventDefault();
        var url = $('.sellViewSingleInvoiceOverallAdjustmentDiscountModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                if(response.status == true)
                {
                    $('#sellViewSingleInvoiceOverallAdjustmentDiscountModal').html(response.html).modal('show');
                }
            }
        });
    });
    
    $(document).on('click','.receivingOverallDiscountAmountSubmit',function(e){
        e.preventDefault();
        var url = $('.sellViewSingleInvoiceOverallAdjustmentDiscountReceivingRouteUrl').val();
        var amount = parseFloat($('.receivingOverallDiscountAmount').val());
        var id = $('.receivingOverallDiscountAmountId').val();
        var netProfit = parseFloat($('.totalNetProfitOfThisInvoice').val());
        if(!amount){
            alert('Amount is required');
            return;
        }
        if(netProfit <= amount){
            alert('Invalid Amount');
            return;
        }
        $('.receivingOverallDiscountAmountSubmit').attr('disabled',true);
        $.ajax({
            url:url,
            data:{id:id,amount:amount},
            beforeSend:function(){
                jQuery('.submit_button_processing_gif').fadeIn();
            },
            success:function(response){
                $.notify(response.message, response.type);
                setTimeout(function(){
                    sellList();
                    $('#sellViewSingleInvoiceOverallAdjustmentDiscountModal').modal('hide');//hide modal
                },500);
            },
            complete:function(){
                jQuery('.submit_button_processing_gif').fadeOut();
            },
        });
    }); 
//-----------------------------------------------------------------------


    /* $(document).on('click','.singleDeleteModal',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('.deletingCustomerId').val(id);
        $('.deletingCustomerName').text(name);
        $('#deleteConfirmationModal').modal('show');
    });

    $(document).on('click','.deletingCustomerButton',function(e){
        e.preventDefault();
        var url = $('.deleteCustomerModalRoute').val();
        var id = $('.deletingCustomerId').val();
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                $('.deletingCustomerId').val('');
                $.notify(response.message, response.type);
                setTimeout(function(){
                    sellList();
                    $('#deleteConfirmationModal').modal('hide');//hide modal
                },1000);
            }
        });
    }); */


  
    // checked all order list 
    $(document).on('click','.check_all_class',function()
    {
        if (this.checked == false)
        {   
            $('.PrintPdfDownload').hide();
            $('.check_single_class').prop('checked', false).change();
            $(".check_single_class").each(function ()
            {
                var id = $(this).attr('id');
                $(this).val('').change();
            });
        }
        else
        {
            $('.PrintPdfDownload').show();
            $('.check_single_class').prop("checked", true).change();
            $(".check_single_class").each(function ()
            {
                var id = $(this).attr('id');
                $(this).val(id).change();
            });
        }
    });
    // checked all order list 


    //check single order list
    $(document).on('click','.check_single_class',function()
    {
        var $b = $('input[type=checkbox]');
        if($b.filter(':checked').length <= 0)
        {
            $('.PrintPdfDownload').hide();
            $('.check_all_class').prop('checked', false).change();
        }

        var id = $(this).attr('id');
        if (this.checked == false)
        {
            $(this).prop('checked', false).change();
            $(this).val('').change();
        }else{
            $('.PrintPdfDownload').show();

            $(this).prop("checked", true).change();
            $(this).val(id).change();
        }
        
        var ids = [];
        $('input.check_single_class[type=checkbox]').each(function () {
            if(this.checked){
                var v = $(this).val();
                ids.push(v);
            }
        });
        if(ids.length <= 0)
        {
            $('.PrintPdfDownload').hide();
            $('.check_all_class').prop('checked', false).change();
        }
    });
    //check single order list


    //order action end  download)
        /* $(document).on('click', '.published-button', function (){
            var ids = [];
            $('input.check_single_class[type=checkbox]').each(function () {
                if(this.checked){
                    var v = $(this).val();
                    ids.push(v);
                }
            });
            var url =  "";

            if(ids.length <= 0) return ;
            var page_no         = $('.page_no').val();
            $.ajax({
                url: url,
                data: {ids: ids,page_no:page_no},
                type: "POST",
                beforeSend:function(){
                    $('.loading').fadeIn();
                    $('.loadingText').show();
                },
                success: function(response){
                    if(response.status == true)
                    {
                        $('.alert-success').show();
                        $('.text-left').text(response.message);
                        defaultLoading(page_no);
                    }
                },
                complete:function(){
                    $('.loading').fadeOut();
                    $('.loadingText').hide();
                },
            });
        }); */
    //order action end 
