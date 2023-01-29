$(document).ready(function () {
    table = dataTable();

    loadTransactions();
    getTransactionInfo();

    addOnFunction();

    $("#trans-time-out").on('dp.change', function(){
        var timeIn = $("#trans-time-in").val();
        var timeOut = $("#trans-time-out").val();
        if(timeIn != '' && timeOut != ''){
            var start = moment(timeIn, "MM/DD/YYYY HH:mm");
            var end = moment(timeOut, "MM/DD/YYYY HH:mm");
            var duration = moment.duration(end.diff(start));
            var minutes = duration.asMinutes();
            var hours = Math.floor(minutes / 60);
            var remainingMinutes = minutes % 60;
            $("#trans-total-time").val(hours + " hours and " + remainingMinutes + " minutes");
        }
    });
    $("#transaction-modal").on('hidden.bs.modal', function(){
        $("#trans-time-out").datetimepicker('destroy');
        $(".invalid-feedback").hide();

    });
    $("#trans-amount-paid").on('keyup', function(){
        if($(this).val() > parseInt($(this).attr('max'))){
            $(this).val($(this).attr('max'));
        }
    });
    $("#btn-confirm-payment").on('click', function(){
        $.post('../../php/handlers/transactionHandler.php', {'confirm-id': $("#trans-id").val()}, function(data){
            console.log(data);
            $("#transaction-modal").modal('hide');
            feedbackModal(data, "Transaction success", "Transaction failed", 0);
            initialTransaction = 0;
            loadTransactions()
        })
    });
});

initialTransaction = 0;
function loadTransactions(){

    $.post('../../php/handlers/transactionHandler.php',
    {
        'init-transaction': initialTransaction
    },function(data){
        table.clear();

        jsondata = JSON.parse(data);
        jsondata.forEach(value => {
            table.row.add([
                `<td>
                `+value.id+`
                </td>`,
                `<td>
                    `+value.guest_name+`
                </td>`,
                `<td>
                    `+value.date+`
                </td>`,
                `<td>
                    <span class="badge rounded-pill `+value.isPaid+`">`+value.isPaid+`</span>
                </td>`
            ]);
        });

        table.draw();
        
    });
}
function dataTable(){
    return $('#transaction-table').DataTable({
        "columns": [
            { "width": "15%" },
            { "width": "40%" },
            { "width": "25%" },
            { "width": "20%" }
          ],
        order: [[0, 'desc']],
        'scrollY': 400,
        "scrollCollapse": true,
        "paging": false
    });
}
function getTransactionInfo(){
    addonid = 0;

    $(document).on('click','#transaction-table tbody tr',function(e){
        totalQuantity = 0;
        totalFee = 0;
        row_object  = table.row(this).data()[0];
        transact_id = row_object.replace(/[^0-9\.]+/g, "");
        $.post('../../php/handlers/transactionHandler.php',
        {
            'open-transaction-id': transact_id
        },function(data){
            console.log(data);
            jsondata = JSON.parse(data);
            totalFee = totalFee + parseInt(jsondata.transact_info.package_price);
            $("#trans-package-name").html(jsondata.transact_info.package_name);
            $("#trans-name").val(jsondata.transact_info.guest_name);
            $("#trans-package-price").val(jsondata.transact_info.package_price);
            $('#trans-id').val(transact_id);
            $("#trans-package-image").attr('src', "../../php/handlers/package/"+ jsondata.transact_info.image +".jpg");
            $('#trans-contact-number').val(jsondata.transact_info.contact);
            $("#trans-downpayment").val(jsondata.transact_info.downpayment);
            $("#trans-booked").val(jsondata.transact_info.date);
            $("#trans-time-in").val(moment(jsondata.transact_info.time_in, "MMM DD, YYYY | HH:mm A").format("MM/DD/YYYY hh:mm A"));
            $("#trans-time-out").val(moment(jsondata.transact_info.time_out, "MMM DD, YYYY | HH:mm A").format("MM/DD/YYYY hh:mm A"));
            $("#trans-staff-name").val(jsondata.transact_info.staff_name);
            console.log(jsondata.transact_info.isPaid);
            if(jsondata.transact_info.status == '3'){
                $("#btn-confirm-payment").show();
                $("#btn-trans-save").hide();
            }else{
                $("#btn-confirm-payment").hide();
                $("#btn-trans-save").show();

            }
            if(jsondata.transact_info.receipt !== null && jsondata.transact_info.id_file !== null ){
                $("#online-receipts").show();
                $("#disp-receipt").fileinput("destroy");
                $("#disp-receipt").fileinput({
                    initialPreview: [
                        "<img src='../../files/"+transact_id+"/"+jsondata.transact_info.receipt+"' class='file-preview-image'>",
                        "<img src='../../files/"+transact_id+"/"+jsondata.transact_info.id_file+"' class='file-preview-image'>",
                    ],
                    showRemove: false,
                    showUpload: false,
                    showBrowse: false,
                    showCancel: false,
                });
            }else{
                $("#online-receipts").hide();

            }
           
            if(jsondata.transact_info.status === '1'){
                $('#trans-is-package-paid').prop('checked', true);
            }else{
                $('#trans-is-package-paid').prop('checked', false);
            }
            $("#trans-time-out").datetimepicker( {
                minDate: moment(jsondata.transact_info.time_out, "MMM DD, YYYY | HH:mm A").format("MM/DD/YYYY hh:mm A"),
                sideBySide:true,
                useCurrent:false,
                ignoreReadonly:true,
            });
      

            for(x = 0; x < Object.keys(jsondata.addons_info).length; x++){
                totalQuantity = totalQuantity + parseInt(jsondata.addons_info[x].quantity);
                totalFee = totalFee + parseInt(jsondata.addons_info[x].fee);
                $('#trans-addon-tbody').prepend(`
                <tr id="add-on-`+jsondata.addons_info[x].id+`">
                    <td>
                        <select name="addons[]" class="form-select addons-select" row-target="`+jsondata.addons_info[x].addon_id+`" id="trans-select-add-on-`+jsondata.addons_info[x].addon_id+`" aria-label="Default select example" name="addon[]" >
                        <option trueprice="`+jsondata.addons_info[x].price+`"quantity="`+jsondata.addons_info[x].inventory_quantity+`"value="`+jsondata.addons_info[x].addon_id+`"selected>`+jsondata.addons_info[x].item_desc+`</option>
                        </select>
                    </td>
                    <td>
                        <input name="quantity[]" min=0 type="number" class="form-control quantity" id="trans-quantity-`+jsondata.addons_info[x].addon_id+`" value="`+jsondata.addons_info[x].quantity+`" row-target="`+jsondata.addons_info[x].addon_id+`">
                    </td>
                    <td>
                        <input min=0 type="number" class="form-control trans-fee" id="trans-inp-fee-`+jsondata.addons_info[x].addon_id+`" readonly value="`+jsondata.addons_info[x].fee+`" row-target="`+jsondata.addons_info[x].addon_id+`">
                    </td>
                    <td>
                        <a class="btn btn-danger remove-add-on" row-target="`+jsondata.addons_info[x].id+`"><i class="bi bi-x"></i></a>
                    </td>
                </tr>
                `);
                $('.addons-select').each(function() {
                    selectbox = $(this);
                    let options = $(this).find("option");
                    options.each(function() {
                        Object.keys(jsondata.all_addons).forEach(element => {
                            if($(this).val() != jsondata.all_addons[element].id){
                                console.log($(this));
                                selectbox.prepend(`<option quantity="`+jsondata.all_addons[element].quantity+`"value="`+jsondata.all_addons[element].id+`" trueprice="`+jsondata.all_addons[element].price+`">`+jsondata.all_addons[element].item_desc+`</option>`)
                            }
                        });
                    });
                  });
               
            addonid = jsondata.addons_info[x].id;
            var timeIn = $("#trans-time-in").val();
            var timeOut = $("#trans-time-out").val();
    
            if(timeIn != '' && timeOut != ''){
                var start = moment(timeIn, "MM/DD/YYYY hh:mm A");
                var end = moment(timeOut, "MM/DD/YYYY hh:mm A");
                var duration = moment.duration(end.diff(start));
                var minutes = duration.asMinutes();
                var hours = Math.floor(minutes / 60);
                var remainingMinutes = minutes % 60;
                $("#trans-total-time").val(hours + " hours and " + remainingMinutes + " minutes");
            }
        }
       

        $("#trans-total-quantity").val(totalQuantity);
        $("#trans-total-fee").val(totalFee - $("#trans-downpayment").val());
        $("#trans-amount-paid").attr('max', totalFee - $("#trans-downpayment").val());
        }).then(function(){
            $('#transaction-modal').modal('show');
            removeAddOn();
        });
    });
    $("#btn-trans-save").on('click',function(){
        form = $("#trans-package-form").serializeArray();
        timeOut = $("#trans-time-out").val();

        var date = new Date(timeOut);

        // get the year, month, and day and pad with leading zeroes
        var year = date.getFullYear();
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var day = ("0" + date.getDate()).slice(-2);

        // get the hours, minutes, and seconds and pad with leading zeroes
        var hours = ("0" + date.getHours()).slice(-2);
        var minutes = ("0" + date.getMinutes()).slice(-2);
        var seconds = ("0" + date.getSeconds()).slice(-2);

        // concatenate the date and time parts to create the SQL datetime string
        var sqlDatetime = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;


        form.push({name: 'trans-time-out' ,value: sqlDatetime});
        if($("#trans-is-package-paid").prop('checked') == false){
            $.post('../../php/handlers/transactionHandler.php', form ,function(data){
                if(data == '1'){
                    $("#transaction-modal").modal('hide');
                    feedbackModal(data, "Transaction success", "Transaction failed", 0);
                    initialTransaction = 0;
                    loadTransactions()
                }else{
                    jsonresponse = JSON.parse(data);
                    jsonresponse.forEach(value => {
                        $("#trans-amount-paid ~.invalid-feedback").html("Field cannot be empty!");
                        $("#"+value.error+' ~.invalid-feedback').show();
                    });
                }
    
            });
        }else{
            if(parseInt($("#trans-amount-paid").val()) >= parseInt($("#trans-total-fee").val())){
                $.post('../../php/handlers/transactionHandler.php', form ,function(data){
                    if(data == '1'){
                        $("#transaction-modal").modal('hide');
                        feedbackModal(data, "Transaction success", "Transaction failed", 0);
                        initialTransaction = 0;
                        loadTransactions()
                    }else{
                        jsonresponse = JSON.parse(data);
                        jsonresponse.forEach(value => {
                            $("#trans-amount-paid ~.invalid-feedback").html("Field cannot be empty!");
                            $("#"+value.error+' ~.invalid-feedback').show();
                        });
                    }
        
                });
            }else{
                console.log('asd');
                $("#trans-amount-paid ~.invalid-feedback").html("Cannot be lower than total fee!")
                $("#trans-amount-paid ~.invalid-feedback").show();
                $("#trans-is-package-paid ~.invalid-feedback").show();
                
            }
        }
     
      
    });
    $("#trans-is-package-paid").change(function(){
        if($('#trans-is-package-paid').prop('checked') === true){
            $("#trans-amount-paid").show();
        }else{
            $("#trans-amount-paid").hide();
            $("#trans-amount-paid ~.invalid-feedback").hide();
            $("#trans-is-package-paid ~.invalid-feedback").hide();

        }
    });
    $("#transaction-modal").on('hidden.bs.modal', function(){
        $('#trans-addon-tbody').empty();
    });
}

function addOnFunction(){
    addOns = 0;
    $('.remove-add-on').off();
    $('#trans-package-form .fee').off();
    $('#trans-package-form .quantity').off();
    $("#trans-add-addons").on('click', function(){
        addOns++;
        $.get('../../php/handlers/getAddOns.php',function(data){
            jsondata = JSON.parse(data);
            $('#trans-addon-tbody').append(`
            <tr id="add-on-new-`+addOns+`">
                <td>
                    <select class="form-select addons-select" row-target="new-`+addOns+`" id="trans-select-add-on-new-`+addOns+`" aria-label="Default select example" name="addons[]" >
                    <option disabled selected>Select add on</option>

                    </select>
                </td>
                <td>
                    <input  min=0 type="number" class="form-control quantity" row-target="new-`+addOns+`" id="trans-quantity-new-`+addOns+`" value="0">
                </td>
                <td>
                    <input min=0 type="number" class="form-control trans-fee" id="trans-inp-fee-new-`+addOns+`" readonly value="">
                </td>
                <td>
                    <a class="btn btn-danger remove-add-on" row-target="new-`+addOns+`"><i class="bi bi-x"></i></a>
                </td>
            </tr>
            `);
            jsondata.forEach(value => {
                if(value.is_available === 'Available'){
                    $('#trans-select-add-on-new-'+addOns).append(`<option quantity="`+value.quantity+`"value="`+value.id+`" trueprice="`+value.price+`">`+value.item_desc+`</option>`);
                }
            });
            removeAddOn();

        });
    });

    $('#trans-package-form .fee').keyup(function(){
        totalFee = 0;
        
        setInputFilter(this, function(value) {
            return /^-?\d+\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
        }, "Only digits and '.' are allowed and input cannot be empty");

        for(x = 0 ; x< $('#trans-package-form .fee').length; x++){
            totalFee = totalFee + parseInt($('#trans-package-form .fee')[x].value);
        }
        $('#disp-total-fee').val(totalFee);
    });
    $('#trans-package-form .quantity').keyup(function(){
        totalQuantity = 0;

        setInputFilter(this, function(value) {
            return /^-?\d+\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
        }, "Only digits and '.' are allowed and input cannot be empty");

        for(x = 0 ; x< $('#trans-package-form .quantity').length; x++){
            totalQuantity = totalQuantity + parseInt($('#trans-package-form .quantity')[x].value);
        }
        $('#disp-total-quantity').val(totalQuantity);
    });
}

function feedbackModal(status, successMessage, failMessage, reload){
    if(status ==='1'){
        $("#success_tic").modal('show');
        $("#response-message").html(successMessage);
    }else{
        $("#fail_tic").modal('show');
        $("#fail-response-message").html(failMessage);
    }
    setTimeout(function(){
        $("#success_tic").modal('hide');
        $("#fail_tic").modal('hide');
    }, 1500);
    $("#fail_tic").modal('hide');
    if(reload === 1){
        setTimeout(function(){
            location.reload();
        }, 1500);
    }
 
}

function removeAddOn(){
    $(".remove-add-on").off();
    $(".remove-add-on").on('click', function(){
        $("#add-on-"+$(this).attr('row-target')).remove();
    });

    $(".addons-select").off();
    $(".addons-select").on('change', function(){
        let selectbox = $(this);
        let selectedOptions = $("#"+$(this).attr('id')+" option:selected");
        let rowTarget = $(this).attr('row-target');
        $("#trans-quantity-"+rowTarget).attr('name', 'quantity[]');
        $("#trans-inp-fee-"+rowTarget).val($("#trans-quantity-"+rowTarget).val() * selectedOptions.attr('trueprice'))
        checkTotal();
    });
    $(".quantity").off();
    $(".quantity").on('keyup', function(){
        let selectbox = $(this);
        let selectedOptions = $("#"+$(this).attr('id')+" option:selected");
        let rowTarget = $(this).attr('row-target');
        $("#trans-inp-fee-"+rowTarget).val($("#trans-select-add-on-"+rowTarget+" option:selected").attr('trueprice') * $(this).val());
        checkTotal();
    });

}
function checkTotal(){
    total = 0;
    quantity = 0;
    $(".trans-fee").each(function(){
        total = total + parseInt($($(this)).val());
    });
    $(".quantity").each(function(){
        quantity = quantity + parseInt($($(this)).val());
    });
    $("#trans-total-fee").val(total - parseInt($('#trans-downpayment').val()));
    $("#trans-amount-paid").attr('max', total - parseInt($('#trans-downpayment').val()))
    $("#trans-total-quantity").val(quantity);

}