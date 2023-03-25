    
    $(document).ready(function(){
        purchaseList();
    });

    function purchaseList()
    {
        var createUrl = $('.purchaseListUrl').val();
        var page_no     = parseInt($('.page_no').val());
        var pagination  = $('.paginate :selected').val();

        var date_from = $('.date_from').val();
        var date_to = $('.date_to').val();

        var search = $('.search').val();
        var supplier = $('.supplier').val();
        var url  =  createUrl+"?page="+page_no;

        $.ajax({
            url:url,
            data:{
                pagination:pagination,search:search,supplier:supplier,page_no:page_no,date_from:date_from,date_to:date_to
            },
            success:function(response){
                if(response.status == true)
                {
                    $('.purchaseListAjaxResponseResult').html(response.html);
                }
            }
        });
    }

    $(document).on('click change','.date_from,.date_to,.paginate',function(){
        purchaseList();
    });


    $(document).on("click",".pagination li a",function(e){
        e.preventDefault();
        var page = $(this).attr('href');
        var pageNumber = page.split('?page=')[1]; 
        return getPagination(pageNumber);
    });

    function getPagination(pageNumber){
        var createUrl = $('.purchaseListUrl').val();

        var page_no     = parseInt($('.page_no').val());
        
        var pagination  = $('.paginate :selected').val();
        
        var date_from = $('.date_from').val();
        var date_to = $('.date_to').val();

        var search = $('.search').val();
        var supplier = $('.supplier').val();

        var url =  createUrl+"?page="+pageNumber;
        $.ajax({
            url: url,
            type: "GET",
            data:{
                pagination:pagination,search:search,supplier:supplier,page_no:page_no,date_from:date_from,date_to:date_to
            },
            datatype:"HTML",
            success: function(response){
                if(response.status == true)
                {
                    $('.purchaseListAjaxResponseResult').html(response.html);
                }
            },
        });
    }
//-----------------------------------------------------------------------




//-----------------------------------------------------------------------
    //search 
    var ctrlDown = false,ctrlKey = 17,cmdKey = 91,vKey = 86,cKey = 67;xKey = 88;
    $(document).on('keypress keyup','.search, .supplier',function(e){
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
        if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey || e.keyCode == xKey)) return false;
        var search = $('.search').val();
        var createUrl = $('.purchaseListUrl').val();
        var page_no     = parseInt($('.page_no').val());
        var pagination  = $('.paginate :selected').val();

        var date_from = $('.date_from').val();
        var date_to = $('.date_to').val();
        var supplier = $('.supplier').val();

        var url  =  createUrl+"?page="+page_no;
        $.ajax({
            url: url,
            data:{
                pagination:pagination,search:search,supplier:supplier,page_no:page_no,date_from:date_from,date_to:date_to
            },
            type: "GET",
            datatype:"HTML",
            success: function(response){
                if(response.status == true)
                {
                    $('.purchaseListAjaxResponseResult').html(response.html);
                }
            },
        });
    });
//-----------------------------------------------------------------------


//-----------------------------------------------------------------------
    $(document).on('click','.singlePurchaseView',function(e){
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


$(document).on('click','.singleViewPurchaseInvoiceWisePaymentModal',function(e){
    e.preventDefault();
    var url = $('.purchaseViewSingleInvoiceWisePaymentModalRoute').val();
    var id = $(this).data('id');
    $.ajax({
        url:url,
        data:{id:id},
        success:function(response){
            if(response.status == true)
            {
                purchaseList();
                $('#purchaseViewSingleInvoiceWisePaymentModal').html(response.html).modal('show');
            }
        }
    });
});

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
                purchaseList();
                $('#deleteConfirmationModal').modal('hide');//hide modal
            },1000);
        }
    });
}); */

