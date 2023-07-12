<?php
App::uses('HtmlHelper', 'View/Helper');
$joined = date("F j, Y g:ia", strtotime($user['Users']['date_created']));
$last_login = date("F j, Y g:ia", strtotime($user['Users']['last_login']));
?>
<div class="container-lg px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
    <h1 class="mb-4">MY PROFILE</h1>
        <div class="col-xl-12">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details <a href="<?= $baseUrl . 'users/editProfile'; ?>" type="button" class="btn btn-dark" style="float:right;">Edit Profile</a></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <?php
                            if (!empty($user['Users']['photo'])) {
                                $photoPath = '/profile_photos/' . $user['Users']['photo'];
                                echo $this->Html->image($photoPath, array('alt' => 'Image', 'class' => 'img-account-profile rounded-circle mb-2', 'style' => 'max-width: 300px; min-height: 300px; min-width: 300px;'));
                            } else {
                                echo $this->Html->image('/profile_photos/avatar.jpg', array('alt' => 'Image', 'class' => 'img-account-profile rounded-circle mb-2', 'style' => 'max-width: 300px; min-height: 300px; min-width: 300px;'));
                            }
                            ?>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Name:</strong> <?= $user['Users']['name']; ?></p>
                            <p><strong>Gender:</strong> <?= $user['Users']['gender'] == 0 ? 'Male' : 'Female'; ?></p>
                            <p><strong>Birthdate:</strong> <?= !empty($user['Users']['birthdate']) ? $user['Users']['birthdate'] : 'Please set your birthdate'; ?></p>
                            <p><strong>Joined:</strong> <?= $joined; ?></p>
                            <p><strong>Last Login:</strong> <?= $last_login; ?></p>
                            <p><strong>Hobby:</strong></p>
                            <p><?= !empty($user['Users']['hubby']) ? $user['Users']['hubby'] : 'Please set your hubby'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>