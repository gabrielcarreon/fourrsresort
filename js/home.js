$(document).ready(function () {
    hoverLink();
    sideNav();
    changeNavBtnColor();
    checkLogin();
    togglePassword();
    $("#book-package").on('click', function(){
        window.location.replace("../fourRsResort/php/modules/booking.php");
    });
});

// Toggles animation for side nav
function sideNav() {
    $('.nav-btn').on('click', function () {
        toggleClass();
        $('.icon-bar').css('border','1px solid black')
    });
    $('#about-us-link').on('click', function () {
        toggleClass();

    });
    $('#home-link').on('click', function () {
        toggleClass();
       
    });
    function toggleClass() {
        $('nav').toggleClass('open');
        $('.icon-bar').toggleClass('open');
    }
}

//JS code to change bg when hovering nav link
function hoverLink() {
    const rightNav = [
        ['url("./assets/image/navlinkbg1.jpg")', 'Login to book online!'],
        ['url("./assets/image/navlinkbg2.jpg")', 'Go to home.'],
        ['url("./assets/image/navlinkbg3.jpg")', 'Check our available room for accommodation.'],
        ['url("./assets/image/navlinkbg4.jpg")','Learn more about us.']
    ]
    for (let x = 0; x < 4; x++){
        let y = x+1
        $('.navigation-links:nth-of-type('+ y +')').hover(function () {
            $('.side-nav-right').css('backgroundImage', rightNav[x][0]) 
            $('.nav-link-desc').html(rightNav[x][1]);
            }, function () {
            }
        );   
    }
}

function changeNavBtnColor() {
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 500) {
            $('.icon-bar').css('border','1px solid white')
        } else {
            $('.icon-bar').css('border','1px solid black')
            
        }
    })
}


function checkLogin() {
    // console.log(location.search)
    $('#login-btn').on('click', function () {
        var userid = $('#userid').val();
        var password = $('#password').val();
        $.post("php/handlers/loginHandler.php",
            {
                userIDInput: userid,
                passwordInput: password
            }, function (data) {
                // if (!data) {
                //     $('.custom-error').css('borderColor', 'red')
                //     $('.custom-error-message').html("Incorrect email or password");
                // } else {
                //     window.location.href = "../fourRsResort/php/modules/content.php";
                // }
                if(data ==='false'){
                    $('.custom-error').css('borderColor', 'red')
                    $('.custom-error-message').html("Incorrect email or password");
                }else{
                    window.location.replace("../fourRsResort/php/modules/content.php");
                }
            });
    });
}


function togglePassword(){
    $(".toggle-password").click(function(){
        if($($(this).attr('for')).attr('type') == 'password'){
            $($(this).attr('for')).attr('type','text');
            $('a[for="'+$(this).attr('for')+'"] > .bi-eye-slash').hide();
            $('a[for="'+$(this).attr('for')+'"] > .bi-eye').show();
        }else{
            $($(this).attr('for')).attr('type','password');
            $('a[for="'+$(this).attr('for')+'"] > .bi-eye-slash').show();
            $('a[for="'+$(this).attr('for')+'"] > .bi-eye').hide();
        }
    });
}