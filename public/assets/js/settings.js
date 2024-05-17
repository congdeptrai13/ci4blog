/*CI4Blog cdt*/

$('#general_settings_form').on('submit', function (e) {
    e.preventDefault();
    //CSRF HASH
    var csrfName = $('.ci_csrf_data').attr('name');
    var csrfHash = $('.ci_csrf_data').val();
    var form = this;
    var formdata = new FormData(form);
    formdata.append(csrfName, csrfHash);

    $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: formdata,
        processData: false,
        dataType: 'json',
        contentType: false,
        cache: false,
        beforeSend: function () {
            toastr.remove();
            $(form).find('span.error-text').text('');
        },
        success: function (response) {
            $('.ci_csrf_data').val(response.token);
            if ($.isEmptyObject(response.error)) {
                if (response.status === 1) {
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);

                }
            } else {
                $.each(response.error, function (prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                })
            }
        }
    })
})

$('input[type="file"][name="blog_logo"]').change(function () {
    var inputFile = $(this);
    var files = inputFile[0].files;
    if (files.length > 0) {
        var file = files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#logo-image-preview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(file);
    }
})
$('#change_blog_logo_form').on('submit', function (e) {
    e.preventDefault();
    var csrfName = $('.ci_csrf_data').attr('name');
    var csrfHash = $('.ci_csrf_data').val();
    var form = this;
    var formdata = new FormData(form);
    formdata.append(csrfName, csrfHash);
    var inputFile = $(form).find('input[type="file"][name="blog_logo"]').val();
    if (inputFile.length > 0) {
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formdata,
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function (response) {
                //update CSRF Hash
                $('.ci_csrf_data').val(response.token);
                if (response.status === 1) {
                    toastr.success(response.msg);
                    $(form)[0].reset();
                } else {
                    toastr.error(response.msg);
                }
            }
        })
    } else {
        $(form).find('span.error-text').text('Please, select logo image file. PNG file type is recommended');
    }
})


$('input[type="file"][name="blog_favicon"]').change(function () {
    var inputFile = $(this);
    var files = inputFile[0].files;
    if (files.length > 0) {
        var file = files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#favicon-image-preview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(file);
    }
})
$('#change_blog_favicon_form').on('submit', function (e) {
    e.preventDefault();
    var csrfName = $(this).find('.ci_csrf_data').attr('name');
    var csrfHash = $(this).find('.ci_csrf_data').val();
    var form = this;
    var formdata = new FormData(form);
    formdata.append(csrfName, csrfHash);

    var inputFile = $(form).find('input[type="file"][name="blog_favicon"]').val();
    if (inputFile.length > 0) {
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formdata,
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function (response) {
                //update CSRF Hash
                $('.ci_csrf_data').val(response.token);
                if (response.status === 1) {
                    toastr.success(response.msg);
                    $(form)[0].reset();
                } else {
                    toastr.error(response.msg);
                }
            }
        })
    } else {
        $(form).find('span.error-text').text('Please, select logo favicon file. PNG file type is recommended');
    }
})

$('#social-media-form').on('submit', function (e) {
    e.preventDefault();
    var csrfName = $(this).find('.ci_csrf_data').attr('name');
    var csrfHash = $(this).find('.ci_csrf_data').val();
    var form = this;
    var formdata = new FormData(form);
    formdata.append(csrfName, csrfHash);
    $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: formdata,
        processData: false,
        dataType: "json",
        contentType: false,
        cache: false,
        beforeSend: function () {
            toastr.remove();
            $(form).find('span.error-text').text('');
        },
        success: function (response) {
            //update csrf hash 
            $('.ci_csrf_data').val(response.token);
            if ($.isEmptyObject(response.error)) {
                if (response.status === 1) {
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);
                }
            } else {
                $.each(response.error, function (prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                })
            }

        }
    })
})