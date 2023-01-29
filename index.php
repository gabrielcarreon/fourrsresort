<?php
include_once 'php/database/DBOperations.php';

session_start();
if (isset($_SESSION) && array_key_exists('fourRsuser_type', $_SESSION)) {
    header('Location: http://localhost/fourRsResort/php/modules/content.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Four R's Palace</title>

    <?php
    include 'php/modules/head.php';
    ?>

    <!-- CSS -->
    <link rel="stylesheet" href="css/homestyle.css">

    <!-- Javascript -->
    <script src="js/home.js" type=""></script>

    <!-- Google Chart -->
</head>

<body>
    <!-- <iframe src="https://streamable.com/e/zqcox1?autoplay=1&nocontrols=1" frameborder="0" width="100%" height="100%" allowfullscreen allow="autoplay" class="video"></iframe> -->
    <!-- <div style="width:100%;height:0px;position:relative;padding-bottom:56.250%;"><iframe src="https://streamable.com/e/zqcox1" frameborder="0" width="100%" height="100%" allowfullscreen style="width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden;"></iframe></div> -->
    <video playsisnline autoplay muted loop>
        <source src="./assets/videos/bg.mp4">
        <!-- <source src="https://streamable.com/e/zqcox1?autoplay=1&nocontrols=1"> -->
    </video>

    <nav>
        <div class="row">
            <div class="col-6 col-lg-5">
                <h2 class="pt-5 text-center">Four R's Palace</h2>
                <hr class="mt-50p">
                <div class="">
                    <ul class="text-center px-0 navlinks">
                        <div class="row px-0 align-items-center">
                            <li class="col-12 navigation-links">
                                <a data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                            </li>
                            <li class="col-12 navigation-links" id="home-link">
                                <a href="#home">Home</a>
                            </li>
                            <li class="col-12 navigation-links">
                                <a href="">Book</a>
                            </li>
                            <li class="col-12 navigation-links" id="about-us-link">
                                <a href="#about-us">About Us</a>
                            </li>
                        </div>
                    </ul>
                </div>
                <div class="contacts d-none d-md-block">
                    <p>Find us</p>
                    <span class="contact-links">
                        <i class="fa-solid fa-phone"></i>
                        <p class="d-inline">(+63) 948 404 6610</p>
                    </span>
                    <span class="contact-links d-block">
                        <i class="fa-solid fa-location-dot"></i>
                        <p class="d-inline">Purok 11 Bgry, Santo Nino San Felipe Zambales</p>
                    </span>
                    <span class="contact-links d-block">
                        <i class="fa-brands fa-yahoo"></i>
                        <p class="d-inline">razeenahismael@yahoo.com</p>
                    </span>
                </div>

            </div>
            <div class=" col-6 col-lg-7 side-nav-right row px-0 align-items-end">
                <div class="col-12 nav-desc">
                    <p class="nav-link-desc">Login to see more.</p>
                </div>
            </div>
        </div>
    </nav>
    <!-- LOGIN MODAL -->
    <div class="modal fade modal-lg" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 0.5rem;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-8 col-md-6">
                            <h1 class="font-playfair-display text-center mt-50p">Four R's Palace</h1>
                            <hr>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-10 d-flex flex-column">
                                        <img class="logo mx-auto" src="./assets/image/logo.png" alt="">
                                        <h3>Welcome Back</h3>
                                        <p class="mb-3">Welcome back! Login to continue.</p>

                                        <!-- LOGIN FORM START -->
                                        <div class="mb-2">
                                            <label for="usernameInput" class="form-label login-label">Username</label>
                                            <input id="userid" type="text" class="form-control custom-error" name="username" aria-describedby="usernameHelp" required>
                                        </div>
                                        <div class="">
                                            <label for="passwordInput" class="form-label login-label">Password</label>
                                            <div class="input-group">
                                                <input id="password" type="password" class="form-control  custom-error" name="password" required autocomplete="off">
                                                <a for="#password" class="input-group-text custom-error toggle-password">
                                                    <i class="bi bi-eye" style="display: none;"></i><i class="bi bi-eye-slash"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="usernameHelp" class="custom-error-message mb-3 text-red">
                                        </div>

                                        <!-- <p class="font-noto-sans align-self-end mb-3 cursor-pointer"><u>Forgot
                                                Password?</u>
                                        </p> -->
                                        <!-- <button id="login-btn" name="login" type="submit"
                                                    class="btn btn-primary login-btn mb-3">Login</button> -->

                                        <button id="login-btn" name="login" type="button" class="btn btn-primary login-btn mb-3 font-noto-sans ">Login</button>

                                        <!-- <p class="font-noto-sans align-self-center cursor-pointer"><u>Click here
                                                to sign up</u></p> -->
                                        <!-- LOGIN FORM END -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-6 login-left d-flex justify-content-end" style="border-radius: 0.5rem;">
                            <i class="fa-solid fa-xmark fa-lg" data-bs-dismiss="modal" aria-label="Close"></i>

                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- PACKAGE LIST MODAL -->
    <div class="modal fade" id="package-list-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div id="packageCarouselDiv" class="carousel slide col-6">
                                <div class="carousel-indicators" id="package-indicator">
                                </div>
                                <div class="carousel-inner" id="package-carousel">
                                </div>
                            </div>
                            <div class="col-6 container d-flex flex-column justify-content-between">
                                <div class="row">
                                    <div class="col-8">
                                        <h3 class="mb-0" id="package-name">Package Name</h5>
                                            <h4 class="mb-0" id="package-price">Price</h6>

                                    </div>
                                    <p class="mt-4" id="package-desc">Description</p>

                                </div>
                                <div class="row d-flex align-self-bottom">
                                    <div class="col-12 d-flex justify-content-between align-items-bottom">
                                        <button class="change-package btn btn-primary" type="button" data-bs-target="#packageCarouselDiv" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="btn btn-primary" type="button">
                                            <span class="" aria-hidden="true">Book <i class="fa-solid fa-bell-concierge"></i></span>
                                            <span class="visually-hidden">Book Now</span>
                                        </button>
                                        <button class="change-package btn btn-primary" type="button" data-bs-target="#packageCarouselDiv" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div style='background-image: url("./assets/image/navlinkbg1.jpg")' class="hidden"></div>
    <div style='background-image: url("./assets/image/navlinkbg2.jpg")' class="hidden"></div>
    <div style='background-image: url("./assets/image/navlinkbg3.jpg")' class="hidden"></div>
    <div style='background-image: url("./assets/image/navlinkbg4.jpg")' class="hidden"></div>

    <div class="text-center main-body">
        <div class="nav-btn d-flex justify-content-center align-items-center">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>

        </div>
        <div class="ig-btn">
            <a href="https://www.facebook.com/FourRPalaceSanFelipeZambales">
                <i class="fa-brands fa-facebook fa-xl"></i>
            </a>
            <!-- <a href="">
                <i class="fa-brands fa-instagram fa-xl"></i>
            </a> -->
        </div>
        <section id="home" class="mb-4">
            <h2 class="pt-5 mt-2n5" style="color: #ebe4c9;">Four R's Palace</h2>
            <div class="container">
                <h1 class="mt-10 slogan" style="color: #ebe4c9;">Our simplicity will set you free</h1>
                <div class="row d-flex justify-content-center mt-50p">
                    <div id="book-package" class="col-12 d-flex justify-content-center book-btn">
                        <div class="book-left"><a>Book Now!</a></div>
                        <div class="book-right">
                            <i class="fa-solid fa-bell-concierge"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="perks mt-50p row mx-0">
            <div class="col-12 col-lg-4 mt-4  ">
                <i class="fa-brands fa-lg fa-canadian-maple-leaf"></i>
                <p class="text-white">Experience Nature</p>
            </div>
            <div class="col-12 col-lg-4 mt-4  ">
                <i class="fa-solid fa-lg fa-bed"></i>
                <p class="text-white">Hotel accommodation for up to x people.</p>
            </div>
            <div class="col-12 col-lg-4 mt-4  ">
                <i class="fa-solid fa-lg fa-umbrella-beach"></i>
                <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, commodi?
                </p>
            </div>
            <section id="about-us" class="mt-50p">
                <div class="container">
                    <h1 class="h1-about">About Us</h1>
                    <div class="row mt-50p">
                        <div class="col-12 col-lg-7 mt-5 order-2 order-lg-1">
                            <h5 class="text-start text-white font-noto-sans">Our little story</h5>
                            <p class="about-content">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Assumenda iure corrupti nulla eveniet praesentium laboriosam distinctio. Eveniet,
                                aliquid aperiam voluptatum molestiae minima corporis totam quisquam ducimus sit
                                laborum pariatur veritatis accusamus a illum cupiditate, laudantium quos? Commodi
                                soluta amet reiciendis. Fugit sit repellat officia, totam doloribus provident,
                                accusamus repudiandae iste adipisci neque cumque quasi iusto iure quisquam eius
                                nihil cupiditate beatae suscipit quibusdam minima omnis! In, et praesentium tempore
                                ullam magni mollitia. Aliquid beatae assumenda qui id ratione nam hic corrupti
                                voluptas odit quas provident porro nisi neque sint, molestiae necessitatibus et
                                amet. Asperiores explicabo iure quas doloribus. Maxime, animi.</p>

                        </div>
                        <div data-aos="fade-left" data-aos-duration="1100" class="col-12 col-lg-5 order-1 order-lg-2">
                            <img class="about-us-bg" src="./assets/image/aboutusbg.jpg" alt="">
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>