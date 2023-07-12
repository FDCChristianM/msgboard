<?php
App::uses('HtmlHelper', 'View/Helper');
?>
<div class="container-lg px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
        <h1 class="mb-4">MY ACCOUNT</h1>
        <div class="col-xl-12">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <div class="error-message mb-5">
                        <ul class="text-danger">
                        </ul>
                    </div>
                    <form id="editAccountForm">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-outline form-floating mb-4">
                                    <input type="hidden" name="own_email" id="own_email" value="<?= $user['Users']['email']; ?>" />
                                    <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Enter Email" value="<?= $user['Users']['email']; ?>" />
                                    <label class="form-label" for="email">Email:</label>
                                </div>
                                <div class="form-outline form-floating mb-4">
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Enter Password" />
                                    <label class="form-label" for="password">New Password:</label>
                                </div>
                                <div class="form-outline form-floating mb-4">
                                    <input type="password" name="cpwd" id="cpwd" class="form-control form-control-lg" placeholder="Confirm Password" />
                                    <label class="form-label" for="cpwd">Confirm Password:</label>
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-dark">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>