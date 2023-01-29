<nav class="navbar navbar-expand-lg bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#"><img src="../../assets/image/logo.png" class="logo">&nbsp;Four Rs Resort</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item d-flex">
                    <a class="nav-link text-white" aria-current="page" href="?page=packages">Packages</a>
                </li>
                <li class="nav-item mx-md-2">
                    <a class="nav-link text-white" aria-current="page" href="?page=transactions">Transactions</a>
                </li>
                <li class="nav-item mx-md-2">
                    <a class="nav-link text-white" href="?page=inventory">Inventory</a>
                </li>
                <li class="nav-item mx-md-2">
                    <a class="nav-link text-white" href="?page=sales">Sales Report</a>
                </li>
                <?php if ($_SESSION['fourRsuser_type'] == 'admin') { ?>
                    <li class="nav-item mx-md-2">
                        <a class="nav-link text-white" href="?page=users">Users</a>
                    </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu" style="left: auto !important; right: -12px !important">
                        <li><a class="dropdown-item text-black cursor-pointer" data-bs-toggle="modal" data-bs-target="#change-password-modal"><i class="bi bi-gear-fill"></i>&nbsp;Change Password</a></li>
                        <li><a class="dropdown-item text-black cursor-pointer" id="btn-logout"><i class="bi bi-box-arrow-right"></i>&nbsp;Logout</a></li>
                        <!-- <li>
                            <hr class="dropdown-divider">
                        </li> -->
                        <!-- <li><a class="dropdown-item text-black" href="#">Something else here</a></li> -->
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    $(document).ready(function() {
        $(".nav-link[href='" + location.search + "']").addClass('active');
        $('#btn-logout').click(function() {
            console.log('lgoout');
            $.post('../handlers/loginHandler.php', {
                'logout': 1
            }, function(data) {
                console.log(data);
                if (data === 'true') {
                    window.location.href = "../../index.php";
                }
            });
        });
    });
</script>
<script src="../../js/changepass.js"></script>