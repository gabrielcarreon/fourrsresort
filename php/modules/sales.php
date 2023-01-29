<head>
    <script src="/fourRsResort/js/sales.js" type=""></script>
</head>

<main class="accommodation">
    <div class="container-fluid">
        <div class="row header pt-5 d-flex justify-content-center align-items-center">
            <div class="col-3"></div>
            <div class="col-12 col-lg-3 d-flex flex-column justify-content-center align-items-center">
                <h1 class="montserrat">Welcome back!!</h1>
                <div class="d-flex mt-2">
                    <div>
                        <img src="../../assets/image/userplaceholder.svg" alt="" class="user-image" style="background-color: white;">
                    </div>
                    <div class="ms-3">
                        <h4 class="m-0 poppins" id="user-name"><?php echo $_SESSION['fourRsuname'] ?></h4>
                        <p class="m-0 text-secondary small poppins" id="user-role"><?php echo ucfirst($_SESSION['fourRsuser_type']) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 d-flex justify-content-center d-none d-lg-block">
                <img src="../../assets/image/welcomecats.svg" class="svg">
            </div>
            <div class="col-3">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center mt-5">
            <div class="col-12 col-md-3 order-1 order-md-1 d-flex flex-column justify-content-center text-center">
                <a class="selection my-2 mx-1 active-selection" attrid=0>Last 7 days</a>
                <a class="selection my-2 mx-1" attrid=1>This Month</a>
                <a class="selection my-2 mx-1" attrid=2>This Year</a>
                <a id="print-sales" class="my-2 mx-1 btn btn-info" style="padding: 1rem 4rem;">Print</a>

            </div>
            <div class="col-12 col-md-9 order-2 order-md-2">
                <h2 class="text-center">SALES REPORT</h2>
                <p class="small text-secondary text-center" id="filter-disp">Priamry</p>
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Guest</th>
                            <th scope="col">Sales Amount</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <!-- <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr> -->
                        <!-- <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
            <!-- <div class="col-12 col-md-9 order-1 order-md-2" id="curve_chart" style="width: 980px; height: 540px"></div> -->
        </div>
    </div>
    <!-- <div id="carouselExampleDark" class="carousel carousel-dark slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 col-md-3 order-2 order-md-1 d-flex flex-column justify-content-center text-center">
                            <a class="selection my-2 mx-1 active-selection" attrid=0>Last 7 days</a>
                            <a class="selection my-2 mx-1" attrid=1>This Month</a>
                            <a class="selection my-2 mx-1" attrid=2>This Year</a>
                        </div>
                        <div class="col-12 col-md-9 order-1 order-md-2" id="curve_chart" style="width: 980px; height: 540px"></div>
                    </div>
                </div>
            </div>
            <div class="carousel-item ">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 col-md-3 order-2 order-md-1 d-flex flex-column justify-content-center text-center">
                            <a class="selection my-2 mx-1 active-selection" attrid=0>Last 7 days</a>
                            <a class="selection my-2 mx-1" attrid=1>This Month</a>
                            <a class="selection my-2 mx-1" attrid=2>This Year</a>
                        </div>
                        <div class="col-12 col-md-9 order-1 order-md-2" id="curve_chart" style="width: 980px; height: 540px"></div>
                    </div>
                </div>
            </div>


        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div> -->
</main>