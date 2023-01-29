<head>
    <script src="/fourRsResort/js/users.js" type=""></script>
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
    <div class="container mb-5">
        <div class="row mt-5 d-flex justify-content-center">
            <table id="users-table" class="row-border">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>User type</td>
                    </tr>
                </thead>
                <tbody id="users-tbody">

                </tbody>
            </table>
        </div>
    </div>
    <?php
    $access = $_SESSION['fourRsuser_type'];
    if ($access == 'admin') {
    ?>
        <div class="btn-add-users" data-bs-toggle="modal" data-bs-target="#add-user-modal">
            <i class="bi bi-plus" style="color: white;"></i>
        </div>
    <?php
    }
    ?>
</main>