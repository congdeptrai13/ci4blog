/*CI4Blog cdt*/

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