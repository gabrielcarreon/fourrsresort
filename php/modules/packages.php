<head>
    <script src="/fourRsResort/js/accommodation.js" type=""></script>

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
        <div class="row mt-5 d-flex justify-content-center" id="accommodation-body">

        </div>
    </div>
    <?php
    $access = $_SESSION['fourRsuser_type'];
    if ($access == 'admin') {
    ?>
        <div class="" id="btn-add-accommodation">
            <i class="bi bi-plus" style="color: white;"></i>
        </div>
    <?php
    }
    ?>
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#success_tic">
        Launch static backdrop modal
    </button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fail_tic">
        Launch static backdrop modal
    </button> -->
</main>