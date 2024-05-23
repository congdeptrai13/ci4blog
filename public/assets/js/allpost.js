/*CI4Blog cdt*/
//retrieve categories
var posts_DT = $('#posts-table').DataTable({
    scrollCollapse: true,
    responsive: true,
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: $('#posts-table').attr('data-route'),
    dom: 'Brtip',
    info: true,
    fnCreatedRow: function (row, data, index) {
        $('td', row).eq(0).html(index + 1);
    },
    columnDefs: [
        { orderable: false, targets: [0, 1, 2, 3, 4, 5] },
        { visible: false, targets: 6 }
    ],
    order: [[6, 'asc']]
});


$(document).on('click', '.deletePostBtn', function () {
    let post_id = $(this).attr('data-id');
    var url = $(this).attr('data-route');
    swal.fire({
        title: 'are you sure?',
        html: 'you want to delete this post',
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
            $.get(url, { post_id }, function (response) {
                if (response.status === 1) {
                    posts_DT.ajax.reload();
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.smg);
                }
            })
        }
    });
})

