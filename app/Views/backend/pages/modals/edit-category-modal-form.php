<div class="modal fade" id="edit-categories-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= route_to('update-categories') ?>" method="post" class="modal-content"
            id="update_categories_form">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Large modal
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="ci_csrf_data">
                <input type="hidden" name="category_id">
                <div class="form-group">
                    <label for=""><b>Category name</b></label>
                    <input type="text" class="form-control" name="category_name" placeholder="Enter category name">
                    <span class="text-danger error-text category_name_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary button_save">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</div>