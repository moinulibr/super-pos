
//-----------------------------------------------------------------------
$(document).ready(function(){
    productStockList();
});

function productStockList()
{
    var createUrl = $('.productStockListUrl').val();
    var page_no     = parseInt($('.page_no').val());
    var pagination  = $('.paginate :selected').val();
    var supplier_id = $('.supplier_filter_id :selected').val();
    var supplier_group_id = $('.ground_filter_id :selected').val();
    var brand_id = $('.brand_filter_id :selected').val();
    var category_id = $('.category_filter_id :selected').val();
    var search = $('.search').val();
    var url  =  createUrl+"?page="+page_no;
    $.ajax({
        url:url,
        data:{
            pagination:pagination,search:search,supplier_id:supplier_id,page_no:page_no,supplier_group_id:supplier_group_id,brand_id:brand_id,category_id:category_id
        },
        success:function(response){
            if(response.status == true)
            {
                $('.productStockListAjaxResponseResult').html(response.html);
            }
        }
    });
}


$(document).on("click",".pagination li a",function(e){
    e.preventDefault();
    var page = $(this).attr('href');
    var pageNumber = page.split('?page=')[1]; 
    return getPaginationData(pageNumber);
});

function getPaginationData(pageNumber){
    var createUrl = $('.productStockListUrl').val();
    var url =  createUrl+"?page="+pageNumber;
    var page_no     = parseInt($('.page_no').val());
    var pagination  = $('.paginate :selected').val();
    var supplier_id = $('.supplier_filter_id :selected').val();
    var supplier_group_id = $('.ground_filter_id :selected').val();
    var brand_id = $('.brand_filter_id :selected').val();
    var category_id = $('.category_filter_id :selected').val();
    var search = $('.search').val();
    $.ajax({
        url: url,
        data:{
            pagination:pagination,search:search,supplier_id:supplier_id,page_no:page_no,supplier_group_id:supplier_group_id,brand_id:brand_id,category_id:category_id
        },
        type: "GET",
        datatype:"HTML",
        success: function(response){
            if(response.status == true)
            {
                $('.productStockListAjaxResponseResult').html(response.html);
            }
        },
    });
}
//-----------------------------------------------------------------------

$(document).on('change','.paginate,.supplier_filter_id,.ground_filter_id,.brand_filter_id,.category_filter_id',function(){
    productStockList();
});




//-----------------------------------------------------------------------
    //search 
    var ctrlDown = false,ctrlKey = 17,cmdKey = 91,vKey = 86,cKey = 67;xKey = 88;
    $(document).on('keypress keyup','.search',function(e){
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
        if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey || e.keyCode == xKey)) return false;
        var search = $(this).val();
        var createUrl = $('.productStockListUrl').val();

        var page_no     = parseInt($('.page_no').val());
        var pagination  = $('.paginate :selected').val();
        var supplier_id = $('.supplier_filter_id :selected').val();
        var supplier_group_id = $('.ground_filter_id :selected').val();
        var brand_id = $('.brand_filter_id :selected').val();
        var category_id = $('.category_filter_id :selected').val();
        var url  =  createUrl+"?page="+page_no;
        $.ajax({
            url: url,
            data:{
                pagination:pagination,search:search,supplier_id:supplier_id,page_no:page_no,supplier_group_id:supplier_group_id,brand_id:brand_id,category_id:category_id
            },
            type: "GET",
            datatype:"HTML",
            success: function(response){
                if(response.status == true)
                {
                    $('.productStockListAjaxResponseResult').html(response.html);
                }
            },
        });
    });
//-----------------------------------------------------------------------



//-----------------------------------------------------------------------
$(document).on('click','.singleShowModal',function(e){
    e.preventDefault();
    var url = $('.showProductModalRoute').val();
    var id = $(this).data('id');
    $.ajax({
        url:url,
        data:{id:id},
        success:function(response){
            $('#showProductModal').html(response).modal('show');
        }
    });
});
//-----------------------------------------------------------------------




//single product stock history
//-----------------------------------------------------------------------
$(document).on('click','.singleProductStockHistoryShowModal',function(e){
    e.preventDefault();
    var url = $('.singleProductStockHistoryUrl').val();
    var id = $(this).data('id');
    $.ajax({
        url:url,
        data:{id:id},
        success:function(response){
            $('#showSingleProductStockHistoryModal').html(response.html).modal('show');
        }
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
                productStockList();
                $('#deleteConfirmationModal').modal('hide');//hide modal
            },1000);
        }
    });
}); */

