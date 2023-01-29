$(document).ready(function () {
    generateAccommodationCard();
    // getUserData();
    addAccommodation();
    deleteAccommodation();
    addOnFunction();
    addOnClick();
    dateTimePicker();
    modalFunctions();
});
activeRoom = 0;
function dateTimePicker(){
    $('#inp-time-in').datetimepicker(
        {
            minDate: new Date(),
            sideBySide:true,
            ignoreReadonly:true,

        }
    );
    $('#inp-time-out').datetimepicker(
        {
            minDate: new Date(),

        sideBySide:true,
        useCurrent:false,
        ignoreReadonly:true,

        }
    );
    $('.inp-time').on('dp.change', function(){
        var timeIn = $("#inp-time-in").val();
        var timeOut = $("#inp-time-out").val();
        if(timeIn != '' && timeOut != ''){
            var start = moment(timeIn, "MM/DD/YYYY hh:mm A");
            var end = moment(timeOut, "MM/DD/YYYY hh:mm A");
            var duration = moment.duration(end.diff(start));
            var minutes = duration.asMinutes();
            var hours = Math.floor(minutes / 60);
            var remainingMinutes = minutes % 60;
            $("#total-hours").val(hours + " hours and " + remainingMinutes + " minutes");
        }
       
    });
}
function getUserData() {
    $.get('../../php/handlers/getUserData.php',
        function (data) {
            jsondata = JSON.parse(data);
            $('#user-name').html(jsondata.fname + ' ' + jsondata.lname);
            $('#user-role').html(jsondata.user_type);

        });
}

function generateAccommodationCard() {
    $.get("../../php/handlers/getAccommodationHandler.php",
        function (data) {
            jsondata = JSON.parse(data);
            if (jsondata.length > 0) {
                for (x = 0; x < jsondata.length; x++) {

                    unavailable = '';
                    if(jsondata[x].status === '1'){
                        room_status = 'available';
                    }else if(jsondata[x].status === '0'){
                        room_status = 'unavailable';
                        unavailable = 'disabled';
                    }
                    $('#accommodation-body').append(`
                    <div class="col-12 col-lg-4 mb-4 d-flex justify-content-center accommodation-card" id="card`+ jsondata[x].package_id + `">
                        <div class="card" style="width: 18rem;">
                            <img src="../../php/handlers/package/`+ jsondata[x].image +`.jpg" class="card-img-top room-img" alt="">
                            <div class="card-body d-flex flex-column justify-content-between ">
                                <div class="col-12">
                                    <h5 class="card-title card-package-no">`+ jsondata[x].package_name + `</h5>
                                    <h6 class="card-text card-package-price">Price: ₱`+ jsondata[x].price + `</h6>
                                    <p class="card-text card-package-description">`+ jsondata[x].description + `</p>
                                </div>
                                <div class="col-12 d-flex mt-2 justify-content-end buttons">
                                    <a type="button" class="btn btn-primary btn-book-accommodation ` +room_status+`" onClick="getPackage( `+ jsondata[x].package_id + `)" attrid="`+ jsondata[x].package_id + `" ` +unavailable+`>
                                        <i class="bi bi-book"></i>&nbsp;Get Package
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);
                    if(jsondata[x].access ==='admin'){
                        $('#card' + jsondata[x].package_id + ' .buttons').prepend(`
                        <button type="button" class="btn btn-primary me-2" id="btn-edit-accommodation" onClick="editAccommodation( `+ jsondata[x].package_id + `)"><i class="bi bi-pencil"></i></button>

                        `);
                    }
                }
            }
        });
}

function addAccommodation() {

    $('#btn-add-accommodation').on('click', function () {
        $('#package-name').val('');
        $('#package-price').val('');
        $('#description').val('');
        $('.package-name').html('');

        $('#accommodationModal').modal('toggle');
        $("#accommodation-save").hide();
        $("#accommodation-add").show();
        $("#accommodation-delete").hide();
    });

    empty = true;

    $("#accommodation-add").click(function () {
        for(x = 0; x < $(".needs-validation").length; x++){
            id = $('.needs-validation')[x].id;
            if($('#'+id).val() == null || $('#'+id).val() === '' || $('#'+id).val() === '$&nbsp;'){
                $('#'+id+ '+' +'.invalid').show();
            }else{
                $('#'+id+ '+' +'.invalid').hide();
            }

        }

        if(empty){
            file = $('#package-image-upload')[0].files[0];

            let formData = new FormData($('#accommodation-form')[0]);
            formData.append('file', file);
            $.ajax({
                url: '../../php/handlers/accommodationHandler.php',
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    $("#accommodationModal").modal("hide");
                    feedbackModal(data, "Package successfully added", "Action failed", 1);
                }
            });
        }
     
    });

}
function editAccommodation(room_id) {
    $('#accommodationModal').modal('toggle');
    $("#accommodation-save").show();
    $("#accommodation-add").hide();
    $("#accommodation-delete").show();
    activeRoom = room_id;
    $.post("../../php/handlers/accommodationHandler.php",
    {
        'disp_package_id': room_id
    }, function(data){
        var jsondata = JSON.parse(data);
        $('#package-name').val(jsondata.package_name);
        $('.package-name').html(jsondata.package_name);
        $('#package-price').val(jsondata.price);
        $('#description').val(jsondata.description);
        $('#room-status').val(jsondata.status);
        // $('#room-image-upload').val(jsondata.image); 
    });
    $("#accommodation-save").off();
    $("#accommodation-save").click(function(){
        file = $('#package-image-upload')[0].files[0];
        room_img_upload = $('#room-image-upload').val(jsondata.image);
        var formData = new FormData();
        formData.append('editPackageID', activeRoom),
        formData.append('editPackageName', $('#package-name').val());
        formData.append('editPackagePrice', $('#package-price').val());
        formData.append('editPackageDescription', $('#description').val());
        formData.append('editPackageStatus', $('#room-status').val());
        formData.append('file', file);
        // formData.append('editFile',room_img_upload);

        $.ajax({
            url: '../../php/handlers/accommodationHandler.php',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                // console.log(data);
                $("#accommodationModal").modal('hide');
                feedbackModal(data, "Edited package successfully", "Edit package failed", 1);
            }
        });
    });
}
function addOnClick(){
    addOns = 0;
    $('#add-addons').on('click',function(){
        addOns++;
        $.get('../../php/handlers/getAddOns.php',function(data){
            $('#addon-tbody').prepend(`
            <tr id="add-on-`+addOns+`">
                <td>
                    <select class="form-select" id="select-add-on-`+addOns+`" aria-label="Default select example" name="addon[]">
                    <option disabled selected>Select add on</option>
                    </select>
                </td>
                <td>
                    <div class="col-12">
                        <input readonly min=0 type="number" class="form-control quantity" arrval="`+addOns+`" id="quantity-`+addOns+`" value=1 name="quantity[]" required>
                    </div>
                </td>
                <td class="container">
                    <div class="row">
                        <div class="col-8 pe-0">
                            <input min=0 type="number" class="form-control fee" id="inp-fee-`+addOns+`" name="fee[]" required value=0 readonly>
                        </div>
                        <div class="col-4 pe-0">
                            <a class="btn btn-danger remove-add-on" attrval="`+addOns+`"><i class="bi bi-x"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
            `);
            
          
     
            jsondata = JSON.parse(data);
            console.log(jsondata);
            count = 0;
            jsondata.forEach(value => {
                if(value.is_available === 'Available'){
                    $('#select-add-on-'+addOns).append(`<option value="`+value.id+`" arrval="`+count+`">`+value.item_desc+`</option>`);
                    count++;
                }
            });
            if(count == 0){
                $('#select-add-on-'+addOns).append(`<option disabled>No items in inventory</option>`);
            }
            $("#select-add-on-"+addOns).on('change', function(){
                $("#quantity-"+$(this).attr('id').substring(14, 17)).attr('max', jsondata[$('#select-add-on-'+addOns+' option[value='+$(this).val()+']').attr('arrval')].quantity);
                $("#quantity-"+$(this).attr('id').substring(14, 17)).val(0);
                $("#inp-fee-"+$(this).attr('id').substring(14, 17)).val(jsondata[$('#select-add-on-'+addOns+' option[value='+$(this).val()+']').attr('arrval')].price * $("#quantity-"+addOns).val()).attr('trueval', jsondata[$('#select-add-on-'+addOns+' option[value='+$(this).val()+']').attr('arrval')].price);
                $("#quantity-"+$(this).attr('id').substring(14, 17)).prop('readonly', false);
                totalFee = 0;
                for(x = 0 ; x< $('#get-package-form .fee').length; x++){
                    totalFee = totalFee + parseInt($('#get-package-form .fee')[x].value);
                }
                $('#disp-total-fee').val(totalFee);
            });
           
          
        }).then(function(){
            addOnFunction();

            
        });
    });
    $("#is-package-paid").change(function(){
        if($('#is-package-paid').prop('checked') === true){
            $("#inp-downpayment").hide();
            $("#inp-amount-paid").show();
        }else{
            $("#inp-amount-paid").hide();
            $("#inp-downpayment").show();
        }
    });
    
}
function getPackage(package_id){
    if($('a[attrid="'+package_id+'"]').attr('disabled') !== 'disabled'){
        $('#get-package').off();
        $('#get_package_modal').modal('show');
        $.post('../../php/handlers/accommodationHandler.php', 
        {
            'disp_package_id': package_id
        }
        , function(data){
            console.log(data);
            jsondata = JSON.parse(data);
            $("#get-package-img").attr('src', '../handlers/package/'+jsondata.image+'.jpg')
            $('#get_package_name').html(jsondata.package_name);
            $('#disp-package-name').html(jsondata.package_name);
            $("#disp-package-price").html("₱"+jsondata.price);
            $('#disp-package-desc').html(jsondata.description);
            $('#inp-package-price').val(jsondata.price);
            $('#disp-total-fee').val(jsondata.price);
            $("#trans-amount-paid").attr('name', 'trans-amount-paid');
            $("#inp-contact-number").keyup(function(){
                setInputFilter(this, function(value) {
                    return /^-?\d+\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
                }, "Only digits and '.' are allowed and input cannot be empty");
            });

            $('#get-package').on('click',function(){
                $('.invalid-feedback').hide();
                timeIn = $("#inp-time-in").data("DateTimePicker").date();
                timeOut = $("#inp-time-out").data("DateTimePicker").date();

                form = $("#get-package-form").serializeArray();
                form.push({name:"get-package-id", value: package_id});

                try{
                    form.push({name:"inp-time-in", value: timeIn.format('YYYY-MM-DD') + " " + timeIn.format('HH:mm:ss')});
                    form.push({name:"inp-time-out", value: timeOut.format('YYYY-MM-DD') + " " + timeOut.format('HH:mm:ss')});
    
                }catch(e){

                }

                if($('#is-package-paid').prop('checked') === true){
                    form.push({name:"is-package-paid", value: 1});
                    form.push({name:"inp-amount-paid", value: $('#inp-amount-paid').val()});
                    form.push({name:"inp-downpayment", value: 0});
                }else{
                    form.push({name:"is-package-paid", value: 0});
                    form.push({name:"inp-amount-paid", value: 0});
                    form.push({name:"inp-downpayment", value: $('#inp-downpayment').val()});
                }
                console.log(form);
                $.post('../../php/handlers/accommodationHandler.php',
                form
                ,function(data){
                    console.log(data);
                    if(data == '1'){
                        $("#get_package_modal").modal('hide');
                        feedbackModal(data, "Transaction success", "Transaction failed", 0);
                    }else{
                        jsonresponse = JSON.parse(data);
                        jsonresponse.forEach(value => {
                            $("#"+value.error+' ~.invalid-feedback').show();
                        });
                    }
                });
            });
          
        });
    }

}

function deleteAccommodation(){
    $("#accommodation-delete").click(function(){
        console.log(activeRoom);
        $.post('../../php/handlers/accommodationHandler.php', {
            'delete-package-id': activeRoom
        }, (data)=>{
            $("#accommodationModal").modal('hide');
            feedbackModal(data, "Package deleted successfully", "Package delete failed", 1);
        });
    });
}
function modalFunctions(){
    $("#get_package_modal").on('hidden.bs.modal', function(){
        $('#get-package-form').get(0).reset();
        $("#addon-tbody").empty();
    });
}
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
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

function addOnFunction(){
    $('.remove-add-on').off();
    $('#get-package-form .fee').off();
    $('#get-package-form .quantity').off();
    $('.remove-add-on').click(function(){
        totalFee = 0;
        totalQuantity = 0;
        $('#add-on-'+this.attributes.attrval.value).remove();
        
        for(x = 0 ; x< $('#get-package-form .fee').length; x++){
            totalFee = totalFee + parseInt($('#get-package-form .fee')[x].value);
        }
        $('#disp-total-fee').val(totalFee);

        for(x = 0 ; x< $('#get-package-form .quantity').length; x++){
            totalQuantity = totalQuantity + parseInt($('#get-package-form .quantity')[x].value);
        }
        $('#disp-total-quantity').val(totalQuantity);
    });
    $('#get-package-form .fee').keyup(function(){
        totalFee = 0;
        
        setInputFilter(this, function(value) {
            return /^-?\d+\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
        }, "Only digits and '.' are allowed and input cannot be empty");

        for(x = 0 ; x< $('#get-package-form .fee').length; x++){
            totalFee = totalFee + parseInt($('#get-package-form .fee')[x].value);
        }
        $('#disp-total-fee').val(totalFee);
    });

    $('#get-package-form .quantity').on('keyup',function(event){
        totalQuantity = 0;
        totalFee = 0;
        if($(this).val() > Number($(this).attr('max'))){
            event.preventDefault();
            $(this).val($(this).attr('max'));
        }
        $("#inp-fee-"+$(this).attr('arrval')).val($(this).val() * $("#inp-fee-"+$(this).attr('arrval')).attr('trueval'));
       
      

        for(x = 0 ; x< $('#get-package-form .quantity').length; x++){
            totalQuantity = totalQuantity + parseInt($('#get-package-form .quantity')[x].value);
        }
        $('#disp-total-quantity').val(totalQuantity);
        
        for(x = 0 ; x< $('#get-package-form .fee').length; x++){
            totalFee = totalFee + parseInt($('#get-package-form .fee')[x].value);
        }
        $('#disp-total-fee').val(totalFee);
    });
   
}

function setInputFilter(textbox, inputFilter, errMsg) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop", "focusout"].forEach(function(event) {
        textbox.addEventListener(event, function(e) {
        if (inputFilter(this.value)) {
            // Accepted value
            if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
            this.classList.remove("input-error");
            this.setCustomValidity("");
            }
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            // Rejected value - restore the previous one
            this.classList.add("input-error");
            this.setCustomValidity(errMsg);
            this.reportValidity();
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
            // Rejected value - nothing to restore
            this.value = "";
        }
        });
    });
}

function generateRegex(max) {
    return new RegExp("^(0|[1-9]\\d{0,"+ (max.toString().length-1) +"}|"+ max +")$");
}