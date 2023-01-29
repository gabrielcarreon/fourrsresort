<div class="side-bar">
    <div class="side-bar-links">
        <ul class="side-bar-icons text-center px-0">
            <li class="d-flex align-items-center side-bar-icon ms-2 side-nav-link">
                <a class="d-flex align-items-center" href="?page=accommodation">
                    <i class='bx bx-hotel icon'>
                    </i>
                    <span class="side-bar-text">&nbsp; Accommodation</span>
                </a>
            </li>
            <li class="d-flex align-items-center side-bar-icon ms-2 side-nav-link">
                <a class="d-flex align-items-center" href="?page=inventory">
                    <i class='bx bx-sitemap icon'></i>
                    <span class="side-bar-text">&nbsp; Inventory</span>
                </a>
            </li>
            <li class="d-flex align-items-center side-bar-icon ms-2 side-nav-link">
                <a class="d-flex align-items-center">
                    <i class='bx bx-line-chart icon'></i>
                    <span class="side-bar-text">&nbsp; Sales</span>
                </a>
            </li>
            <?php
            if ($_SESSION['role'] == 'admin') {
                echo '
                    <li class="d-flex align-items-center side-bar-icon ms-2 side-nav-link">
                <a class="d-flex align-items-center">
                    <i class="bx bx-user icon"></i>
                    <span class="side-bar-text">&nbsp; Manage</span>
                </a>
            </li>
                    ';
            }
            ?>
            <!-- <li class="d-flex align-items-center side-bar-icon ms-2">
                <a href="" class="d-flex align-items-center">
                    <i class='bx bx-user icon'></i>
                    <span class="side-bar-text">&nbsp; Manage</span>
                </a>
            </li> -->
        </ul>
    </div>
</div>