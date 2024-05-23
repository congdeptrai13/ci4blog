<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Categories</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Categories
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card card-box">
            <div class="card-header">
                <div class="clearfix">
                    <div class="pull-left">
                        Categories
                    </div>
                    <div class="pull-right">
                        <a href="" role="button" id="add_category_btn" class="btn btn-default btn-sm p-0">
                            <i class="fa fa-plus-circle"></i> Add category
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless table-hover table-striped" id="categories-table"
                    data-route="<?= route_to('get-categories') ?>"
                    data-route-reorder="<?= route_to('reorder-categories') ?>">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category name</th>
                            <th scope="col">N. of sub Categories</th>
                            <th scope="col">Action</th>
                            <th scope="col">Ordering</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card card-box">
            <div class="card-header">
                <div class="clearfix">
                    <div class="pull-left">
                        Sub Categories
                    </div>
                    <div class="pull-right">
                        <a href="" role="button" id="add_sub_category_btn" class="btn btn-default btn-sm p-0">
                            <i class="fa fa-plus-circle"></i> Add Sub category
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless table-hover table-stripe" id="subcategories-table"
                    data-route="<?= route_to('get-parent-categories') ?>"
                    data-route-reorder="<?= route_to('reorder-subcategories') ?>"
                    data-route-get-subcategory="<?= route_to('get-subcategories') ?>">
                    <thead>
                        <tr>
                            <td scope="col">#</td>
                            <td scope="col">Sub Category name</td>
                            <td scope="col">Parent Category</td>
                            <td scope="col">N. of posts=(s)</td>
                            <td scope="col">Action</td>
                            <th scope="col">Ordering</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include ('modals/category-modal-form.php');
include ('modals/edit-category-modal-form.php');
include ('modals/subcategory-modal-form.php');
include ('modals/edit-subcategory-modal-form.php');
?>

<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.min.css">

<link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.min.css">
<link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.structure.min.css">
<link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.3/jquery-ui.theme.min.css">

<?= $this->endSection() ?>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>

<script src="/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
<script src="/extra-assets/jquery-ui-1.13.3/jquery-ui.min.js"></script>

<!-- <script src="/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script> -->
<?= $loadJS ?>
<?= $this->endSection() ?>