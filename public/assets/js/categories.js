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
                    subcategories_DT.ajax.reload();
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

var subcategories_DT = $('#subcategories-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: $('#subcategories-table').attr('data-route-get-subcategory'),
    dom: 'Brtip',
    info: true,
    fnCreatedRow: function (row, data, index) {
        $('td', row).eq(0).html(index + 1);
        $('td', row).parent().attr('data-index', data[0]).attr('data-ordering', data[4]);
    },
    columnDefs: [
        { orderable: false, targets: [0, 1, 2, 3, 4] },
        { visible: false, targets: 5 }
    ],
    order: [[5, 'asc']]
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



});
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
                    subcategories_DT.ajax.reload();
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
                    subcategories_DT.ajax.reload();
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


$(document).on('click', '#add_sub_category_btn', function (e) {
    e.preventDefault();
    var modal = $('body').find('div#subcategories-modal');
    var modal_title = 'Add Sub Category';
    var modal_btn_text = 'ADD';
    modal.find('.modal-title').html(modal_title);
    modal.find('.modal-footer .button_save').html(modal_btn_text);
    var select = modal.find('select[name="parent_cat"]');
    var url = $('#subcategories-table').attr('data-route');
    console.log(url);
    $.get(url, { parent_category_id: null }, function (response) {
        if (response.status === 1) {
            console.log('12321321');
            select.find('option').remove();
            select.html(response.data);
            modal.modal('show');

        } else {
            toastr.error(response.msg);
        }

    }, 'json');

})

$('#add_subcategories_form').on('submit', function (e) {
    e.preventDefault();
    var csrfName = $('.ci_csrf_data').attr('name');
    var csrfHash = $('.ci_csrf_data').val();
    var form = this;
    var formdata = new FormData(form);
    formdata.append(csrfName, csrfHash);
    var modal = $('body').find('div#subcategories-modal');

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

            //update csrf hash
            $('#ci_csrf_data').val(response.token);
            if ($.isEmptyObject(response.error)) {
                if (response.status === 1) {
                    $(form)[0].reset();
                    toastr.success(response.msg);
                    modal.modal('hide');
                    categories_DT.ajax.reload();
                    subcategories_DT.ajax.reload();
                } else {
                    toastr.error(response.msg);
                }
            } else {
                $.each(response.error, function (prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                })
            }
        }
    });
})

$(document).on('click', '.editSubCategoryBtn', function (e) {
    e.preventDefault();
    var modal = $('body').find('div#edit-subcategories-modal');
    var subcategory_id = $(this).attr('data-id');
    var modal_title = 'Edit Sub Category';
    var modal_btn_text = 'Save changes';
    var id = $(this).attr('data-id');
    modal.find('.modal-title').html(modal_title);
    modal.find('.modal-footer .button_save').html(modal_btn_text);
    var select = modal.find('select[name="parent_cat"]');
    var url = $('.editSubCategoryBtn').attr('data-route-get-subcategory');
    $.get(url, { sub_category_id: id }, function (response) {
        console.log(response);
        if (response.status === 1) {
            select.find('option').remove();
            select.html(response.data_category);
            $(modal).find('input[name="subcategory_id"]').val(subcategory_id);
            $(modal).find('input[name="subcategory_name"]').val(response.data_subcategory.name);
            $(modal).find('textarea[name="description"]').val(response.data_subcategory.description);
            modal.modal('show');

        } else {
            toastr.error(response.msg);
        }

    }, 'json');
})

$('#update_subcategories_form').on('submit', function (e) {
    e.preventDefault();
    var modal = $('body').find('div#edit-subcategories-modal');
    //csrf protection
    var csrfName = $(modal).find('.ci_csrf_data').attr('name');
    var csrfHash = $(modal).find('.ci_csrf_data').val();
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
            $('.ci_csrf_hash').val(response.token);
            if ($.isEmptyObject(response.error)) {
                if (response.status === 1) {
                    modal.modal('hide');
                    toastr.success(response.msg);
                    categories_DT.ajax.reload();
                    subcategories_DT.ajax.reload();
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

$('#subcategories-table').find('tbody').sortable({
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

        var url = $('#subcategories-table').attr('data-route-reorder');
        $.get(url, { positions }, function (response) {
            toastr.remove();
            if (response.status === 1) {
                categories_DT.ajax.reload();
                subcategories_DT.ajax.reload();
                toastr.success(response.msg);
            } else {
                toastr.error(response.msg);
            }
        }, 'json');
    }
})

$(document).on('click', '.deleteSubCategoryBtn', function (e) {
    e.preventDefault();
    var url = $(this).attr('data-route');
    var subcategory_id = $(this).attr('data-id');
    swal.fire({
        title: 'are you sure?',
        html: 'you want to delete this subcategory',
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
            $.get(url, { subcategory_id }, function (response) {
                if (response.status === 1) {
                    categories_DT.ajax.reload();
                    subcategories_DT.ajax.reload();
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);
                }
            })
        }
    });

})


// $(document)