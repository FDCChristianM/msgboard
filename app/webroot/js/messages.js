$(function () {
    generateMessages();

    $('#recepient').select2(
        {
            width: "100%",
            allowClear: true,
            placeholder: "Select Recipient",
            templateResult: formatOption,
            ajax: {
                url: base_url + "messages/getRecepient",
                dataType: "JSON",
                delay: 250,
                cache: true,
                data: function (data) {
                    return {
                        searchTerm: data.term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.result
                    };
                }
            }
        }
    );

    $(document).on('click', '.delete-msg-btn', function () {
        let id = $(this).attr('data-user')
        $(this).parents('.msg-con').fadeOut(400)

        let res = sendAjax(base_url + 'messages/deleteConvo', { id: id })
    })

    $(document).on('click', '#show-more-btn', function () {
        const offset = $(this).data('offset');
        const limit = 10;
        let res = sendAjax(base_url + 'messages/getMessages/' + offset + '/' + limit);
        if (res && res.messages) {
            const messageCon = $('.messages-con');
            let message = '';
            $.each(res.messages, function (index, value) {
                let sender = value.m.from_fk_user_id != value.u.user_id ? 'Me' : value.u.name;
                let photoSrc = value.u.photo ? base_url + 'profile_photos/' + value.u.photo : base_url + 'profile_photos/avatar.jpg';
                message += `<div class="col-md-12 mb-4 msg-con" data-user="${value.u.user_id}">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>${value.u.name}  <button type="button" class="btn btn-danger float-end delete-msg-btn" data-user="${value.u.user_id}">Delete</button></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                <img class="img-account-profile rounded-circle" src="${photoSrc}" style="max-width: 100%; width: 80px; height: 80px;">
                                            </div>
                                            <div class="col-md-10 d-flex justify-content-start align-items-center">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="message-history">
                                                                <p class="mb-0" style="font-size: 14px;"><strong>${sender}: </strong>${value.m.content}</p>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="message-date d-flex align-items-center justify-content-end">
                                                                <p class="mb-0" style="font-size: 10px;">${value.m.date_sent}</p>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
            });

            if (res.length > res.limit) {
                message += `<div class="col-md-12 d-flex justify-content-center">
                    <button id="show-more-btn" type="button" class="btn btn-primary" data-offset="${res.offset + res.limit}">Show More</button>
                </div>`;
            }

            $(this).remove()
            messageCon.append(message);

        }
    });
});
function generateMessages() {
    let res = sendAjax(base_url + 'messages/getMessages');

    const messageCon = $('.messages-con');
    let message = '';
    if (res && res.messages) {
        if (res.length > 0) {
            $.each(res.messages, function (index, value) {
                let sender = value.m.from_fk_user_id != value.u.user_id ? 'Me' : value.u.name;
                let photoSrc = value.u.photo ? base_url + 'profile_photos/' + value.u.photo : base_url + 'profile_photos/avatar.jpg';
                message += `<div class="col-md-12 mb-4 msg-con" data-user="${value.u.user_id}">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>${value.u.name}  <button type="button" class="btn btn-danger float-end delete-msg-btn" data-user="${value.u.user_id}">Delete</button></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                <img class="img-account-profile rounded-circle" src="${photoSrc}" style="max-width: 100%; width: 80px; height: 80px;">
                                            </div>
                                            <div class="col-md-10 d-flex justify-content-start align-items-center">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="message-history">
                                                                <p class="mb-0" style="font-size: 14px;"><strong>${sender}: </strong>${value.m.content}</p>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="message-date d-flex align-items-center justify-content-end">
                                                                <p class="mb-0" style="font-size: 10px;">${value.m.date_sent}</p>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
            });

            if (res.length > res.limit) {
                message += `<div class="col-md-12 d-flex justify-content-center">
                    <button id="show-more-btn" type="button" class="btn btn-primary" data-offset="${res.offset + res.limit}">Show More</button>
                </div>`;
            }

        }

    } else {
        message += `<div class="col-md-12 mb-4 msg-con d-flex justify-content-center align-items-center">
            <h3 class="mt-4">No message found.</h3>
        </div>`;
    }

    messageCon.html(message);
}

function formatOption(option) {
    if (!option.id) {
        return option.text;
    }

    var optionImage = option.image ? '<img class="option-image" src="' + option.image + '">' : '';
    var optionText = '<span class="option-text">' + option.text + '</span>';

    return optionImage + optionText;
}