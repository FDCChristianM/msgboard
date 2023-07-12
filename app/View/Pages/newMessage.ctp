<?php
App::uses('HtmlHelper', 'View/Helper');
?>
<div class="container-lg px-4 mt-4">
    <hr class="mt-0 mb-4">
    <div class="row">
    <h1 class="mb-4">NEW MESSAGE</h1>
        <div class="col-xl-12">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="error-message mb-5">
                        <ul class="text-danger">
                        </ul>
                    </div>
                    <form id="newMessageForm">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-6">
                                <div class="form-outline mb-4">
                                    <label for="recepient" class="fw-bold mb-2">TO:</label>
                                    <select class="form-select" name="recepient" id="recepient">
                                        <!-- <option selected hidden>Please select a recepient</option> -->
                                    </select>
                             
                                </div>
                                <div class="form-floating">
                                    <textarea class="form-control" name="content" id="content" style="height: 200px"></textarea>
                                    <label for="content">MESSAGE:</label>
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-dark">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>