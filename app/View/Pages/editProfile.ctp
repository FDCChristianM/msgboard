<?php
App::uses('HtmlHelper', 'View/Helper');
?>
<div class="container-lg px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
    <h1 class="mb-4">UPDATE PROFILE</h1>
        <div class="col-xl-12">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <div class="error-message mb-5">
                        <ul class="text-danger">
                        </ul>
                    </div>
                    <form id="editProfileForm">
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-center align-items-center flex-column" id="profile-container">
                                <?php
                                if (!empty($user['Users']['photo'])) {
                                    $photoPath = '/profile_photos/' . $user['Users']['photo'];
                                    echo $this->Html->image($photoPath, array('alt' => 'Image', 'class' => 'img-account-profile rounded-circle mb-2', 'style' => 'max-width: 300px; min-height: 300px; min-width: 300px;'));
                                } else {
                                    echo $this->Html->image('/profile_photos/avatar.jpg', array('alt' => 'Image', 'class' => 'img-account-profile rounded-circle mb-2', 'style' => 'max-width: 300px; min-height: 300px; min-width: 300px;'));
                                }
                                ?>

                                <div class="mt-2">
                                    <label class="form-label" for="upload-profile"><strong>Upload Image</strong></label>
                                    <input type="file" name="upload-profile" id="upload-profile" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-outline form-floating mb-4">
                                    <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Enter Name" value="<?= $user['Users']['name']; ?>" />
                                    <label class="form-label" for="name">Name:</label>
                                </div>
                                <div class="form-outline form-floating mb-4">
                                    <input type="text" name="birthdate" id="birthdate" class="form-control form-control-lg" placeholder="Enter Name" value="<?= $user['Users']['birthdate']; ?>" />
                                    <label class="form-label" for="name">Birthdate:</label>
                                </div>
                                <div class="form-outline form-floating mb-4">
                                    <select class="form-select" name="gender" id="gender">
                                        <option <?= $user['Users']['gender'] == 0 ? 'selected' : ''; ?> value="" hidden>Please select a gender</option>
                                        <option <?= $user['Users']['gender'] == 1 ? 'selected' : ''; ?> value=1>Male</option>
                                        <option <?= $user['Users']['gender'] == 2 ? 'selected' : ''; ?> value=2>Female</option>
                                    </select>
                                    <label for="gender">Gender:</label>
                                </div>
                                <div class="form-floating">
                                    <textarea class="form-control" name="hubby" id="hubby" style="height: 100px"><?= !empty($user['Users']['hubby']) ? $user['Users']['hubby'] : 'Please set your hubby'; ?></textarea>
                                    <label for="hubby">Hubby</label>
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