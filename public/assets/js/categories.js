/*CI4Blog cdt*/
$(document).on('click', '#add_category_btn', function (e) {
    e.preventDefault();
    var modal = $('body').find('div#categories-modal');
    var modal_title = 'Add Category';
    var modal_btn_text = 'ADD';
    modal.find('.modal-title').html(modal_title);
    modal.find('.modal-footer .button_save').html(modal_btn_text);
    modal.modal('show');
});

$('#add_categories_form').on('submit', function (e) {
    e.preventDefault();
    //CSRF Hash 
    var csrfName = $('.ci_csrf_data').attr('name');
    var csrfHash = $('.ci_csrf_data').val();
    var form = this;
    var formdata = new FormData(form);
    formdata.append(csrfName, csrfHash);
    var modal = $('body').find('div#categories-modal');
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
            //update CSRF Hash
            $('.ci_csrf_data').val(response.token);
            if ($.isEmptyObject(response.error)) {
                if (response.status === 1) {
                    $(form)[0].reset();
                    modal.modal('hide');
                    categories_DT.ajax.reload();
                    toastr.success(response.msg)
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


//retrieve categories
var categories_DT = $('#categories-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: $('#categories-table').attr('data-route'),
    dom: 'Brtip',
    info: true,
    fnCreatedRow: function (row, data, index) {
        $('td', row).eq(0).html(index + 1);
        $('td', row).parent().attr('data-index', data[0]).attr('data-ordering', data[4]);
    },
    columnDefs: [
        { orderable: false, targets: [0, 1, 2, 3] },
        { visible: false, targets: 4 }
    ],
    order: [[4, 'asc']]
});


$(document).on('click', '.editCategoryBtn', function (e) {
    e.preventDefault();
    var category_id = $(this).attr('data-id');
    var url = $(this).attr('data-route');
    $.get(url, { category_id: category_id }, function (response) {
        var modal_title = 'Edit Category';
        var modal_btn_text = 'Save changes';
        var modal = $('body').find('div#edit-categories-modal');
        modal.find('form').find('input[type="hidden"][name="category_id"]').val(category_id);
        modal.find('.modal-title').html(modal_title);
        modal.find('.modal-footer .button_save').html(modal_btn_text);
        modal.find('input[type="text"]').val(response.data.name);
        modal.find('span.error-text').html("");
        modal.modal('show');
    }, 'json');


    $('#update_categories_form').on('submit', function (e) {
        e.preventDefault();

        // csrf 
        var csrfName = $('.ci_csrf_hash').attr('name');
        var csrfHash = $('.ci_csrf_hash').val();
        var modal = $('body').find('div#edit-categories-modal');
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
                $(form).find('span.text-error').text("");
            },
            success: function (response) {
                //update csrf
                $('.ci_csrf_hash').val(response.token);
                if ($.isEmptyObject(response.error)) {
                    if (response.status === 1) {
                        modal.modal('hide');
                        toastr.success(response.msg);
                        categories_DT.ajax.reload();
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
});

$(document).on("click", '.deleteCategoryBtn', function (e) {
    e.preventDefault();
    var url = $(this).attr('data-route');
    var category_id = $(this).attr('data-id');
    swal.fire({
        title: 'are you sure?',
        html: 'you want to delete this category',
        showCloseButton: true,
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        confirmButtonText: "Yes,delete",
        cancelButtonColor: "#D33",
        confirmButtonColor: "#3085d6",
        width: 300,
        allowOutsideClick: false
    }).then(function (result) {
        if (result.value) {
            $.get(url, { category_id: category_id }, function (response) {
                if (response.status === 1) {
                    categories_DT.ajax.reload();
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.smg);
                }
            })
        }
    });
})

$('#categories-table').find('tbody').sortable({
    update: function (event, ui) {
        $(this).children().each(function (index) {
            if ($(this).attr('data-ordering') !== (index + 1)) {
                $(this).attr('data-ordering', (index + 1)).addClass('updated');
            }
        });
        var positions = [];
        $('.updated').each(function () {
            positions.push([$(this).attr('data-index'), $(this).attr('data-ordering')]);
            $(this).removeClass('updated');
        })

        var url = $('#categories-table').attr('data-route-reorder');
        $.get(url, { positions }, function (response) {
            toastr.remove();
            if (response.status === 1) {
                categories_DT.ajax.reload();
                toastr.success(response.msg);
            } else {
                toastr.error(response.msg);
            }
        }, 'json');
    }
})

// $(document)