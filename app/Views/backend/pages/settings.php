<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Tabs</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        UI Tabs
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box">
    <h5 class="h4 text-blue mb-20">Customtab Tab</h5>
    <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#general_settings" role="tab"
                    aria-selected="true">General Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="false">Logo
                    favicon</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#social_media" role="tab" aria-selected="false">Social
                    media</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="general_settings" role="tabpanel">
                <div class="pd-20">
                    <form action="<?= route_to('update-general-settings') ?>" method="post" id="general_settings_form">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog title</label>
                                    <input type="text" name="blog_title" class="form-control"
                                        placeholder="enter blog title" value="<?= get_settings()->blog_title ?>">
                                    <span class="text-danger error-text blog_title_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog email</label>
                                    <input type="text" name="blog_email" class="form-control"
                                        placeholder="enter blog email" value="<?= get_settings()->blog_email ?>">
                                    <span class="text-danger error-text blog_email_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog phone no</label>
                                    <input type="text" name="blog_phone" class="form-control"
                                        placeholder="enter Blog phone no" value="<?= get_settings()->blog_phone ?>">
                                    <span class="text-danger error-text blog_phone_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog meta keywords</label>
                                    <input type="text" name="blog_meta_keywords" class="form-control"
                                        placeholder="enter Blog meta keywords"
                                        value="<?= get_settings()->blog_meta_keywords ?>">
                                    <span class="text-danger error-text blog_meta_keywords_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Blog meta description</label>
                                    <textarea cols="4" rows="3" name="blog_meta_description" class="form-control"
                                        placeholder="write blog meta description"
                                        value="<?= get_settings()->blog_meta_description ?>"></textarea>
                                    <span class="text-danger error-text blog_meta_description_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="logo_favicon" role="tabpanel">
                <div class="pd-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Set Blog Logo</h5>
                            <div class="mb2 mt-1 form-group" style="max-width: 200px;">
                                <img src="<?= get_settings()->blog_logo !== null ? '/images/blogs/' . get_settings()->blog_logo : "" ?>"
                                    alt="" class="img-thumbnail" id="logo-image-preview">
                            </div>
                            <form action="<?= route_to('update-blog-logo') ?>" method="post"
                                enctype="multipart/form-data" id="change_blog_logo_form">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"
                                    class="ci_csrf_data">
                                <div class="mb2 form-group">
                                    <input type="file" name="blog_logo" class="form-control" id="">
                                    <span class="text-danger error-text"></span>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Save Changes</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h5>Set Blog Favicon</h5>
                            <div class="mb2 mt-1 form-group" style="max-width:100px">
                                <img src="<?= get_settings()->blog_favicon !== null ? '/images/blogs/' . get_settings()->blog_favicon : "" ?>"
                                    alt="" class="img-thumbnail" id="favicon-image-preview">
                            </div>
                            <form action="<?= route_to('update-blog-favicon') ?>" method="post"
                                id="change_blog_favicon_form" enctype="multipart/form-data">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"
                                    class="ci_csrf_data">
                                <div class="mb2 form-group">
                                    <input type="file" name="blog_favicon" class="form-control" id="">
                                    <span class="text-danger error-text"></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="social_media" role="tabpanel">
                <div class="pd-20">
                    <form action="<?= route_to('update-social-media') ?>" method="post" id="social-media-form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Facebook URL</label>
                                    <input type="text" name="facebook_url" placeholder="Enter facebook page URL"
                                        class="form-control" value="<?= get_social_media()->facebook_url ?>">
                                    <span class="text-danger error-text facebook_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Twitter URL</label>
                                    <input type="text" name="twitter_url" placeholder="Enter Twitter URL"
                                        class="form-control" value="<?= get_social_media()->twitter_url ?>">
                                    <span class="text-danger error-text twitter_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Instagram URL</label>
                                    <input type="text" name="instagram_url" placeholder="Enter Instagram URL"
                                        class="form-control" value="<?= get_social_media()->instagram_url ?>">
                                    <span class="text-danger error-text instagram_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Youtube URL</label>
                                    <input type="text" name="youtube_url" placeholder="Enter Youtube channel URL"
                                        class="form-control" value="<?= get_social_media()->youtube_url ?>">
                                    <span class="text-danger error-text youtube_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Github URL</label>
                                    <input type="text" name="github_url" placeholder="Enter Github URL"
                                        class="form-control" value="<?= get_social_media()->github_url ?>">
                                    <span class="text-danger error-text github_url_error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">LinkedIn URL</label>
                                    <input type="text" name="linkedin_url" placeholder="Enter Linkedin URL"
                                        class="form-control" value="<?= get_social_media()->linkedin_url ?>">
                                    <span class="text-danger error-text linkedin_url_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
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
</script>
<?= $this->endSection() ?>