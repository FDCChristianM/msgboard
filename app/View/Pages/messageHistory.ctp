<?php
App::uses('HtmlHelper', 'View/Helper');
$joined = date("F j, Y g:ia", strtotime($user['Users']['date_created']));
$last_login = date("F j, Y g:ia", strtotime($user['Users']['last_login']));
?>
<div class="container-lg px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
        <h1 class="mb-4">MESSAGE DETAIL</h1>
        <div class="col-xl-12">
            <!-- Account details card-->
            <div class="card mb-5">
                <div class="card-body">
                    <div class="row mb-4">
                        <form id="replyForm">
                            <div class="form-floating">
                                <textarea class="form-control" name="content" id="content" style="height: 100px"></textarea>
                                <label for="content">Message</label>
                            </div>
                            <button type="submit" class="btn btn-dark mt-2 float-end">Send</button>
                        </form>
                    </div>
                    <div class="row convo-con">
                    </div>
                </div>
            </div>
        </div>
    </div>