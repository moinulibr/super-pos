
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


    


    
    //-------------------------------------------------
    
    //receive loan amount modal
    $(document).on('click','.receiveAllInvoiceDuesModal',function(e){
        e.preventDefault();
        var url = $('.renderReceiveAllInvoiceDueModalRoute').val();
        var id = $(this).data('id');
        $.ajax({
            url:url,
            data:{id:id},
            success:function(response){
                $('#renderReceiveAllInvoiceDueModal').html(response.view).modal('show');//hide modal
                submitButtonDisabled();
            }
        });
    });

    $(document).on('keyup','.totalCustomerGivenAmount',function(){
        var customerGivenAmount =$('.totalCustomerGivenAmount').val();
        var totalsumOfAllSinglePayingAmounts = sumOfAllSinglePayingAmount();
        var totalSumOfAllDueAmount = sumOfAllDueAmount();
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
        submitButtonEnableDisabled();
    });

    function allChangedCheckAndUncheckOption(){
        $(".checkSingleReceiveIvoiceDue").each(function ()
        {
            var invoiceId = $(this).attr('id');
            //$(this).val(invoiceId).change();
            console.log('all top invoice :'+ invoiceId);
            var payingDueAmount = checkAndUncheckItemDuePayingAmount(invoiceId);
            console.log('all top single Value :'+ payingDueAmount);
            
            $('.singleAndCustomReceivingAmount_'+invoiceId).val(payingDueAmount);

            if(payingDueAmount == 0)
            {
                console.log('all top checked false 0');
                $(this).prop('checked', false).change();
                $(this).val('').change();
            }else{
                console.log('all top checked ture 1');
                $(this).prop("checked", true).change();
                $(this).val(invoiceId).change();
            }
        });
    }

    $(document).on('keyup','.singleAndCustomReceivingAmount',function(){
        var invoiceId = $(this).data('id');
        var pressingVal = $(this).val();
        var finalPayingAmount = changedCheckAndUncheckItemWhenPayingSingleAmountBySinglePressing(invoiceId);
        $('.singleAndCustomReceivingAmount_'+invoiceId).val(finalPayingAmount);
        if(finalPayingAmount == 0){
            $('.checkSingleReceiveIvoiceDue_'+invoiceId).prop('checked', false).change();
            $('.checkSingleReceiveIvoiceDue_'+invoiceId).val('').change();
        }else{
            $('.checkSingleReceiveIvoiceDue_'+invoiceId).prop("checked", true).change();
            $('.checkSingleReceiveIvoiceDue_'+invoiceId).val(invoiceId).change();
        }
        submitButtonEnableDisabled();
    });

    function changedCheckAndUncheckItemWhenPayingSingleAmountBySinglePressing(invoiceId)
    {
        var customerGivenAmount = parseFloat(nanCheck($('.totalCustomerGivenAmount').val()));

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
        var totalCustomerGivenAmount = $('.totalCustomerGivenAmount').val();
        if(totalCustomerGivenAmount > 0){
            if (this.checked == false)
            {   
                $('.checkSingleReceiveIvoiceDue').prop('checked', false).change();
                $(".checkSingleReceiveIvoiceDue").each(function ()
                {
                    var invoiceId = $(this).attr('id');
                    $(this).val('').change();
                    $('.singleAndCustomReceivingAmount_'+invoiceId).val(0);
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
    $(document).on('click','.checkSingleReceiveIvoiceDue',function()
    {
        var totalCustomerGivenAmount = $('.totalCustomerGivenAmount').val();
        if(totalCustomerGivenAmount > 0){
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
                console.log('top singel amount:- '+ payingAmountNow);
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
        }
        submitButtonEnableDisabled();
    });
    //check single order list

    function checkAndUncheckItemDuePayingAmount(invoiceId)
    {
        var customerGivenAmount = parseFloat(nanCheck($('.totalCustomerGivenAmount').val()));

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
        console.log('pressing amount1 '+ currentDueReceivingAmount);
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
        console.log('current invoice due '+ currentInvoiceDueTotalAmount);
        console.log('pressing limit amount '+ pressingLimitAmount);
       
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
        console.log('last limit amount '+ lastLimitOfPressingAmount);
        console.log('pressing amount2 '+ currentInvoiceDueTotalAmount);
        return lastLimitOfPressingAmount;
    }

    function sumOfAllSinglePayingAmount(){
        var usedAmountWithCurrentPressingAmount = 0;
        $(".singleAndCustomReceivingAmount").each(function ()
        {
            usedAmountWithCurrentPressingAmount += parseFloat(nanCheck($(this).val())) || 0;
        });
        return usedAmountWithCurrentPressingAmount;
    }

    function sumOfAllDueAmount(){
        var totalDueAmount = 0;
        $(".singleInvoiceDueAmount").each(function ()
        {
            totalDueAmount += parseFloat(nanCheck($(this).val())) || 0;
        });
        return totalDueAmount;
    }

    function submitButtonEnableDisabled(){
        if(sumOfAllSinglePayingAmount() > 0){
            submitButtonEnable();
        }else{
            submitButtonDisabled();
        }
    }


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

