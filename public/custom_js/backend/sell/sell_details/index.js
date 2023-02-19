    
    $(document).ready(function(){
        sellList();
    });

    function sellList()
    {
        var createUrl = $('.sellListUrl').val();
        var page_no     = parseInt($('.page_no').val());
        var pagination  = $('.paginate :selected').val();

        var date_from = $('.date_from').val();
        var date_to = $('.date_to').val();

        var search = $('.search').val();
        var url  =  createUrl+"?page="+page_no;

        $.ajax({
            url:url,
            data:{
                pagination:pagination,search:search,page_no:page_no,date_from:date_from,date_to:date_to
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
        
        var date_from = $('.date_from').val();
        var date_to = $('.date_to').val();

        var search = $('.search').val();

        $.ajax({
            url: url,
            data:{
                pagination:pagination,search:search,page_no:page_no,date_from:date_from,date_to:date_to
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

    $(document).on('click change','.date_from,.date_to,.paginate',function(){
        sellList();
    });




//-----------------------------------------------------------------------
    //search
    var ctrlDown = false,ctrlKey = 17,cmdKey = 91,vKey = 86,cKey = 67;xKey = 88;
    $(document).on('keypress keyup','.search',function(e){
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
        if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey || e.keyCode == xKey)) return false;
        var search = $(this).val();
        var createUrl = $('.sellListUrl').val();
        var page_no     = parseInt($('.page_no').val());
        var pagination  = $('.paginate :selected').val();

        var date_from = $('.date_from').val();
        var date_to = $('.date_to').val();

        var url  =  createUrl+"?page="+page_no;
        $.ajax({
            url: url,
            data:{
                pagination:pagination,search:search,page_no:page_no,date_from:date_from,date_to:date_to
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
    $(document).on('click','.singleViewSellInvoiceOverallAjdustmentDiscountDetailsModal',function(e){
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
    
    $(document).on('click','.receivingOverallAdjustmentLessAmount',function(e){
        e.preventDefault();
        var url = $('.sellViewSingleInvoiceOverallAdjustmentDiscountReceivingRouteUrl').val();
        var amount = $('.receivingOverallAdjustmentAmount').val();
        var id = $('.receivingOverallAdjustmentAmountId').val();
        $('.receivingOverallAdjustmentLessAmount').attr('disabled',true);
        if(!amount){
            alert('Amount is required');
            return;
        }
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
                $('.pdfDownload').hide();
                $('.check_single_class').prop('checked', false).change();
                $(".check_single_class").each(function ()
                {
                    var id = $(this).attr('id');
                    $(this).val('').change();
                });
            }
            else
            {
                $('.pdfDownload').show();
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
                $('.pdfDownload').hide();
                $('.check_all_class').prop('checked', false).change();
            }

            var id = $(this).attr('id');
            if (this.checked == false)
            {
                $(this).prop('checked', false).change();
                $(this).val('').change();
            }else{
                $('.pdfDownload').show();

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
                $('.pdfDownload').hide();
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
