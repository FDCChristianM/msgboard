function sendAjax(url, data ={}){
    $.ajax({
        method: 'POST',
        url: url,
        data: data,
        dataType: 'JSON',
        cache: false,
        async: false,
        success: function(response){
            res = response
        },
        error: function(error){
            res = error
        }
    })
    return res
}

function formAjax(url, data){
    var res = null
    $.ajax({
        method: 'post',
        data: data,
        url: url,
        dataType: 'json',
        async: false,
        cache: false,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        success: function(response){
            res = response
        },
        error: function(error){
            res = error
        }
    })

    return res
}