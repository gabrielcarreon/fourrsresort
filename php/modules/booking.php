<?php
include_once '../database/DBOperations.php';

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
    include 'head.php';
    ?>

    <!-- CSS -->
    <link rel="stylesheet" href="../../css/booking.css">

    <!-- Javascript -->
    <script src="../../js/booking.js" type=""></script>

    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
    <script src="../../js/bootstrap-datetimepicker.min.js"></script>
</head>

<body>
    <div class="container-fluid px-0 mx-0 d-flex ">
        <div class="left-side d-none d-md-block">
            <img class="left-pic" src="../../assets/image/navlinkbg1small.jpg">
            <div class="" id="package-desc">
                <p id="package-description" class="p-2" style="font-family: 'Noto Sans', sans-serif; font-size: 1.2rem; color: white;">
                    Check out our current promos!
                    <!-- (Good for 6 pax)
                    💧1 Kubo
                    💧1 table
                    💧3 foam
                    💧2 fan
                    💧Extra socket for charging
                    💧Entrance fee
                    💧Use of common bathroom &amp;amp; shower rooms
                    💧Use of griller -->
                </p>
            </div>


        </div>
        <div class="right-side">
            <div class="nav py-2 sticky-top bg-white " style="border-bottom: 1px solid #e9ecef;">
                <div class="container">
                    <div class="row d-flex justify-content-end">
                        <div class="col-4 d-flex justify-content-end mx-0 px-0 mt-2">
                            <a type="button" href="../../index.php" class="px-4 btn btn-primary me-4" style="background-color: #34708c; border-color: #34708c;font-family: 'Noto Sans' ,sans-serif; font-size:1.1rem; text-decoration: none;">Home</a>

                        </div>

                    </div>
                    <div class="row mt-5 mx-5">
                        <div class="col-6">
                            <h2>Booking</h2>
                            <h4 id="package-result-num" class="text-secondary"></h4>

                        </div>
                    </div>
                    <div class="row mx-5 d-flex mb-2">
                        <div class="col-12 col-lg-3">
                            <select id="filter-price" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="font-family: 'Noto Sans', sans-serif;">
                                <option value="" selected>All</option>
                                <option value="1">Less than ₱2000</option>
                                <option value="2">₱2000 - ₱4000</option>
                                <option value="3">More than ₱4000</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">

                <div class="row mt-5 mx-5">
                    <div class="container">
                        <div class="row" id="package-content">
                            <!-- <div class="col-12 col-lg-4 mb-4">
                                <div class="card" style="width: 18rem;">
                                    <img src="../../assets/image/279128484_370465538362878_7061104466608753117_n.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Package RR</h5>
                                        <h5 class="card-title">₱2500</h5>
                                        <p class="d-block d-md-none">
                                            💧1 Kubo
                                            💧1 table
                                            💧3 foam
                                            💧2 fan
                                            💧Extra socket for charging
                                            💧Entrance fee
                                            💧Use of common bathroom &amp;amp; shower rooms
                                            💧Use of griller
                                        </p>
                                        <button href="#" class="btn btn-primary">Click for more info</button>
                                        <button href="#" class="ms-4 btn btn-primary">Book</button>

                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal fade" id="booking-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="get_package_name">Package Name</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 0 !important;">
                    <div class="row">
                        <img id="get-package-img" src="../handlers/package/placeholder.jpg" alt="">
                    </div>
                    <div class="container-fluid">
                        <form id="get-package-form">

                            <div class="row mx-5">
                                <div class="col-12">
                                    <h5 class="card-title card-package-no mt-3" id="disp-package-name"></h5>
                                    <h5 class="card-text card-package-price mt-1 " id="disp-package-price"></h5>
                                    <input type="hidden" name="id-book-online" id="id-book-online">
                                </div>
                            </div>
                            <hr class="style-two">
                            <div class="row mx-5">
                                <div class="col-12">
                                    <p class="card-text card-package-description mt-1 " id="disp-package-desc" style="text-align: justify;">💧1 Kubo 💧1 table 💧3 foam 💧2 fan 💧Extra socket for charging 💧Entrance fee 💧Use of common bathroom & shower rooms 💧Use of griller</p>
                                </div>
                            </div>
                            <hr class="style-two">
                            <div id="package-steps-carousel" class="carousel slide" data-bs-ride="true" data-bs-interval="10000000000">
                                <div class="carousel-inner" style="overflow: visible;">
                                    <div class="carousel-item active" step="1">
                                        <div class="mx-5 row">
                                            <div class="mb-3 col-12 col-md-8">
                                                <label for="guest-name" class="form-label">Guest</label>
                                                <input placeholder="Ex. Juan Dela Cruz" type="text" class="form-control needs-validation" name="inp-guest-name" id="inp-guest-name" required>
                                                <div class="invalid-feedback small" style="display: none;">
                                                    Field cannot be empty!
                                                </div>
                                                <p class="small text-secondary italic">Required</p>

                                            </div>
                                            <div class="mb-3 col-12 col-md-4">
                                                <label for="guest-name" class="form-label">Down Payment</label>
                                                <input value=0 type="tel" min=0 class="form-control needs-validation fee" name="inp-guest-price" id="inp-package-price" readonly>
                                                <div class="invalid-feedback small" style="display: none;">
                                                    Field cannot be empty!
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mx-5 row">
                                            <div class="mb-3 col-12 col-md-4">
                                                <label for="inp-time-in" class="form-label">Time In</label>
                                                <input placeholder="Select guest time in" type="text" class="form-control inp-time" name="inp-time-in" id="inp-time-in" required readonly>
                                                <div class="invalid-feedback small" style="display: none;">
                                                    Field cannot be empty!
                                                </div>
                                            </div>
                                            <div class="mb-3 col-12 col-md-4">
                                                <label for="inp-time-out" class="form-label">Time Out</label>
                                                <input placeholder="Select guest time out" type="text" class="form-control inp-time" id="inp-time-out" name="inp-time-out" required readonly>
                                                <div class="invalid-feedback small" style="display: none;">
                                                    Field cannot be empty!
                                                </div>
                                            </div>
                                            <div class="mb-3 col-12 col-md-4">
                                                <label for="total-hours" class="form-label">Total Time</label>
                                                <input id="total-hours" placeholder="0" type="text" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="mx-5 row">
                                            <div class="mb-3 col-12 col-md-4">
                                                <label for="inp-contact-number" class="form-label">Contact Number</label>
                                                <input placeholder="Enter contact number" type="tel" maxlength="11" class="form-control needs-validation" name="inp-contact-number" id="inp-contact-number" required>
                                                <div class="invalid-feedback small" style="display: none;">
                                                    Field cannot be empty!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item" step="2">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12 d-flex flex-column align-items-center">
                                                    <h3 class="text-center">Scan Gcash QR Code</h3>
                                                    <h5 class="text-secondary" id="to-pay-carousel"> to pay.</h5>
                                                    <img src="../../assets/image/qrcode.jpg" alt="" style="height: 200px; max-height:200px; object-fit:cover;">
                                                    <p class="text-secondary mt-3">Your Gcash receipt will be needed.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item" step="3">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3 class="text-center">Upload Gcash Receipt</h3>
                                                    <input type="file" id="inp-receipt-img" name="inp-receipt-img">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item" step="4">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3 class="text-center">Upload Valid ID</h3>
                                                    <input type="file" id="inp-id-img" name="inp-id-img">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-target="#package-steps-carousel" data-bs-slide="prev" style="display: none;">Back</button>
                                <button type="button" class="btn btn-primary" data-bs-target="#package-steps-carousel" data-bs-slide="next" disabled>Next</button>
                                <button type="button" class="btn btn-primary" id="btn-book-online" style="display: none;" disabled>Book</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- SUCCESS MODAL -->
    <div class="modal fade" id="success_tic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body my-2" style="text-align:center;">
                    <h1>
                        <div class="checkmark-circle">
                            <div class="background"></div>
                            <div class="checkmark draw"></div>
                        </div>
                    </h1>
                    <h5 id="response-message">Message</h5>

                </div>
            </div>
        </div>
    </div>

    <!-- FAIL MODAL -->
    <div class="modal fade" id="fail_tic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" style="text-align:center;">
                <div class="modal-body mt-2 d-flex justify-content-center">
                    <div class="modal-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="white" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                        </svg>
                    </div>


                </div>
                <h5 id="fail-response-message" class="pb-3">Message</h5>

            </div>
        </div>
    </div>
</body>

</html>