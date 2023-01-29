<!-- PACKAGE MODAL -->
<div class="modal fade" id="accommodationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title package-name" id="exampleModalLabel"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="accommodation-form" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <div class="mb-3 col-6">
                                <label for="package-name" class="form-label">Package Name</label>
                                <input type="text" class="form-control needs-validation" name="inp-package-name" id="package-name" required>
                                <div class="invalid small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="package-price" class="form-label">Package Price</label>
                                <input min=0 type="number" class="form-control needs-validation" name="inp-package-price" id="package-price">
                                <div class="invalid small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control needs-validation" name="inp-description" id="description" rows="3" placeholder="Enter description here..." required></textarea>
                                <div class="invalid small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="package-image-upload" class="form-label">Package Image</label>
                                <div class="input-group">
                                    <input accept="image/*" type="file" name="inp-image" class="form-control needs-validation" id="package-image-upload" required aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="package-status" class="form-label">Package Status</label>
                                <div class="input-group select-invalid">
                                    <select name="inp-status" class="form-select needs-validation" aria-label="Default select example" id="room-status" required>
                                        <option value="1" selected>Available</option>
                                        <option value="0">Unavailable</option>
                                    </select>
                                </div>
                                <div class="invalid small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <?php
                // print_r($_SESSION);
                if ($_SESSION['fourRsuser_type'] == 'admin') {
                    echo '<button type="button" class="btn btn-danger" id="accommodation-delete">Delete</button>';
                }
                ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary color-primary" id="accommodation-save">Save</button>
                <button type="button" class="btn btn-primary color-primary" id="accommodation-add" style="display: none;">Add</button>
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

<!-- GET PACKAGE MODAL -->
<div class="modal fade" id="get_package_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
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
                    <div class="row mx-5">
                        <div class="col-12">
                            <h5 class="card-title card-package-no mt-3" id="disp-package-name"></h5>
                            <h5 class="card-text card-package-price mt-1 " id="disp-package-price"></h5>
                        </div>
                    </div>
                    <hr class="style-two">
                    <div class="row mx-5">
                        <div class="col-12">
                            <p class="card-text card-package-description mt-3 " id="disp-package-desc" style="text-align: justify;">💧1 Kubo 💧1 table 💧3 foam 💧2 fan 💧Extra socket for charging 💧Entrance fee 💧Use of common bathroom & shower rooms 💧Use of griller</p>
                        </div>
                    </div>
                    <hr class="style-two">
                    <form id="get-package-form">
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
                                <label for="guest-name" class="form-label">Price</label>
                                <input value=0 type="tel" min=0 class="form-control needs-validation fee" name="inp-guest-price" id="inp-package-price" required>
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
                        <hr class="style-two">
                        <div class="row mx-5">
                            <div class="container">
                                <div class="col-12">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col" style="width: 50%;">Add On</th>
                                                <th scope="col" style="width: 25%;">Quantity</th>
                                                <th scope="col" style="width: 25%;">Fee</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addon-tbody">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="">
                                                    <p class="text-center mb-0">Total</p>
                                                </td>
                                                <td>
                                                    <div class="col-12">
                                                        <input min=0 type="number" class="form-control" id="disp-total-quantity" readonly>
                                                    </div>
                                                </td>
                                                <td class="container">
                                                    <div class="col-12">
                                                        <input min=0 type="number" class="form-control" id="disp-total-fee" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-5">
                            <a class="btn mb-3 col-12 d-flex justify-content-between align-items-center" id="add-addons">
                                <p class="mb-0">Add On</p>
                                <i class="bi bi-plus-square"></i>
                            </a>
                        </div>
                        <div class="row mx-5 py-4">
                            <div class="col-6"></div>
                            <div class="mb-0 col-md-4">
                                <input placeholder="Enter downpayment" type="text" class="form-control needs-validation" name="inp-downpayment" id="inp-downpayment" required>
                                <input placeholder="Enter amount paid" type="text" class="form-control needs-validation" name="inp-amount-paid" id="inp-amount-paid" required style="display: none;">
                                <div class="invalid-feedback small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <div class="form-check form-switch">

                                    <label class="mb-0" class="form-check-label" for="is-package-paid">Paid</label>
                                    <input class="form-check-input" type="checkbox" role="switch" id="is-package-paid">

                                    <div class="invalid-feedback small" style="display: none; color: white;">
                                        Field
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="get-package">Get Package</button>
                </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Transaction Modal -->
<div class="modal fade" id="transaction-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Transaction Info</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0 !important;">
                <div class="row">
                    <img id="trans-package-image" src="../handlers/package/placeholder.jpg" alt="">
                </div>
                <div class="container-fluid">
                    <div class="row mx-5">
                        <div class="col-12">
                            <h5 class="card-title card-package-no mt-3" id="trans-package-name"></h5>
                        </div>
                    </div>
                    <hr class="style-two">
                    <form id="trans-package-form">
                        <input type="number" name="trans-id" id="trans-id" hidden readonly>
                        <div class="mx-5 row">
                            <div class="mb-3 col-12 col-md-8">
                                <label for="trans-guest-name" class="form-label">Guest</label>
                                <input type="text" class="form-control needs-validation" id="trans-name" readonly>
                                <div class="invalid small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label for="trans-contact-number" class="form-label">Contact Number</label>
                                <input readonly placeholder="Enter contact number" type="tel" maxlength="11" class="form-control needs-validation" id="trans-contact-number" required>
                                <div class="invalid-feedback small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>

                        </div>
                        <div class="mx-5 row">
                            <div class="mb-3 col-12 col-md-4">
                                <label for="trans-staff-name" class="form-label">Staff</label>
                                <input type="text" class="form-control needs-validation" id="trans-staff-name" readonly>
                                <div class="invalid small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-5">
                                <label for="trans-booked" class="form-label">Time Booked</label>
                                <input placeholder="Select guest time in" type="text" class="form-control" id="trans-booked" required readonly>
                                <div class="invalid-feedback small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-3">
                                <label for="trans-package-price" class="form-label">Price</label>
                                <input value=100 type="tel" min=0 class="form-control needs-validation  trans-fee" id="trans-package-price" readonly>
                                <div class="invalid small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>

                        </div>
                        <div class="mx-5 row">

                            <div class="mb-3 col-12 col-md-4">
                                <label for="trans-time-in" class="form-label">Time In</label>
                                <input placeholder="Select guest time in" type="text" class="form-control" id="trans-time-in" required readonly>
                                <div class="invalid-feedback small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label for="trans-time-out" class="form-label">Time Out</label>
                                <input placeholder="Select guest time out" type="text" class="form-control" id="trans-time-out" required>
                                <div class="invalid-feedback small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label for="trans-total-time" class="form-label">Total Hours</label>
                                <input value="0" type="text" class="form-control" id="trans-total-time" readonly>
                                <div class="invalid-feedback small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                        </div>
                        <hr class="style-two">
                        <div class="row mx-5">
                            <div class="container">
                                <div class="col-12">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col" style="width: 50%;">Add On</th>
                                                <th scope="col" style="width: 25%;">Quantity</th>
                                                <th scope="col" style="width: 25%;">Fee</th>
                                            </tr>
                                        </thead>
                                        <tbody id="trans-addon-tbody">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>
                                                    <p class="text-center mb-0">Downpayment</p>
                                                </td>
                                                <td>
                                                    <div class="col-12 text-center">
                                                        Less
                                                    </div>
                                                </td>
                                                <td class="container">
                                                    <div class="col-12">
                                                        <input min=0 type="number" class="form-control" id="trans-downpayment" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="text-center mb-0">Total</p>
                                                </td>
                                                <td>
                                                    <div class="col-12">
                                                        <input min=0 type="number" class="form-control" id="trans-total-quantity" readonly>
                                                    </div>
                                                </td>
                                                <td class="container">
                                                    <div class="col-12">
                                                        <input min=0 type="number" class="form-control" id="trans-total-fee" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-5">
                            <a class="btn mb-3 col-12 d-flex justify-content-between align-items-center" id="trans-add-addons">
                                <p class="mb-0">Add On</p>
                                <i class="bi bi-plus-square"></i>
                            </a>
                        </div>
                        <div id="online-receipts" class="row" style="display: none;">
                            <input type="file" name="" id="disp-receipt">
                        </div>
                        <div class="row mx-5 py-4">
                            <div class="col-6"></div>
                            <div class="mb-0 col-md-4">
                                <input placeholder="Enter amount paid" type="text" class="form-control needs-validation" value=0 name="trans-amount-paid" id="trans-amount-paid" required style="display: none;">
                                <div class="invalid-feedback small" style="display: none;">
                                    Field cannot be empty!
                                </div>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="trans-is-package-paid" id="trans-is-package-paid">
                                    <label class="mb-0" class="form-check-label" for="is-package-paid">Paid</label>
                                    <div class="invalid-feedback small" style="display: none; color: white;">
                                        Field
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-confirm-payment" style="display: none;">Confirm Payment</button>

                <button type="button" class="btn btn-primary" id="btn-trans-save">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Inventory Modal-->
<div class="modal fade" id="inventory-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container">
                <form id="inventory-form" class="inv-form">
                    <input type="number" id="inv-id" name="inv-id" hidden>
                    <div class="mb-3 row  mx-4">
                        <div class="col-6">
                            <label for="inv-name" class="col-form-label">Item name</label>
                        </div>
                        <div class="col-6">
                            <input name="inv-name" type="text" class="form-control" id="inv-name" <?php if ($_SESSION['fourRsuser_type'] == 'staff') { ?> readonly <?php } ?>>
                            <div class="invalid-feedback small" style="display: none;">
                                Field cannot be empty!
                            </div>
                        </div>

                    </div>
                    <div class="mb-3 row  mx-4">
                        <div class="col-6">
                            <label for="inv-quantity" class="col-form-label">Quantity</label>
                        </div>
                        <div class="col-6">
                            <input name="inv-quantity" type="tel" min=0 class="form-control" id="inv-quantity" <?php if ($_SESSION['fourRsuser_type'] == 'staff') { ?> readonly <?php } ?>>
                            <div class="invalid-feedback small" style="display: none;">
                                Field cannot be empty!
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row  mx-4">
                        <div class="col-6">
                            <label for="inv-price" class="col-form-label">Price</label>
                        </div>
                        <div class="col-6">
                            <input name="inv-price" type="tel" min=0 class="form-control" id="inv-price" <?php if ($_SESSION['fourRsuser_type'] == 'staff') { ?> readonly <?php } ?>>
                            <div class="invalid-feedback small" style="display: none;">
                                Field cannot be empty!
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row mx-4">
                        <div class="col-12 d-flex justify-content-end">
                            <div class="form-check form-switch">
                                <input name="inv-available" class="form-check-input" type="checkbox" role="switch" id="inv-available" checked <?php if ($_SESSION['fourRsuser_type'] == 'staff') { ?> disabled <?php } ?>>
                                <label class="form-check-label" for="inp-available">Available</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <?php if ($_SESSION['fourRsuser_type'] == 'admin') {
                ?>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">Delete</button>
                <?php } ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <?php
                if ($_SESSION['fourRsuser_type'] == 'admin') { ?>
                    <button type="button" class="btn btn-primary" id="inv-save-changes">Save changes</button>
                <?php } ?>
                <button type="button" class="btn btn-primary" id="add-item" style="display: none;">Add Item</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalTitle">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="deleteModalMessage">Are you sure you want to delete?&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="btn-delete-item">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation User Modal -->
<div class="modal fade" id="deleteUserConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteUserModalTitle">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="deleteUserModalMessage">Are you sure you want to delete?&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="btn-delete-user">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- USER MODAL -->
<div class="modal fade" id="userinfomodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-8 d-flex align-items-center">
                            <img src="../../assets/image/userplaceholder.jpg" class="rounded-circle user-image" />
                            <div class="ms-3">
                                <p class="fw-bold mb-0" id="userinfo-name"></p>
                                <p class="text-muted mb-0 small" id="userinfo-userid"></p>
                                <p class="text-muted text-secondary mb-0 small" id="userinfo-email"></p>
                            </div>
                        </div>
                        <div class="col-4 d-flex align-items-center">
                            <div class="form-check form-switch d-flex text-center mx-auto">
                                <input class="form-check-input" type="checkbox" role="switch" id="is-active" checked>
                                <label class="form-check-label" for="isActive">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-1"></div>
                        <!-- <div class="col-6 d-flex align-items-end">
                            <select class="form-select" aria-label="Default select example" id="userinfo-role">
                                <option value='' disabled selected>Role</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div> -->
                        <div class="col-10 d-flex align-items-center">
                            <div class="input-group">
                                <label class="form-check-label align-self-center" for="userinfo-password">Password:&nbsp;</label>

                                <input type="password" id="userinfo-password" class="form-control" placeholder="User password" aria-label="User password" aria-describedby="basic-addon2">
                                <a for="#userinfo-password" type="button" class="input-group-text toggle-password"><i class="bi bi-eye" style="display: none;"></i><i class="bi bi-eye-slash"></i></a>
                                <div class="invalid-feedback">
                                    Password can't be empty.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <?php if ($_SESSION['fourRsuser_type'] == 'admin') { ?>
                    <a class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteUserConfirmationModal">Delete</a>
                <?php } ?>
                <a class="btn btn-primary text-white" id="userinfo-edit">Save</a>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="add-user-modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="add-user-form">
                        <div class="row">
                            <div class="col-3 mb-3">
                                <label for="add-user-fname" class="form-label">First name</label>
                                <input type="email" class="form-control" name="add-user-fname" id="add-user-fname" placeholder="John">
                                <div class="invalid-feedback">
                                    First name can't be empty
                                </div>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="add-user-mname" class="form-label">Middle name</label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" name="checkbox-mname" id="mname-checkbox" type="checkbox" aria-label="Checkbox for middle name" checked>
                                    </div>
                                    <input type="text" class="form-control" name="add-user-mname" id="add-user-mname" placeholder="Michael">
                                    <div class="invalid-feedback">
                                        Middle name can't be empty
                                    </div>
                                </div>

                            </div>
                            <div class="col-4 mb-3">
                                <label for="add-user-lname" class="form-label">Last name</label>
                                <input type="text" class="form-control" name="add-user-lname" id="add-user-lname" placeholder="Doe">
                                <div class="invalid-feedback">
                                    Last name can't be empty
                                </div>
                            </div>
                            <div class="col-2 mb-3">
                                <label for="add-user-suffix" class="form-label">Suffix</label>
                                <div class="input-group">

                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" name="checkbox-suffix" id="suffix-checkbox" type="checkbox" aria-label="Checkbox for suffix" checked>
                                    </div>
                                    <input type="text" class="form-control" name="add-user-suffix" id="add-user-suffix" placeholder="Jr.">

                                    <div class="invalid-feedback">
                                        Suffix can't be empty
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4">
                                <label for="add-user-email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="add-user-email" id="add-user-email" placeholder="johnmichaeldoe@gmail.com">
                                <div class="invalid-feedback">
                                    Email can't be empty
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="add-user-password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="add-user-password" id="add-user-password" class="form-control" placeholder="User password" aria-label="User password" aria-describedby="basic-addon2">
                                    <a for="#add-user-password" class="input-group-text toggle-password">
                                        <i class="bi bi-eye" style="display: none;"></i><i class="bi bi-eye-slash"></i>
                                    </a>
                                    <div class="invalid-feedback">
                                        Password can't be empty
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <label for="add-user-role" class="form-label">Role</label>

                                <select class="form-select" aria-label="Default select example" name="add-user-role" id="add-user-role">
                                    <option value="staff">Staff</option>
                                    <option value="admin">Admin</option>

                                </select>
                            </div>
                            <div class="col-2">
                                <label for="add-user-is-active" class="form-label ms-2">Active</label>
                                <div class="form-check form-switch d-flex text-center ms-2 mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" name="add-user-is-active" id="add-user-is-active" checked>
                                    <label class="form-check-label" for="isActive">&nbsp;Active</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a class="btn btn-primary text-white" id="btn-add-user">Add</a>
            </div>
        </div>
    </div>
</div>

<!-- Change pass modal -->
<div class="modal fade" id="change-password-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Change password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="change-password-form">

                    <label for="old-password" class="form-label">Old Password</label>
                    <div class="input-group">
                        <input type="password" name="old-password" id="old-password" class="form-control" placeholder="User password" aria-label="User password" aria-describedby="basic-addon2">
                        <a for="#old-password" type="button" class="input-group-text toggle-password">
                            <i class="bi bi-eye" style="display: none;"></i>
                            <i class="bi bi-eye-slash"></i>
                        </a>
                        <div class="invalid-feedback">
                            Password can't be empty
                        </div>
                    </div>
                    <label for="new-password" class="form-label mt-3">New Password</label>
                    <div class="input-group">
                        <input type="password" name="new-password" id="new-password" class="form-control" placeholder="User password" aria-label="User password" aria-describedby="basic-addon2">
                        <a for="#new-password" type="button" class="input-group-text toggle-password"><i class="bi bi-eye" style="display: none;"></i><i class="bi bi-eye-slash"></i></a>
                        <div class="invalid-feedback">
                            Password can't be empty
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                <a type="button" class="btn btn-primary" id="btn-change-password">Save</a>
            </div>
        </div>
    </div>
</div>