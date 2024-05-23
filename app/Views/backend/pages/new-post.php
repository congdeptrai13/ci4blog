<?php

use App\Libraries\CIAuth;

?>
<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Add Post</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Add Post
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <div class="dropdown">
                <a class="btn btn-primary" href="<?= route_to('all-posts') ?>">View Posts</a>
            </div>
        </div>
    </div>
</div>

<form action="<?= route_to('create-post') ?>" method="post" enctype="multipart/form-data" autocomplete="off"
    id="addPostForm">
    <div class="row">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
        <div class="col-md-9">
            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <div class="label"><b>Post Title</b></div>
                        <input type="text" name="title" class="form-control" id="" placeholder="enter post title">
                        <span class="text-danger text-error title_error"></span>
                    </div>
                    <div class="form-group">
                        <div class="label"><b>Content</b></div>
                        <textarea name="content" id="content" class="form-control" cols="30" rows="10"
                            placeholder="Type..." data-id="<?= CIAuth::id() ?>"></textarea>
                        <span class="text-danger text-error content_error"></span>
                    </div>
                </div>
            </div>

            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <div class="label"><b>Post meta keyword</b> <small>(Separated by comma)</small></div>
                        <input type="text" name="meta_keywords" class="form-control" id=""
                            placeholder="enter post meta keyword">
                        <span class="text-danger text-error meta_keywords_error"></span>
                    </div>
                    <div class="form-group">
                        <div class="label"><b>Post meta description</b></div>
                        <textarea name="meta_description" class="form-control" cols="30" rows="10"
                            placeholder="Type meta description..."></textarea>
                        <span class="text-danger text-error meta_description_error"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Post category</b></label>
                        <select name="category" class="custom-select form-control">
                            <option value="">Choose</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <span class="text-danger text-error category_error"></span>
                    </div>
                    <div class="form-group">
                        <div class="mb2 mt-1 form-group" style="max-width:100px">
                            <img src="" alt="" class="img-thumbnail" id="post-featured-image-preview">
                        </div>
                        <label for=""><b>Post Featured image</b></label>
                        <input type="file" name="featured_image" class="form-control-file form-control" id=""
                            height="auto">
                        <span class="text-danger text-error featured_image_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Tags</b></label>
                        <input type="text" class="form-control" placeholder="Enter Tags" name="tags"
                            data-role="tagsinput">
                        <span class="text-danger text-error tags_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Visibility</b></label>
                        <div class="custom-control custom-radio mb-5">
                            <input type="radio" name="visibility" id="customRadio1" class="custom-control-input"
                                value="1" checked>
                            <label for="customRadio1" class="custom-control-label">Public</label>
                        </div>
                        <div class="custom-control custom-radio mb-5">
                            <input type="radio" name="visibility" id="customRadio2" class="custom-control-input"
                                value="0">
                            <label for="customRadio2" class="custom-control-label">Private</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Create Post</button>
    </div>
</form>


<?= $this->endSection() ?>
<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="/backend/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="/backend/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="/extra-assets/ckeditor/ckeditor.js"></script>
<?= $loadJS ?>
<?= $this->endSection() ?>