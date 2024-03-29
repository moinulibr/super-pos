    /*
    |--------------------------------------------------------
    | input field protected .. only for numeric
    |--------------------------------------------------------
    */
        jQuery(document).on('keyup keypress','.inputFieldValrIDatedOnlyNumeric',function(e){
            if (String.fromCharCode(e.keyCode).match(/[^0-9\.]/g)) return false;
        });


    //view sell invoice return modal
    //-----------------------------------------------------------------------
        $(document).on('click','.singleSellInvoiceReturnModalView',function(e){
            e.preventDefault();
            var url = $('.sellProductReturnInvoiceWiseModalRoute').val();
            var rID = $(this).data('id');
            $.ajax({
                url:url,
                data:{id:rID},
                success:function(response){
                    if(response.status == true)
                    {
                        $('#sellProductReturnModal').html(response.html).modal('show');
                        $('.return_product_related_response_here').html(response.product);
                        submitButtonEnable();
                        //$('.sell_return_payment_options_render').html(response.payment);
                    }
                }
            });
        });
    //-----------------------------------------------------------------------


    //
    $(document).on('keyup','.returning_qty',function(){
        var rID = $(this).data('id');
        var pressingReturnVal = $(this).val();
        var returningQtyNow = checkAndUncheckItemQuantityForReturn(rID);

        var finalReturningQty = 0;
        if(returningQtyNow >= pressingReturnVal)
        {
            finalReturningQty = pressingReturnVal;
        }else{
            finalReturningQty = returningQtyNow;
        }
        $('.returning_qty_'+rID).val(finalReturningQty);

        if(finalReturningQty == 0)
        {
            $('.check_single_class_for_return_'+rID).prop('checked', false).change();
            $('.check_single_class_for_return_'+rID).val('').change();
        }else{
            $('.check_single_class_for_return_'+rID).prop("checked", true).change();
            $('.check_single_class_for_return_'+rID).val(rID).change();
        }
        lineSubtotalCalculationAndSetForReturn(rID);
        subtotalBeforeDiscount();
    });


    // checked all order list 
    $(document).on('click','.check_all_class_for_return',function()
    {
        if (this.checked == false)
        {   
            $('.check_single_class_for_return').prop('checked', false).change();
            $(".check_single_class_for_return").each(function ()
            {
                var rID = $(this).attr('id');
                $(this).val('').change();
                $('.returning_qty_'+rID).val(0);
                lineSubtotalCalculationAndSetForReturn(rID);
            });
        }
        else
        {
            $('.check_single_class_for_return').prop("checked", true).change();

            $(".check_single_class_for_return").each(function ()
            {
                var rID = $(this).attr('id');
                //$(this).val(rID).change();

                var returningQtyNow = checkAndUncheckItemQuantityForReturn(rID);
                $('.returning_qty_'+rID).val(returningQtyNow);
                if(returningQtyNow == 0)
                {
                    $(this).prop('checked', false).change();
                    $(this).val('').change();
                }else{
                    $(this).prop("checked", true).change();
                    $(this).val(rID).change();
                }
                lineSubtotalCalculationAndSetForReturn(rID);
            });

           /*  $(".check_single_class_for_return").each(function ()
            {
                var rID = $(this).attr('id');
                $(this).val(rID).change();
            }); */
        }
        subtotalBeforeDiscount();
    });
    // checked all order list 

    
    //check single order list
    $(document).on('click','.check_single_class_for_return',function()
    {
        var $r = $('input[type=checkbox]');
        if($r.filter(':checked').length <= 0)
        {
            $('.check_all_class_for_return').prop('checked', false).change();
            $('.returning_qty').val(0);
        }

        var rID = $(this).attr('id');
        if (this.checked == false)
        {
            $(this).prop('checked', false).change();
            $(this).val('').change();
            $('.returning_qty_'+rID).val(0);
        }else{
            var returningQtyNow = checkAndUncheckItemQuantityForReturn(rID);
            $('.returning_qty_'+rID).val(returningQtyNow);
            
            if(returningQtyNow == 0)
            {
                $(this).prop('checked', false).change();
                $(this).val('').change();
            }else{
                $(this).prop("checked", true).change();
                $(this).val(rID).change();
            }
        }
        
        var rIDs = [];
        $('input.check_single_class_for_return[type=checkbox]').each(function () {
            if(this.checked){
                var rv = $(this).val();
                rIDs.push(rv);
            }
        });
        if(rIDs.length <= 0)
        {
            $('.check_all_class_for_return').prop('checked', false).change();
        }
        lineSubtotalCalculationAndSetForReturn(rID);
        subtotalBeforeDiscount();
    });
    //check single order list

    //check and uncheck item quantity for return
    function checkAndUncheckItemQuantityForReturn(rID)
    {
        var pressingQtyForReturn = parseFloat($('.returning_qty_'+rID).val());
        var totalQuantity = parseFloat($('.total_quantity_'+rID).val());
        var returningQtyNow = 0;
        if( (totalQuantity > 0) 
        )
        {
            returningQtyNow = totalQuantity; 
        }
        else if( (totalQuantity > 0) 
        )
        {
            returningQtyNow = totalQuantity; 
        }
        else if( (totalQuantity > 0) 
        )
        {
            returningQtyNow = pressingQtyForReturn; 
        }
        else if(totalQuantity == 0) 
        {
            returningQtyNow = 0; 
        }else{
            returningQtyNow = 0; 
        }
        return returningQtyNow; 
    }

    //line subtotal calculation and set
    function lineSubtotalCalculationAndSetForReturn(rID)
    {
        var pressingQtyForReturn = nanCheck(parseFloat($('.returning_qty_'+rID).val()));
        var totalQuantity = nanCheck(parseFloat($('.sold_price_for_return_'+rID).val()));
        var lineTotal = pressingQtyForReturn * totalQuantity ;
        $('.line_subtotal_for_return_'+rID).val(lineTotal);
    }

    //subtotal before discount
    function subtotalBeforeDiscount()
    {
        var subtotal = 0 ;
        $(".line_subtotal_for_return").each(function ()
        {
            subtotal += nanCheck(parseFloat($(this).val()));
        });
        subtotal = subtotal.toFixed(2);
        $('.subtotal_before_discount_for_return').text(subtotal);
        $('.subtotal_before_discount_for_return_val').val(subtotal);
        
        //if use it, then subtotal, total amount, payable amount always double shown
        discountCalculationBasedOnSubtotal();
        return subtotal;
    }



    //invoice discount related part
    var ctrlDown = false,ctrlKey = 17,cmdKey = 91,vKey = 86,cKey = 67; xKey = 88;
    jQuery(document).on('keyup blur change','.return_invoice_discount_amount,.return_invoice_discount_type',function(e){
        e.preventDefault();
        var action = 0;
        if(jQuery(e.target).prop("name") == "return_invoice_discount_amount" && ((e.type)=='keyup'))
        {
            action = 1;
        } 
        else if(jQuery(e.target).prop("name") == "return_invoice_discount_amount" && ((e.type)=='blur' || (e.type)=='focusout'))
        {
            action = 1;
        } 
        else if((jQuery(e.target).prop("name") == "return_invoice_discount_type") && ((e.type) =='change'))
        {
            action = 1;
        }
        else{
            action = 0;
        }
        if(action == 0) return;
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
        if (ctrlDown && ( e.keyCode == vKey || e.keyCode == cKey || e.keyCode == xKey)) return false;
        discountCalculationBasedOnSubtotal();
    });
    
    //making invoice discount
    function discountCalculationBasedOnSubtotal()
    {
        var invoiceDiscountAmount = jQuery('.return_invoice_discount_amount').val();
        var invoiceDiscountType = jQuery('.return_invoice_discount_type option:selected').val();
        var subtotalBeforeDiscount  = nanCheck(parseFloat(jQuery('.subtotal_before_discount_for_return').text())); 
        
        var totalInvoiceDiscountAmount  = 0; 
        if(subtotalBeforeDiscount > 0)
        {
            if(invoiceDiscountType == 'fixed'){
                totalInvoiceDiscountAmount  = invoiceDiscountAmount;
            }
            else if(invoiceDiscountType == 'percentage'){
                totalInvoiceDiscountAmount = ((((invoiceDiscountAmount * subtotalBeforeDiscount) / 100)).toFixed(2));
            }else{
                totalInvoiceDiscountAmount  = 0; 
            }
        }

        $('.return_invoice_total_discount_amount').val(totalInvoiceDiscountAmount);
        $('.return_invoice_total_discount_amount_val').val(totalInvoiceDiscountAmount);

        var totalReturnAmountAfterDiscount = subtotalBeforeDiscount - totalInvoiceDiscountAmount; 
        $('.total_return_amount_after_discount').text(totalReturnAmountAfterDiscount.toFixed(2));
        $('.total_return_amount_after_discount_val').val(totalReturnAmountAfterDiscount.toFixed(2));
        
        $('.total_return_amount_for_customer_history').text(totalReturnAmountAfterDiscount.toFixed(2));
        $('.total_return_amount_for_customer_history_val').val(totalReturnAmountAfterDiscount.toFixed(2));
        

        
        var totalInvoicePayableAmount = jQuery('.total_invoice_payable_amount').val();
        var totalInvoicePaidAmount = jQuery('.total_invoice_paid_amount').val();
        var totalInvoiceDueAmount = jQuery('.total_invoice_due_amount').val();

        var totalPayableAmountBasedOnDueAndPaidAmount = 0;
        if( totalReturnAmountAfterDiscount == totalInvoiceDueAmount){
            totalPayableAmountBasedOnDueAndPaidAmount = 0;
        }
        else if(totalReturnAmountAfterDiscount < totalInvoiceDueAmount){
            totalPayableAmountBasedOnDueAndPaidAmount = 0;
        } 
        else if(totalReturnAmountAfterDiscount > totalInvoiceDueAmount){
            totalPayableAmountBasedOnDueAndPaidAmount = totalReturnAmountAfterDiscount - totalInvoiceDueAmount;
        }

        $('.total_sell_return_invoice_payable_amount').text(totalPayableAmountBasedOnDueAndPaidAmount.toFixed(2));
        $('.total_sell_return_invoice_payable_amount_val').val(totalPayableAmountBasedOnDueAndPaidAmount.toFixed(2));
       

        //payments part, return payable amount
        //linkBetweenSellReturnFunctionAndSellReturnPaymentOption();
    }

    function discountCalculationBasedOnSubtotalAfterSubmit()
    {
        subtotalBeforeDiscount();
        discountCalculationBasedOnSubtotal();
    }


    //submit return data
    jQuery(document).on("submit",'.storeReturnDataFromReturnOption',function(e){
        e.preventDefault();
        $('.alert_success_message_div').hide();
        $('.success_message_text').text('');
        $('.alert_danger_message_div').hide();
        $('.danger_message_text').text('');
        submitButtonDisabled();
        var form = jQuery(this);
        var url = form.attr("action");
        var type = form.attr("method");
        var data = form.serialize();
        jQuery.ajax({
            url: url,
            data: data,
            type: type,
            datatype:"JSON",
            beforeSend:function(){
                jQuery('.processing').fadeIn();
                jQuery('.submit_processing_gif').fadeIn();
                jQuery('.submit_loader').fadeIn();
            },
            success: function(response){
                if(response.status == true)
                {
                    jQuery.notify(response.message, response.type);
                    $('.return_product_related_response_here').html(response.product);
                    //$('.sell_return_payment_options_render').html(response.payment);
                    $('.alert_success_message_div').show();
                    $('.success_message_text').html(response.message+"<br/>"+response.print);
                    discountCalculationBasedOnSubtotalAfterSubmit();
                    sellList();
                    $('#sellProductReturnModal').modal('hide');
                }else{
                    $('.alert_danger_message_div').show();
                    $('.danger_message_text').text(response.message);
                    jQuery.notify(response.message, response.type);
                    submitButtonEnable();
                }
            },
            complete:function(){
                jQuery('.submit_processing_gif').fadeOut();
                jQuery('.processing').fadeOut();
                jQuery('.submit_loader').fadeOut();
            },
        });
        //end ajax
    });


    //submit button disabled
    function submitButtonDisabled()
    {
        jQuery('.submitButton_for_sell_return').attr('disabled',true); 
    }
    //submit button enabled
    function submitButtonEnable()
    {
        jQuery('.submitButton_for_sell_return').removeAttr('disabled'); 
    }
    //enable disabled submit button

    function nanCheck(value)
    {
        if(isNaN(value))
        {
            return 0;
        }
        else{
            return value;
        }
    }
