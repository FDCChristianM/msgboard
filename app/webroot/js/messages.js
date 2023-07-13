$(function () {

    let userMsg = localStorage.getItem('message_key')

    if(action == 'listMessage'){
        generateMessages();
    }else if(action == 'viewMessage'){
        getMessageDetail()
    }else if(action != 'viewMessage'){
        localStorage.removeItem('message_key')
    }
    
    if(action == 'newMessage'){
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
    }

    function getMessageDetail() {
        let res = sendAjax(base_url + "messages/getMessageDetail", { id: userMsg });
    
        const messageCon = $('.convo-con');
        let message = messageCon.html(); // Store the existing messages
    
        if (res && res.messages) {
            if (res.length > 0) {
                $.each(res.messages, function (index, value) {
                    let sender = value.user != value.m.to_fk_user_id ? 'Me' : value.u.name;
                    let photoSrc = value.u.photo ? base_url + 'profile_photos/' + value.u.photo : base_url + 'profile_photos/avatar.jpg';
    
                    if (value.u.user_id == value.user) {
                        message += `<div class="col-md-12 mb-4 cv-con" data-user="${value.u.user_id}">
                            <div class="card">
                                <div class="card-header">
                                    <h6><button type="button" class="btn btn-danger float-start delete-this-msg-btn" data-msg="${value.m.message_id}">Delete</button><span class="float-end">${sender}</span></h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10 d-flex justify-content-start align-items-center">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="message-history">
                                                            <p class="mb-0" style="font-size: 14px;">${value.m.content}</p>
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
                                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                                            <img class="img-account-profile rounded-circle" src="${photoSrc}" style="max-width: 100%; width: 80px; height: 80px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    } else {
                        message += `<div class="col-md-12 mb-4 cv-con" data-user="${value.u.user_id}">
                            <div class="card">
                                <div class="card-header">
                                    <h6>${sender}</h6>
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
                                                            <p class="mb-0" style="font-size: 14px;">${value.m.content}</p>
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
                    }
                });
    
                if (res.length > res.limit) {
                    message += `<div class="col-md-12 d-flex justify-content-center">
                        <button id="show-more-btn-chat" type="button" class="btn btn-primary" data-offset="${parseInt(res.offset) + parseInt(res.limit)}">Show More</button>
                    </div>`;
                }
            }
        }
    
        messageCon.html(message);
    }
    
    $(document).on('click', '#show-more-btn-chat', function () {
        const offset = $(this).data('offset');
        const limit = 10;
        let res = sendAjax(base_url + 'messages/getMessageDetail/' + offset + '/' + limit, { id: userMsg });

        $(this).remove()
    
        const messageCon = $('.convo-con');
        let message = messageCon.html(); // Store the existing messages
    
        if (res && res.messages) {
            if (res.length > 0) {
                $.each(res.messages, function (index, value) {
                    let sender = value.user != value.m.to_fk_user_id ? 'Me' : value.u.name;
                    let photoSrc = value.u.photo ? base_url + 'profile_photos/' + value.u.photo : base_url + 'profile_photos/avatar.jpg';
    
                    if (value.u.user_id == value.user) {
                        message += `<div class="col-md-12 mb-4 cv-con" data-user="${value.u.user_id}">
                            <div class="card">
                                <div class="card-header">
                                    <h6><button type="button" class="btn btn-danger float-start delete-this-msg-btn" data-msg="${value.m.message_id}">Delete</button><span class="float-end">${sender}</span></h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10 d-flex justify-content-start align-items-center">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="message-history">
                                                            <p class="mb-0" style="font-size: 14px;">${value.m.content}</p>
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
                                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                                            <img class="img-account-profile rounded-circle" src="${photoSrc}" style="max-width: 100%; width: 80px; height: 80px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    } else {
                        message += `<div class="col-md-12 mb-4 cv-con" data-user="${value.u.user_id}">
                            <div class="card">
                                <div class="card-header">
                                    <h6>${sender}</h6>
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
                                                            <p class="mb-0" style="font-size: 14px;">${value.m.content}</p>
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
                    }
                });
            }
    
            if (parseInt(res.offset) + parseInt(res.limit) < res.length) {
                message += `<div class="col-md-12 d-flex justify-content-center">
                    <button id="show-more-btn-chat" type="button" class="btn btn-primary" data-offset="${parseInt(res.offset) + parseInt(res.limit)}">Show More</button>
                </div>`;
            }
    
            $(this).remove();
        }
    
        messageCon.html(message);
    });

    $(document).on('submit', '#replyForm', function(e){
        e.preventDefault()
        let recepient = userMsg

        let data = new FormData($(this)[0])
        data.append('recepient', recepient)

        const convo = $('.convo-con')
        let reply = $(this).find('textarea')

        let res = formAjax(base_url + 'messages/sendReply', data)
        if(res){
            reply.val('')
            convo.empty()
            getMessageDetail()
        }
    })
    

    $(document).on('click', '.delete-msg-btn', function () {
        let id = $(this).attr('data-user')
        $(this).parents('.col-md-12').fadeOut(400)

        let res = sendAjax(base_url + 'messages/deleteConvo', { id: id })
    })

    $(document).on('click', '.delete-this-msg-btn', function () {
        let id = $(this).attr('data-msg')
        $(this).parents('.col-md-12').fadeOut(400)

        let res = sendAjax(base_url + 'messages/deleteChat', { id: id })
    })

    $(document).on('submit', '#newMessageForm', function(e){
        e.preventDefault()

        const errorMessage = $('.error-message ul')
        let errorList = ''
        let data = $(this).serializeArray()

        let res = sendAjax(base_url + 'messages/sendMessage', data)

        if(res){
            if(res.status == 'error'){
                $.each(res.errors, function(field, messages) {
                    $.each(messages, function(index, message) {
                        errorList += '<li><p class="small fw-bold pt-1 mb-0">' + message + '</p></li>'
                    })
                })
                errorMessage.html(errorList)
            }else{
                window.location.href = base_url + 'messages/listMessage'
            }
        }else{
            errorMessage.html('<li><p class="small fw-bold pt-1 mb-0">Ooops! Something went wrong. Please try again later</p></li>')
        }
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
                message += `<div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>${value.u.name}  <button type="button" class="btn btn-danger float-end delete-msg-btn" data-user="${value.u.user_id}">Delete</button></h6>
                                    </div>
                                    <div class="card-body msg-con" data-user="${value.u.user_id}">
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

            if (parseInt(res.offset) + parseInt(res.limit)  < res.length) {
                message += `<div class="col-md-12 d-flex justify-content-center">
                    <button id="show-more-btn" type="button" class="btn btn-primary" data-offset="${parseInt(res.offset) + parseInt(res.limit)}">Show More</button>
                </div>`;
            }

            $(this).remove()
            messageCon.append(message);

        }
    });

    $(document).on('click', '.msg-con', function(){
        let user = $(this).attr('data-user')
        localStorage.setItem('message_key', user)
        window.location.href = base_url + 'messages/viewMessage'
    })
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
                message += `<div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>${value.u.name}  <button type="button" class="btn btn-danger float-end delete-msg-btn" data-user="${value.u.user_id}">Delete</button></h6>
                                    </div>
                                    <div class="card-body msg-con" data-user="${value.u.user_id}">
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
                    <button id="show-more-btn" type="button" class="btn btn-primary" data-offset="${parseInt(res.offset) + parseInt(res.limit)}">Show More</button>
                </div>`;
            }

        }

    } else {
        message += `<div class="col-md-12 mb-4 d-flex justify-content-center align-items-center">
            <h3 class="mt-4">No message found.</h3>
        </div>`;
    }

    messageCon.html(message);
}

function formatOption(option) {
    var imageUrl = option.image ? base_url + 'profile_photos/' + option.image : base_url + 'profile_photos/avatar.jpg';
    var optionImage = '<img class="option-image" style="width:20px; height:20px; margin-right: 5px;" src="' + imageUrl + '">';
    var optionText = '<span class="option-text" value="'+option.id+'">' + option.text + '</span>';

    return $(optionImage + optionText);
}

