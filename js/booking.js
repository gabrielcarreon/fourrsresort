$(document).ready(function(){
    modalHeight = 0;
    getPackage();
    $.fn.fileinputBsVersion = "3.3.7";
    $('#inp-time-in').datetimepicker(
        {
            minDate: new Date(),
            ignoreReadonly:true,
            sideBySide:true,
        }
    );
    $('#inp-time-out').datetimepicker(
        {
            minDate: new Date(),
            useCurrent:false,
            ignoreReadonly:true,
            sideBySide:true,
        }
    );
    $("#filter-price").on('change', function(){
        $("#package-content").empty();
        $(".more-info").off();
        getPackage();
    });
    $(".carousel-item.active[step='1'] input").on('change', function(){
        isvalid = true;
        $.each($(".carousel-item.active[step='1'] input"),function(){
            if($(this).val() == '' || $(this).val() == ' '){
                isvalid = false;
            }
        });
        if(isvalid){
            $('button[data-bs-slide="next"]').prop('disabled', false);
        }else{
            $('button[data-bs-slide="next"]').prop('disabled', true);
        }
    });
    $('#inp-id-img').on('change', function(){
        isvalid = true;
        if($(this).val() == ''){
            isvalid = false;
        }
        if(isvalid){
            $("#btn-book-online").prop('disabled', false);
        }else{
            $("#btn-book-online").prop('disabled', true);

        }

    });
    $('#inp-receipt-img').on('change', function(){
        isvalid = true;
        if($(this).val() == ''){
            isvalid = false;
        }
        if(isvalid){
            $('button[data-bs-slide="next"]').prop('disabled', false);
        }else{
            $('button[data-bs-slide="next"]').prop('disabled', true);
        }

    });

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
        isvalid = true;
        $.each($(".carousel-item.active[step='1'] input"),function(){
            if($(this).val() == '' || $(this).val() == ' '){
                isvalid = false;
            }
        });
        if(isvalid){
            $('button[data-bs-slide="next"]').prop('disabled', false);
        }else{
            $('button[data-bs-slide="next"]').prop('disabled', true);
        }
    });

    $("#package-steps-carousel").on('slide.bs.carousel', function(){
        let step = $(".carousel-item.active").attr('step');

    });
    $("#package-steps-carousel").on('slid.bs.carousel', function(){
        let step = $('.carousel-item.active').attr('step');
        $(".carousel-inner").css({'overflow': 'visible'});

        if(step =='2'){
            $('button[data-bs-slide="next"]').show();
            $("#to-pay-carousel").html("₱"+$("#inp-package-price").val()+" to pay.");
            $('button[data-bs-slide="prev"]').show();
            $('button[data-bs-slide="next"]').removeAttr('id');
            $("#btn-book-online").hide();


        }else if(step =='1'){
            $('button[data-bs-slide="next"]').show();

            $('button[data-bs-slide="prev"]').hide();
            $('button[data-bs-slide="next"]').removeAttr('id');
            $("#btn-book-online").hide();


        }else if(step =='4'){
            $('button[data-bs-slide="next"]').removeAttr('id');
            $('button[data-bs-slide="next"]').hide();
            $("#btn-book-online").show();

        }else if(step == '3'){
            $('button[data-bs-slide="next"]').show();
            $('button[data-bs-slide="next"]').prop('disabled', true);
            $("#btn-book-online").hide();

        }
    });
    $('button[data-bs-slide="next"]').on('click', function(event){
        let step = $('.carousel-item.active').attr('step');
        $(".carousel-inner").css({'overflow': 'hidden'});
    });
    $('button[data-bs-slide="prev"]').on('click', function(){
        let step = $('.carousel-item.active').attr('step');
        console.log(step);
        if(step == '3'){
            $('button[data-bs-slide="next"]').prop('disabled', false);
        }else{
            $('button[data-bs-slide="next"]').prop('disabled', true);
        }
        $(".carousel-inner").css({'overflow': 'hidden'});

    })
   
    $("#inp-id-img").fileinput({
        "allowedFileTypes": ['image'],
        "allowedFileExtensions": ['jpg', 'png'],
        "required": true,
        "focusCaptionOnBrowse": false,
        "required": true,
    });
    $("#inp-receipt-img").fileinput({
        "allowedFileTypes": ['image'],
        "allowedFileExtensions": ['jpg', 'png'],
        "required": true,
        "focusCaptionOnBrowse": false,
        "required": true,
    });
    $("#btn-book-online").on('click', function(){
        var receiptImg = $('#inp-receipt-img').prop('files');
        var receiptImg = receiptImg[0];

        var idImg = $('#inp-id-img').prop('files');
        var idImg = idImg[0];

        let formData = new FormData($("#get-package-form")[0]);
        $.ajax({
            url: '../../php/handlers/bookingHandler.php',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                $("#booking-modal").modal('hide');
                feedbackModal(data, "Booking success, you will be contacted through the contact number that you've provided.", "Booking Failed", 1);
            }
        });
    });
});

function getPackage(){
    $.post('../handlers/getOnlineBookingHandler.php', {'filter-price': $("#filter-price").val()},function(data){
        jsondata = JSON.parse(data);
        count = 0;
        if(jsondata.length > 1){
             result = ' results';
        }else{
             result = ' result';
        }
        $("#package-result-num").html(jsondata.length + result);
        jsondata.forEach(element => {                                   
            $("#package-content").append(`
            <div class="col-12 col-xl-6 col-xxl-4 mb-4">
                <div class="card" style="width: 18rem;">
                        <img src="../handlers/package/`+element.image+`.jpg" class="card-img-top" alt="..." style="object-fit: cover;
                        max-height: 200px !important;
                        height: 200px !important;">
                    <div class="card-body">
                        <h5 class="card-title">`+element.package_name+`</h5>
                        <h5 class="card-title text-secondary">₱`+element.price+`</h5>
                        <p class="d-block d-md-none">`+element.description+`</p>
                        <button class="btn btn-info more-info" package="`+element.package_id+`">Click for more info</button>
                        <button class="ms-2 btn btn-success book-online" package="`+element.package_id
                        +`" data-bs-toggle="modal" data-bs-target="#booking-modal">Book</button>
                    </div>
                </div>
            </div>
            `);
        });
    }).then(function(){
        $(".more-info").on('click', function(){
            let packageid = $(this).attr('package');
            $.post('../handlers/accommodationHandler.php', {'disp_package_id': packageid}, function(data){
                jsondata = JSON.parse(data);
                $(".left-pic").attr('src', '../handlers/package/'+jsondata.image+'.jpg');
                $('#package-description').html(jsondata.description);
            });
        });
        $('.book-online').on('click', function(){
            let packageid = $(this).attr('package');
            $.post('../handlers/accommodationHandler.php', {'disp_package_id': packageid}, function(data){
                jsondata = JSON.parse(data);
                $("#id-book-online").val(jsondata.package_id);
                $("#disp-package-name").html(jsondata.package_name);
                $("#disp-package-price").html("₱"+jsondata.price);
                $("#get_package_name").html(jsondata.package_name);
                $("#get-package-img").attr('src', '../handlers/package/'+jsondata.image+'.jpg');
                $('#disp-package-desc').html(jsondata.description);
                $("#inp-package-price").val(jsondata.price / 2);
            });
        });
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
    }, 5000);
    $("#fail_tic").modal('hide');
    if(reload === 1){
        setTimeout(function(){
            location.reload();
        }, 5000);
    }
 
}
