/*CI4Blog cdt*/

$(function () {
    let elfinderPath = '/extra-assets/elFinder/elfinder.src.php?integration=ckeditor&uid=' + $('#content').attr('user-id');
    CKEDITOR.replace('content', {
        filebrowserBrowseUrl: elfinderPath,
        filebrowserImageBrowseUrl: elfinderPath + '&type=image',
        removeDialogTabs: 'link:upload;image:upload'
    });
})
$('input[type="file"][name="featured_image"]').change(function () {
    var inputFile = $(this);
    var files = inputFile[0].files;
    if (files.length > 0) {
        var file = files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#post-featured-image-preview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(file);
    }
})

$('#addPostForm').on('submit', function (e) {
    e.preventDefault();
    let csrfName = $(this).find('.ci_csrf_data').attr('name');
    let csrfHash = $(this).find('.ci_csrf_data').val();
    let form = this;
    let formdata = new FormData(form);
    formdata.append(csrfName, csrfHash);
    let content = CKEDITOR.instances.content.getData();
    formdata.append('content', content);
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
            $(form).find('span.text-error').text('');
        },
        success: function (response) {
            if ($.isEmptyObject(response.error)) {
                //update csrf hash
                $(form).find('.ci_csrf_data').val(response.token);
                if (response.status === 1) {

                    $(form)[0].reset();
                    $('#post-featured-image-preview').attr('src', '').show();
                    $('input[name="tags"]').tagsinput('removeAll');
                    CKEDITOR.instances.content.setData("");
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