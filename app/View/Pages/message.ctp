<?php
App::uses('HtmlHelper', 'View/Helper');
$joined = date("F j, Y g:ia", strtotime($user['Users']['date_created']));
$last_login = date("F j, Y g:ia", strtotime($user['Users']['last_login']));
?>
<div class="container-lg px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
    <h1 class="mb-4">MESSAGES</h1>
        <div class="col-xl-12">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Message List <a href="<?= $baseUrl . 'messages/newMessage'; ?>" type="button" class="btn btn-dark" style="float:right;">New Message</a></div>
                <div class="card-body">
                    <div class="row messages-con">
                    </div>
                </div>
            </div>
        </div>
    </div>