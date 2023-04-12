
    //add next payment date
    $(document).on('click','.singleNextPaymentDateModal',function(e){
        e.preventDefault();
        var url = $('.renderNextPaymentDateModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                $('#renderNextPaymentDateModal').html(response.view).modal('show');//hide modal
            }
        });
    });

    jQuery(document).on("submit",'.storeNextPaymentDate',function(e){
        e.preventDefault();
        var form = jQuery(this);
        var url = form.attr("action");
        var type = form.attr("method");
        var data = form.serialize();
        jQuery('.color-red').text('');
        jQuery.ajax({
            url: url,
            data: data,
            type: type,
            datatype:"JSON",
            beforeSend:function(){
                jQuery('.processing').fadeIn();
            },
            success: function(response){
                if(response.status == 'errors')
                {   
                    printErrorMsg(response.error);
                }
                else if(response.status == true)
                {
                    jQuery.notify(response.message, response.type);
                    form[0].reset();
                    customerList();
                    setTimeout(function(){
                        jQuery('#renderNextPaymentDateModal').modal('hide');//hide modal
                    },1000);
                }
            },
            complete:function(){
                jQuery('.processing').fadeOut();
            },
        });
        //end ajax

        function printErrorMsg(msg) {
            jQuery('.color-red').css({'color':'red'});
            jQuery.each(msg, function(key, value ) {
                jQuery('.'+key+'_err').text(value);
            });
        }
    });


    
    //-------------------------------------------------
    //add loan moal
    $(document).on('click','.singleAddLoanModal',function(e){
        e.preventDefault();
        var url = $('.renderAddLoanModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                $('#renderAddLoanModal').html(response.view).modal('show');//hide modal
            }
        });
    });

    jQuery(document).on("submit",'.storeAddLoanDate',function(e){
        e.preventDefault();
        var form = jQuery(this);
        var url = form.attr("action");
        var type = form.attr("method");
        var data = form.serialize();
        jQuery('.color-red').text('');
        jQuery.ajax({
            url: url,
            data: data,
            type: type,
            datatype:"JSON",
            beforeSend:function(){
                jQuery('.processing').fadeIn();
            },
            success: function(response){
                if(response.status == 'errors')
                {   
                    printErrorMsg(response.error);
                }
                else if(response.status == true)
                {
                    jQuery.notify(response.message, response.type);
                    form[0].reset();
                    customerList();
                    setTimeout(function(){
                        jQuery('#renderAddLoanModal').modal('hide');//hide modal
                    },1000);
                }
            },
            complete:function(){
                jQuery('.processing').fadeOut();
            },
        });
        //end ajax

        function printErrorMsg(msg) {
            jQuery('.color-red').css({'color':'red'});
            jQuery.each(msg, function(key, value ) {
                jQuery('.'+key+'_err').text(value);
            });
        }
    });

 
    //-------------------------------------------------
    //add add advance modal
    $(document).on('click','.singleAddAdvanceModal',function(e){
        e.preventDefault();
        var url = $('.renderAddAdvanceModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                $('#renderAddAdvanceModal').html(response.view).modal('show');//hide modal
            }
        });
    });

    jQuery(document).on("submit",'.storeAddAdvanceDate',function(e){
        e.preventDefault();
        var form = jQuery(this);
        var url = form.attr("action");
        var type = form.attr("method");
        var data = form.serialize();
        jQuery('.color-red').text('');
        jQuery.ajax({
            url: url,
            data: data,
            type: type,
            datatype:"JSON",
            beforeSend:function(){
                jQuery('.processing').fadeIn();
            },
            success: function(response){
                if(response.status == 'errors')
                {   
                    printErrorMsg(response.error);
                }
                else if(response.status == true)
                {
                    jQuery.notify(response.message, response.type);
                    form[0].reset();
                    customerList();
                    setTimeout(function(){
                        jQuery('#renderAddAdvanceModal').modal('hide');//hide modal
                    },1000);
                }
            },
            complete:function(){
                jQuery('.processing').fadeOut();
            },
        });
        //end ajax

        function printErrorMsg(msg) {
            jQuery('.color-red').css({'color':'red'});
            jQuery.each(msg, function(key, value ) {
                jQuery('.'+key+'_err').text(value);
            });
        }
    });


    //-------------------------------------------------
    //receive previous due modal
    $(document).on('click','.singleReceivePreviousDueModal',function(e){
        e.preventDefault();
        var url = $('.renderReceivePreviousDueModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                $('#renderReceivePreviousDueModal').html(response.view).modal('show');//hide modal
            }
        });
    });

    jQuery(document).on("submit",'.storeReceivePreviousDueDate',function(e){
        e.preventDefault();
        var form = jQuery(this);
        var url = form.attr("action");
        var type = form.attr("method");
        var data = form.serialize();
        jQuery('.color-red').text('');
        jQuery.ajax({
            url: url,
            data: data,
            type: type,
            datatype:"JSON",
            beforeSend:function(){
                jQuery('.processing').fadeIn();
            },
            success: function(response){
                if(response.status == 'errors')
                {   
                    printErrorMsg(response.error);
                }
                else if(response.status == true)
                {
                    jQuery.notify(response.message, response.type);
                    form[0].reset();
                    customerList();
                    setTimeout(function(){
                        jQuery('#renderReceivePreviousDueModal').modal('hide');//hide modal
                    },1000);
                }
            },
            complete:function(){
                jQuery('.processing').fadeOut();
            },
        });
        //end ajax

        function printErrorMsg(msg) {
            jQuery('.color-red').css({'color':'red'});
            jQuery.each(msg, function(key, value ) {
                jQuery('.'+key+'_err').text(value);
            });
        }
    });



    
    //-------------------------------------------------
    //return advance amount modal
    $(document).on('click','.singleReturnAdvanceAmountModal',function(e){
        e.preventDefault();
        var url = $('.renderReturnAdvanceAmountModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                $('#renderReturnAdvanceAmountModal').html(response.view).modal('show');//hide modal
            }
        });
    });
    
    
    jQuery(document).on("submit",'.storeReturnAdvanceAmountDate',function(e){
        e.preventDefault();
        var form = jQuery(this);
        var url = form.attr("action");
        var type = form.attr("method");
        var data = form.serialize();
        jQuery('.color-red').text('');
        jQuery.ajax({
            url: url,
            data: data,
            type: type,
            datatype:"JSON",
            beforeSend:function(){
                jQuery('.processing').fadeIn();
            },
            success: function(response){
                if(response.status == 'errors')
                {   
                    printErrorMsg(response.error);
                }
                else if(response.status == true)
                {
                    jQuery.notify(response.message, response.type);
                    form[0].reset();
                    customerList();
                    setTimeout(function(){
                        jQuery('#renderReturnAdvanceAmountModal').modal('hide');//hide modal
                    },1000);
                }
            },
            complete:function(){
                jQuery('.processing').fadeOut();
            },
        });
        //end ajax

        function printErrorMsg(msg) {
            jQuery('.color-red').css({'color':'red'});
            jQuery.each(msg, function(key, value ) {
                jQuery('.'+key+'_err').text(value);
            });
        }
    });

    
    
    //-------------------------------------------------
    //receive loan amount modal
    $(document).on('click','.singleReceiveLoanAmountModal',function(e){
        e.preventDefault();
        var url = $('.renderReceiveLoanAmountModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                $('#renderReceiveLoanAmountModal').html(response.view).modal('show');//hide modal
            }
        });
    });

    jQuery(document).on("submit",'.storeReceiveLoanAmountDate',function(e){
        e.preventDefault();
        var form = jQuery(this);
        var url = form.attr("action");
        var type = form.attr("method");
        var data = form.serialize();
        jQuery('.color-red').text('');
        jQuery.ajax({
            url: url,
            data: data,
            type: type,
            datatype:"JSON",
            beforeSend:function(){
                jQuery('.processing').fadeIn();
            },
            success: function(response){
                if(response.status == 'errors')
                {   
                    printErrorMsg(response.error);
                }
                else if(response.status == true)
                {
                    jQuery.notify(response.message, response.type);
                    form[0].reset();
                    customerList();
                    setTimeout(function(){
                        jQuery('#renderReceiveLoanAmountModal').modal('hide');//hide modal
                    },1000);
                }
            },
            complete:function(){
                jQuery('.processing').fadeOut();
            },
        });
        //end ajax

        function printErrorMsg(msg) {
            jQuery('.color-red').css({'color':'red'});
            jQuery.each(msg, function(key, value ) {
                jQuery('.'+key+'_err').text(value);
            });
        }
    });


    


    
    //----------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------
    //all invoice payment receive
    $(document).on('click','.receiveAllInvoiceDuesModal',function(e){
        e.preventDefault();
        var url = $('.renderReceiveAllInvoiceDueModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                $('#renderReceiveAllInvoiceDueModal').html(response.view).modal('show');//hide modal
                defaultTotalInvoiceWiseDue();
                $('.invoiceTotalPayingAmountAsDisplay').val(0); 
                submitButtonDisabled();
            }
        });
    });

    //total customer given amount
    $(document).on('keyup','.invoiceTotalPayingAmount, .totalCustomerGivenAmount',function(){
        totalCustomerGivenAmountFromCustomer();
        submitButtonEnableDisabled();
    });

    //total customer given amount from customer
    function totalCustomerGivenAmountFromCustomer(){
        var totalCustomerGivenAmount = $('.totalCustomerGivenAmount').val();
        var totalSumOfAllDueAmount = sumOfAllDueAmount();

        var totalPayingAmount = 0;
        var returnAmount = 0;
        if(totalSumOfAllDueAmount > totalCustomerGivenAmount){
            totalPayingAmount = totalCustomerGivenAmount;
            returnAmount = 0;
        }
        else if(totalSumOfAllDueAmount == totalCustomerGivenAmount){
            totalPayingAmount = totalSumOfAllDueAmount;
            returnAmount = 0;
        }else if(totalSumOfAllDueAmount < totalCustomerGivenAmount){
            totalPayingAmount = totalSumOfAllDueAmount;
            returnAmount = totalCustomerGivenAmount - totalSumOfAllDueAmount;
        }
        $('.returnAmountToCustomer').val(returnAmount);
        
        $('.invoiceTotalPayingAmount').val(totalPayingAmount);
        $('.invoiceTotalPayingAmountAsDisplay').val(totalPayingAmount);//this would be over write in the bottom section for perfect result
        var customerGivenAmount = totalPayingAmount ;//$('.invoiceTotalPayingAmount').val();
        
        var remainingOrOverallDiscount = 0;
        if(totalSumOfAllDueAmount > customerGivenAmount){
            remainingOrOverallDiscount = totalSumOfAllDueAmount - customerGivenAmount;
        }
        else if(totalSumOfAllDueAmount == customerGivenAmount){
            remainingOrOverallDiscount = 0;
        }else if(totalSumOfAllDueAmount < customerGivenAmount){
            remainingOrOverallDiscount = 0;
        }
        $('.overallTotalDiscountAmount').val(remainingOrOverallDiscount);

        //|| customerGivenAmount < totalSumOfAllDueAmount
        if(customerGivenAmount == 0 ){
            $('.singleAndCustomReceivingAmount').val(0);
            
            $('.checkAllReceiveIvoiceDue').prop('checked', false).change();
            $('.checkSingleReceiveIvoiceDue').prop('checked', false).change();
            $('.checkSingleReceiveIvoiceDue').val('');
        }
        else if(customerGivenAmount > 0){
            allChangedCheckAndUncheckOption();
        }
    }


    //all chenged check and uncheck option
    function allChangedCheckAndUncheckOption(){
        $(".checkSingleReceiveIvoiceDue").each(function (){
            var invoiceId = $(this).attr('id');
            //$(this).val(invoiceId).change();
            var payingDueAmount = checkAndUncheckItemDuePayingAmount(invoiceId);
            
            $('.singleAndCustomReceivingAmount_'+invoiceId).val(payingDueAmount);

            if(payingDueAmount == 0)
            {
                $(this).prop('checked', false).change();
                $(this).val('').change();
            }else{
                $(this).prop("checked", true).change();
                $(this).val(invoiceId).change();
            }
            singleInvoiceWiseDueAmount(invoiceId);
        });
    }

    //single and Custom receiveing amount
    $(document).on('keyup','.singleAndCustomReceivingAmount',function(){
        var invoiceId = $(this).data('id');
        var pressingVal = $(this).val();
        var finalPayingAmount = changeToCheckOrUncheckOptionSinglePaymentProcessing(invoiceId);
        $('.singleAndCustomReceivingAmount_'+invoiceId).val(finalPayingAmount);
        if(finalPayingAmount == 0){
            $('.checkSingleReceiveIvoiceDue_'+invoiceId).prop('checked', false).change();
            $('.checkSingleReceiveIvoiceDue_'+invoiceId).val('').change();
        }else{
            $('.checkSingleReceiveIvoiceDue_'+invoiceId).prop("checked", true).change();
            $('.checkSingleReceiveIvoiceDue_'+invoiceId).val(invoiceId).change();
        }

        singleInvoiceWiseDueAmount(invoiceId);

        submitButtonEnableDisabled();
    });

    //change to check or uncheck option single payment processing
    function changeToCheckOrUncheckOptionSinglePaymentProcessing(invoiceId)
    {
        var customerGivenAmount = parseFloat(nanCheck($('.invoiceTotalPayingAmount').val()));

        var usedAmountWithCurrentPressingAmount = 0;
        $(".singleAndCustomReceivingAmount").each(function ()
        {
            usedAmountWithCurrentPressingAmount += parseFloat(nanCheck($(this).val())) || 0;
        });
        var currentPressingAmount = parseFloat(nanCheck($('.singleAndCustomReceivingAmount_'+invoiceId).val()));
        var totalUsedAmount = usedAmountWithCurrentPressingAmount - currentPressingAmount;
         
        var remainingAmount = 0;
        if(customerGivenAmount == totalUsedAmount){
            remainingAmount = 0;
        }
        else if(customerGivenAmount > totalUsedAmount){
            remainingAmount = customerGivenAmount - totalUsedAmount;
        }
        else if(customerGivenAmount < totalUsedAmount){
            remainingAmount = 0;
        }
        
        var currentPressingAmountRightNow = parseFloat(nanCheck($('.singleAndCustomReceivingAmount_'+invoiceId).val()))|| 0;
        var currentInvoiceDueTotalAmount = parseFloat(nanCheck($('.singleInvoiceDueAmount_'+invoiceId).val()));

        var pressingLimitAmount = 0;
        if(currentInvoiceDueTotalAmount == currentPressingAmountRightNow){
            pressingLimitAmount = currentInvoiceDueTotalAmount;
        }
        else if(currentInvoiceDueTotalAmount > currentPressingAmountRightNow){
            pressingLimitAmount = currentPressingAmountRightNow;
        }
        else if(currentInvoiceDueTotalAmount < currentPressingAmountRightNow){
            pressingLimitAmount = currentInvoiceDueTotalAmount;
        }
       
        var lastLimitOfPressingAmount = 0; 
        if(remainingAmount ==  pressingLimitAmount){
            lastLimitOfPressingAmount = pressingLimitAmount; 
        } 
        else if(remainingAmount >  pressingLimitAmount){
            lastLimitOfPressingAmount = pressingLimitAmount; 
        }
        else if(remainingAmount < pressingLimitAmount){
            lastLimitOfPressingAmount = remainingAmount; 
        }
        return lastLimitOfPressingAmount;
    }



    // checked all order list 
    $(document).on('click','.checkAllReceiveIvoiceDue',function()
    {
        var invoiceTotalPayingAmount = $('.invoiceTotalPayingAmount').val();
        if(invoiceTotalPayingAmount > 0){
            if (this.checked == false)
            {   
                $('.checkSingleReceiveIvoiceDue').prop('checked', false).change();
                $(".checkSingleReceiveIvoiceDue").each(function ()
                {
                    var invoiceId = $(this).attr('id');
                    $(this).val('').change();
                    $('.singleAndCustomReceivingAmount_'+invoiceId).val(0);

                    singleInvoiceWiseDueAmount(invoiceId);

                });
            }
            else
            {
                $('.checkSingleReceiveIvoiceDue').prop("checked", true).change();
                allChangedCheckAndUncheckOption();
            }
        }
        submitButtonEnableDisabled();
    });
    // checked all order list 

    
    //check single order list
    $(document).on('click','.checkSingleReceiveIvoiceDue',function(){

        var invoiceTotalPayingAmount = $('.invoiceTotalPayingAmount').val() || 0;
        if(invoiceTotalPayingAmount > 0){
            var $db = $('input[type=checkbox]');
            if($db.filter(':checked').length <= 0)
            {
                $('.checkAllReceiveIvoiceDue').prop('checked', false).change();
                $('.singleAndCustomReceivingAmount').val(0);
            }

            var invoiceId = $(this).attr('id');
            if (this.checked == false)
            {
                $(this).prop('checked', false).change();
                $(this).val('').change();
                $('.singleAndCustomReceivingAmount_'+invoiceId).val(0);
            }else{
                var payingAmountNow = checkAndUncheckItemDuePayingAmount(invoiceId);
                $('.singleAndCustomReceivingAmount_'+invoiceId).val(payingAmountNow);
                if(payingAmountNow == 0)
                {
                    $(this).prop('checked', false).change();
                    $(this).val('').change();
                }else{
                    $(this).prop("checked", true).change();
                    $(this).val(invoiceId).change();
                }
            }
            
            var invoiceIds = [];
            $('input.checkSingleReceiveIvoiceDue[type=checkbox]').each(function () {
                if(this.checked){
                    var receivingVal = $(this).val();
                    invoiceIds.push(receivingVal);
                }
            });
            if(invoiceIds.length <= 0)
            {
                $('.checkAllReceiveIvoiceDue').prop('checked', false).change();
            }
            singleInvoiceWiseDueAmount(invoiceId);
        }
        else{
            $('.checkAllReceiveIvoiceDue').prop('checked', false).change();
            $('.checkSingleReceiveIvoiceDue').prop('checked', false).change();
            $('.singleAndCustomReceivingAmount').val(0);
            $('.checkSingleReceiveIvoiceDue').val('');
        }
        submitButtonEnableDisabled();
    });
    //check single order list

    function checkAndUncheckItemDuePayingAmount(invoiceId)
    {
        var customerGivenAmount = parseFloat(nanCheck($('.invoiceTotalPayingAmount').val()));

        var usedAmountWithCurrentPressingAmount = 0;
        $(".singleAndCustomReceivingAmount").each(function ()
        {
            usedAmountWithCurrentPressingAmount += parseFloat(nanCheck($(this).val())) || 0;
        });
        var currentPressingAmount = parseFloat(nanCheck($('.singleAndCustomReceivingAmount_'+invoiceId).val()));
        var totalUsedAmount = usedAmountWithCurrentPressingAmount - currentPressingAmount;
         
        var remainingAmount = 0;
        if(customerGivenAmount == totalUsedAmount){
            remainingAmount = 0;
        }
        else if(customerGivenAmount > totalUsedAmount){
            remainingAmount = customerGivenAmount - totalUsedAmount;
        }
        else if(customerGivenAmount < totalUsedAmount){
            remainingAmount = 0;
        }
        
        var currentDueReceivingAmount = parseFloat(nanCheck($('.singleAndCustomReceivingAmount_'+invoiceId).val()))|| 0;
        var currentInvoiceDueTotalAmount = parseFloat(nanCheck($('.singleInvoiceDueAmount_'+invoiceId).val()));

        var pressingLimitAmount = 0;
        if(currentInvoiceDueTotalAmount == currentDueReceivingAmount){
            pressingLimitAmount = currentInvoiceDueTotalAmount;
        }
        else if(currentInvoiceDueTotalAmount > currentDueReceivingAmount){
            pressingLimitAmount = currentInvoiceDueTotalAmount;
        }
        else if(currentInvoiceDueTotalAmount < currentDueReceivingAmount){
            pressingLimitAmount = currentInvoiceDueTotalAmount;
        }

        var lastLimitOfPressingAmount = 0; 
        if(remainingAmount ==  pressingLimitAmount){
            lastLimitOfPressingAmount = pressingLimitAmount; 
        } 
        else if(remainingAmount >  pressingLimitAmount){
            lastLimitOfPressingAmount = pressingLimitAmount; 
        }
        else if(remainingAmount < pressingLimitAmount){
            lastLimitOfPressingAmount = remainingAmount; 
        }
        return lastLimitOfPressingAmount;
    }


    //current invoice due after payment : by 1 parameter
    function singleInvoiceWiseDueAmount(invoiceId){
        var payingAmount =  $('.singleAndCustomReceivingAmount_'+invoiceId).val();
        var dueAmount =  $('.singleInvoiceDueAmount_'+invoiceId).val();
        var totalDue = 0;
        if(dueAmount == payingAmount){
            totalDue = 0;
        }
        else if(dueAmount > payingAmount){
            totalDue = dueAmount - payingAmount;
        }
        else if(dueAmount < payingAmount){
            totalDue = dueAmount - payingAmount;
        }
        $('.currentSingleDueAmount_'+invoiceId).text(totalDue.toFixed(2));
        
        setTotalCurrentDueAmount();
    }
    //current invoice due after payment : by 1 parameter

    //current total invoice wise total due
    function currentTotalInvoiceWiseDue(){
        var sumOfAllInvoiceTotalDueAmount = 0;
        $(".currentSingleDueAmount").each(function ()
        {
            sumOfAllInvoiceTotalDueAmount += parseFloat(nanCheck($(this).text())) || 0;
        });
        return sumOfAllInvoiceTotalDueAmount;
    }

    //default total invoice wise due
    function defaultTotalInvoiceWiseDue(){
        var sumOfAllInvoiceTotalDueAmount = 0;
        $(".singleInvoiceDueAmount").each(function ()
        {
            var invoiceId = $(this).data('id');
            var invoiceDueAmount = parseFloat(nanCheck($(this).val())) || 0;
            sumOfAllInvoiceTotalDueAmount += invoiceDueAmount;
            $('.currentSingleDueAmount_'+invoiceId).text(invoiceDueAmount.toFixed(2));
        });
        $('.totalCurrentDueAmountAsText').text(sumOfAllInvoiceTotalDueAmount.toFixed(2));
        $('.totalCurrentDueAmountAsValue').val(sumOfAllInvoiceTotalDueAmount.toFixed(2));
        setTotalPayingAndRemainingDueAmount();
    }

    //set total current due amount
    function setTotalCurrentDueAmount(){
        var sumOfAllInvoiceTotalDueAmount = currentTotalInvoiceWiseDue();
        $('.totalCurrentDueAmountAsText').text(sumOfAllInvoiceTotalDueAmount.toFixed(2));
        $('.totalCurrentDueAmountAsValue').val(sumOfAllInvoiceTotalDueAmount.toFixed(2));

        //===================================
        var totalSumOfAllSinglePayingAmounts = sumOfAllSinglePayingAmount();
        //var totalSumOfAllDueAmount = sumOfAllDueAmount();
        var totalSumOfAllCurrentDueAmount = currentTotalInvoiceWiseDue();
        //var totalPayingAmountByCustomer = totalSumOfAllDueAmount - totalSumOfAllCurrentDueAmount;
        $('.invoiceTotalPayingAmountAsDisplay').val(totalSumOfAllSinglePayingAmounts.toFixed(2));
        $('.overallTotalDiscountAmount').val(totalSumOfAllCurrentDueAmount.toFixed(2));
        //===================================
    }
   

    //set total paying amount and total remaining due amount set here
    function setTotalPayingAndRemainingDueAmount(){
        var totalPayingAmount = sumOfAllSinglePayingAmount();
        $('.invoiceTotalPayingAmount').val(totalPayingAmount.toFixed(2));
        
        var dueAmount =  sumOfAllDueAmount();
        var totalDueAmount = dueAmount - totalPayingAmount; 
        $('.overallTotalDiscountAmount').val(totalDueAmount); 
    }
    //set total paying amount and total remaining due amount set here
 
    //sum of all single paying amount
    function sumOfAllSinglePayingAmount(){
        var usedAmountWithCurrentPressingAmount = 0;
        $(".singleAndCustomReceivingAmount").each(function ()
        {
            usedAmountWithCurrentPressingAmount += parseFloat(nanCheck($(this).val())) || 0;
        });

        $('.sumOfAlltotalPayingAmountAsText').text(usedAmountWithCurrentPressingAmount.toFixed(2));
        
        return usedAmountWithCurrentPressingAmount;
    }

    //sum of all due amount
    function sumOfAllDueAmount(){
        var totalDueAmount = 0;
        $(".singleInvoiceDueAmount").each(function (){
            totalDueAmount += parseFloat(nanCheck($(this).val())) || 0;
        });
        return totalDueAmount;
    }

    //submit button enable disabled
    function submitButtonEnableDisabled(){
        if(sumOfAllSinglePayingAmount() > 0){
            submitButtonEnable();
        }else{
            submitButtonDisabled();
        }
    }

    //------------------------------------------------------------
    // overall discount section
    //------------------------------------------------------------
        $(document).on('change','.overallOrRemainingType',function(){
            var overallOrRemainingType = $('.overallOrRemainingType option:selected').val();
            if(overallOrRemainingType == 1){ //remaining due
                $('.nextPaymentDate').removeAttr('disabled');

                $('.checkAllOverallDiscount').attr('disabled',true);
                $('.checkSingleOverallDiscount').attr('disabled',true);
                $('.overallSingleInvoiceLessAmount').attr('disabled',true);
                $('.overallSingleInvoiceLessAmount').val(0);
            }else{ //overall discount
                $('.nextPaymentDate').attr('disabled',true);
                $('.nextPaymentDate').val('');

                $('.overallSingleInvoiceLessAmount').removeAttr('disabled');
                $('.checkSingleOverallDiscount').removeAttr('disabled');
                $('.checkAllOverallDiscount').removeAttr('disabled');
            }
        });
        
        //all chenged check and uncheck option
        function overallAllChangedCheckAndUncheckOption(){
            $(".checkSingleReceiveIvoiceDue").each(function (){
                var invoiceId = $(this).attr('id');
                //$(this).val(invoiceId).change();
                var payingDueAmount = checkAndUncheckItemDuePayingAmount(invoiceId);
                
                $('.singleAndCustomReceivingAmount_'+invoiceId).val(payingDueAmount);

                if(payingDueAmount == 0)
                {
                    $(this).prop('checked', false).change();
                    $(this).val('').change();
                }else{
                    $(this).prop("checked", true).change();
                    $(this).val(invoiceId).change();
                }
                singleInvoiceWiseDueAmount(invoiceId);
            });
        }

        //single and Custom receiveing amount
        $(document).on('keyup','.overallSingleInvoiceLessAmount',function(){
            var invoiceId = $(this).data('id');
            var pressingVal = $(this).val();
            var finalPayingAmount = changeToCheckOrUncheckOptionSinglePaymentProcessing(invoiceId);
            $('.singleAndCustomReceivingAmount_'+invoiceId).val(finalPayingAmount);
            if(finalPayingAmount == 0){
                $('.checkSingleReceiveIvoiceDue_'+invoiceId).prop('checked', false).change();
                $('.checkSingleReceiveIvoiceDue_'+invoiceId).val('').change();
            }else{
                $('.checkSingleReceiveIvoiceDue_'+invoiceId).prop("checked", true).change();
                $('.checkSingleReceiveIvoiceDue_'+invoiceId).val(invoiceId).change();
            }

            singleInvoiceWiseDueAmount(invoiceId);

            submitButtonEnableDisabled();
        });

        //change to check or uncheck option single payment processing
        function changeToOverallCheckOrUncheckOptionSinglePaymentProcessing(invoiceId)
        {
            var customerGivenAmount = parseFloat(nanCheck($('.invoiceTotalPayingAmount').val()));

            var usedAmountWithCurrentPressingAmount = 0;
            $(".singleAndCustomReceivingAmount").each(function ()
            {
                usedAmountWithCurrentPressingAmount += parseFloat(nanCheck($(this).val())) || 0;
            });
            var currentPressingAmount = parseFloat(nanCheck($('.singleAndCustomReceivingAmount_'+invoiceId).val()));
            var totalUsedAmount = usedAmountWithCurrentPressingAmount - currentPressingAmount;
            
            var remainingAmount = 0;
            if(customerGivenAmount == totalUsedAmount){
                remainingAmount = 0;
            }
            else if(customerGivenAmount > totalUsedAmount){
                remainingAmount = customerGivenAmount - totalUsedAmount;
            }
            else if(customerGivenAmount < totalUsedAmount){
                remainingAmount = 0;
            }
            
            var currentPressingAmountRightNow = parseFloat(nanCheck($('.singleAndCustomReceivingAmount_'+invoiceId).val()))|| 0;
            var currentInvoiceDueTotalAmount = parseFloat(nanCheck($('.singleInvoiceDueAmount_'+invoiceId).val()));

            var pressingLimitAmount = 0;
            if(currentInvoiceDueTotalAmount == currentPressingAmountRightNow){
                pressingLimitAmount = currentInvoiceDueTotalAmount;
            }
            else if(currentInvoiceDueTotalAmount > currentPressingAmountRightNow){
                pressingLimitAmount = currentPressingAmountRightNow;
            }
            else if(currentInvoiceDueTotalAmount < currentPressingAmountRightNow){
                pressingLimitAmount = currentInvoiceDueTotalAmount;
            }
        
            var lastLimitOfPressingAmount = 0; 
            if(remainingAmount ==  pressingLimitAmount){
                lastLimitOfPressingAmount = pressingLimitAmount; 
            } 
            else if(remainingAmount >  pressingLimitAmount){
                lastLimitOfPressingAmount = pressingLimitAmount; 
            }
            else if(remainingAmount < pressingLimitAmount){
                lastLimitOfPressingAmount = remainingAmount; 
            }
            return lastLimitOfPressingAmount;
        }


        // checked all order list 
        $(document).on('click','.checkAllOverallDiscount',function()
        {
            var invoiceTotalPayingAmount = $('.invoiceTotalPayingAmount').val();
            if(invoiceTotalPayingAmount > 0){
                if (this.checked == false)
                {   
                    $('.checkSingleReceiveIvoiceDue').prop('checked', false).change();
                    $(".checkSingleReceiveIvoiceDue").each(function ()
                    {
                        var invoiceId = $(this).attr('id');
                        $(this).val('').change();
                        $('.singleAndCustomReceivingAmount_'+invoiceId).val(0);

                        singleInvoiceWiseDueAmount(invoiceId);

                    });
                }
                else
                {
                    $('.checkSingleReceiveIvoiceDue').prop("checked", true).change();
                    allChangedCheckAndUncheckOption();
                }
            }
            submitButtonEnableDisabled();
        });
        // checked all order list 

        
        //check single order list
        $(document).on('click','.checkSingleOverallDiscount',function(){

            var invoiceTotalPayingAmount = $('.invoiceTotalPayingAmount').val() || 0;
            if(invoiceTotalPayingAmount > 0){
                var $db = $('input[type=checkbox]');
                if($db.filter(':checked').length <= 0)
                {
                    $('.checkAllReceiveIvoiceDue').prop('checked', false).change();
                    $('.singleAndCustomReceivingAmount').val(0);
                }

                var invoiceId = $(this).attr('id');
                if (this.checked == false)
                {
                    $(this).prop('checked', false).change();
                    $(this).val('').change();
                    $('.singleAndCustomReceivingAmount_'+invoiceId).val(0);
                }else{
                    var payingAmountNow = checkAndUncheckItemDuePayingAmount(invoiceId);
                    $('.singleAndCustomReceivingAmount_'+invoiceId).val(payingAmountNow);
                    if(payingAmountNow == 0)
                    {
                        $(this).prop('checked', false).change();
                        $(this).val('').change();
                    }else{
                        $(this).prop("checked", true).change();
                        $(this).val(invoiceId).change();
                    }
                }
                
                var invoiceIds = [];
                $('input.checkSingleReceiveIvoiceDue[type=checkbox]').each(function () {
                    if(this.checked){
                        var receivingVal = $(this).val();
                        invoiceIds.push(receivingVal);
                    }
                });
                if(invoiceIds.length <= 0)
                {
                    $('.checkAllReceiveIvoiceDue').prop('checked', false).change();
                }
                singleInvoiceWiseDueAmount(invoiceId);
            }
            else{
                $('.checkAllReceiveIvoiceDue').prop('checked', false).change();
                $('.checkSingleReceiveIvoiceDue').prop('checked', false).change();
                $('.singleAndCustomReceivingAmount').val(0);
                $('.checkSingleReceiveIvoiceDue').val('');
            }
            submitButtonEnableDisabled();
        });
        //check single order list

        function overallCheckAndUncheckItemDuePayingAmount(invoiceId)
        {
            var customerGivenAmount = parseFloat(nanCheck($('.invoiceTotalPayingAmount').val()));

            var usedAmountWithCurrentPressingAmount = 0;
            $(".singleAndCustomReceivingAmount").each(function ()
            {
                usedAmountWithCurrentPressingAmount += parseFloat(nanCheck($(this).val())) || 0;
            });
            var currentPressingAmount = parseFloat(nanCheck($('.singleAndCustomReceivingAmount_'+invoiceId).val()));
            var totalUsedAmount = usedAmountWithCurrentPressingAmount - currentPressingAmount;
            
            var remainingAmount = 0;
            if(customerGivenAmount == totalUsedAmount){
                remainingAmount = 0;
            }
            else if(customerGivenAmount > totalUsedAmount){
                remainingAmount = customerGivenAmount - totalUsedAmount;
            }
            else if(customerGivenAmount < totalUsedAmount){
                remainingAmount = 0;
            }
            
            var currentDueReceivingAmount = parseFloat(nanCheck($('.singleAndCustomReceivingAmount_'+invoiceId).val()))|| 0;
            var currentInvoiceDueTotalAmount = parseFloat(nanCheck($('.singleInvoiceDueAmount_'+invoiceId).val()));

            var pressingLimitAmount = 0;
            if(currentInvoiceDueTotalAmount == currentDueReceivingAmount){
                pressingLimitAmount = currentInvoiceDueTotalAmount;
            }
            else if(currentInvoiceDueTotalAmount > currentDueReceivingAmount){
                pressingLimitAmount = currentInvoiceDueTotalAmount;
            }
            else if(currentInvoiceDueTotalAmount < currentDueReceivingAmount){
                pressingLimitAmount = currentInvoiceDueTotalAmount;
            }

            var lastLimitOfPressingAmount = 0; 
            if(remainingAmount ==  pressingLimitAmount){
                lastLimitOfPressingAmount = pressingLimitAmount; 
            } 
            else if(remainingAmount >  pressingLimitAmount){
                lastLimitOfPressingAmount = pressingLimitAmount; 
            }
            else if(remainingAmount < pressingLimitAmount){
                lastLimitOfPressingAmount = remainingAmount; 
            }
            return lastLimitOfPressingAmount;
        }
    //------------------------------------------------------------
    // overall discount section
    //------------------------------------------------------------


    jQuery(document).on("submit",'.storeReceieAllInvoiceDueData',function(e){
        e.preventDefault();
        submitButtonDisabled();
        var form = jQuery(this);
        var url = form.attr("action");
        var type = form.attr("method");
        var data = form.serialize();
        jQuery('.color-red').text('');
        jQuery.ajax({
            url: url,
            data: data,
            type: type,
            datatype:"JSON",
            beforeSend:function(){
                jQuery('.submit_loader').fadeIn();
                jQuery('.processing').fadeIn();
                jQuery('.submit_processing_gif').fadeIn();
            },
            success: function(response){
                if(response.status == 'errors')
                {   
                    printErrorMsg(response.error);
                }
                else if(response.status == true)
                {
                    jQuery.notify(response.message, response.type);
                    form[0].reset();
                    customerList();
                    setTimeout(function(){
                        jQuery('#renderReceiveAllInvoiceDueModal').modal('hide');//hide modal
                    },500);
                }
            },
            complete:function(){
                jQuery('.submit_processing_gif').fadeOut();
                jQuery('.processing').fadeOut();
                jQuery('.submit_loader').fadeOut();
            },
        });
        //end ajax

        function printErrorMsg(msg) {
            jQuery('.color-red').css({'color':'red'});
            jQuery.each(msg, function(key, value ) {
                jQuery('.'+key+'_err').text(value);
            });
        }
    });

    //submit button disabled
    function submitButtonDisabled()
    {
        jQuery('.submitButton').attr('disabled',true); 
    }
    //submit button enabled
    function submitButtonEnable()
    {
        jQuery('.submitButton').removeAttr('disabled'); 
    }
    //enable disabled submit button

    //----------------------------------------------------------------------------------
    //----------------------------------------------------------------------------------
    

    function nanCheck(val){
        var value = 0;
        if(isNaN(val)) {
            value = 0;
        }else{
            value = val;
        }
        return value;
    }

    /*
    |--------------------------------------------------------
    | input field protected .. only for numeric
    |--------------------------------------------------------
    */
    jQuery(document).on('keyup keypress','.inputFieldValidatedOnlyNumeric',function(e){
        if (String.fromCharCode(e.keyCode).match(/[^0-9\.]/g)) return false;
    });

