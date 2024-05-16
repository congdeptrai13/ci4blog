<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo">
                <a href="javascript:;"
                    onclick="event.preventDefault();document.getElementById('user_profile_file').click();"
                    class="edit-avatar"><i class="fa fa-pencil"></i></a>
                <input type="file" name="user_profile_file" id="user_profile_file" class="d-none">
                <img src="<?= get_user()->picture === null ? "/images/users/default-avatar.png" : '/images/users/' . get_user()->picture ?>"
                    alt="" class="avatar-photo ci-avatar-photo">
            </div>
            <h5 class="text-center h5 mb-0 ci-user-name"><?= get_user()->name ?></h5>
            <p class="text-center text-muted font-14">
                <?= get_user()->email ?>
            </p>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personal_details" role="tab">Personal
                                details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#change_password" role="tab">Change Password</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Timeline Tab start -->
                        <div class="tab-pane fade show active" id="personal_details" role="tabpanel">
                            <div class="pd-20">
                                <form action="<?= route_to('update-personal-details') ?>" method="post"
                                    id="personal_details_form">
                                    <?= csrf_field() ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Enter full name" value="<?= get_user()->name ?>">
                                                <span class="text-danger error-text name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" name="username"
                                                    placeholder="Enter username" value="<?= get_user()->username ?>">
                                                <span class="text-danger error-text username_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bio">Bio</label>
                                        <textarea name="bio" id="bio" cols="30" rows="10" class="form-control"
                                            placeholder="Bio...."><?= get_user()->bio ?></textarea>
                                        <span class="text-danger error-text bio_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Timeline Tab End -->
                        <!-- Tasks Tab start -->
                        <div class="tab-pane fade" id="change_password" role="tabpanel">
                            <div class="pd-20 profile-task-wrap">
                                <div class="container pd-0">
                                    <!-- Open Task start -->
                                    <div class="task-title row align-items-center">
                                        <div class="col-md-8 col-sm-12">
                                            <h5>Open Tasks (4 Left)</h5>
                                        </div>
                                        <div class="col-md-4 col-sm-12 text-right">
                                            <a href="task-add" data-toggle="modal" data-target="#task-add"
                                                class="bg-light-blue btn text-blue weight-500"><i
                                                    class="ion-plus-round"></i> Add</a>
                                        </div>
                                    </div>
                                    <div class="profile-task-list pb-30">
                                        <ul>
                                            <li>
                                                <div class="custom-control custom-checkbox mb-5">
                                                    <input type="checkbox" class="custom-control-input" id="task-1">
                                                    <label class="custom-control-label" for="task-1"></label>
                                                </div>
                                                <div class="task-type">Email</div>
                                                Lorem ipsum dolor sit amet, consectetur
                                                adipisicing elit. Id ea earum.
                                                <div class="task-assign">
                                                    Assigned to Ferdinand M.
                                                    <div class="due-date">
                                                        due date <span>22 February 2019</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-checkbox mb-5">
                                                    <input type="checkbox" class="custom-control-input" id="task-2">
                                                    <label class="custom-control-label" for="task-2"></label>
                                                </div>
                                                <div class="task-type">Email</div>
                                                Lorem ipsum dolor sit amet.
                                                <div class="task-assign">
                                                    Assigned to Ferdinand M.
                                                    <div class="due-date">
                                                        due date <span>22 February 2019</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-checkbox mb-5">
                                                    <input type="checkbox" class="custom-control-input" id="task-3">
                                                    <label class="custom-control-label" for="task-3"></label>
                                                </div>
                                                <div class="task-type">Email</div>
                                                Lorem ipsum dolor sit amet, consectetur
                                                adipisicing elit.
                                                <div class="task-assign">
                                                    Assigned to Ferdinand M.
                                                    <div class="due-date">
                                                        due date <span>22 February 2019</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-checkbox mb-5">
                                                    <input type="checkbox" class="custom-control-input" id="task-4">
                                                    <label class="custom-control-label" for="task-4"></label>
                                                </div>
                                                <div class="task-type">Email</div>
                                                Lorem ipsum dolor sit amet. Id ea earum.
                                                <div class="task-assign">
                                                    Assigned to Ferdinand M.
                                                    <div class="due-date">
                                                        due date <span>22 February 2019</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Open Task End -->
                                    <!-- Close Task start -->
                                    <div class="task-title row align-items-center">
                                        <div class="col-md-12 col-sm-12">
                                            <h5>Closed Tasks</h5>
                                        </div>
                                    </div>
                                    <div class="profile-task-list close-tasks">
                                        <ul>
                                            <li>
                                                <div class="custom-control custom-checkbox mb-5">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="task-close-1" checked="" disabled="">
                                                    <label class="custom-control-label" for="task-close-1"></label>
                                                </div>
                                                <div class="task-type">Email</div>
                                                Lorem ipsum dolor sit amet, consectetur
                                                adipisicing elit. Id ea earum.
                                                <div class="task-assign">
                                                    Assigned to Ferdinand M.
                                                    <div class="due-date">
                                                        due date <span>22 February 2018</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-checkbox mb-5">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="task-close-2" checked="" disabled="">
                                                    <label class="custom-control-label" for="task-close-2"></label>
                                                </div>
                                                <div class="task-type">Email</div>
                                                Lorem ipsum dolor sit amet.
                                                <div class="task-assign">
                                                    Assigned to Ferdinand M.
                                                    <div class="due-date">
                                                        due date <span>22 February 2018</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-checkbox mb-5">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="task-close-3" checked="" disabled="">
                                                    <label class="custom-control-label" for="task-close-3"></label>
                                                </div>
                                                <div class="task-type">Email</div>
                                                Lorem ipsum dolor sit amet, consectetur
                                                adipisicing elit.
                                                <div class="task-assign">
                                                    Assigned to Ferdinand M.
                                                    <div class="due-date">
                                                        due date <span>22 February 2018</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-checkbox mb-5">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="task-close-4" checked="" disabled="">
                                                    <label class="custom-control-label" for="task-close-4"></label>
                                                </div>
                                                <div class="task-type">Email</div>
                                                Lorem ipsum dolor sit amet. Id ea earum.
                                                <div class="task-assign">
                                                    Assigned to Ferdinand M.
                                                    <div class="due-date">
                                                        due date <span>22 February 2018</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Close Task start -->
                                    <!-- add task popup start -->
                                    <div class="modal fade customscroll mCustomScrollbar _mCS_4 mCS_no_scrollbar"
                                        id="task-add" tabindex="-1" role="dialog" style="">
                                        <div id="mCSB_4" class="mCustomScrollBox mCS-dark-2 mCSB_vertical mCSB_inside"
                                            style="max-height: none;" tabindex="0">
                                            <div id="mCSB_4_container"
                                                class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y"
                                                style="position:relative; top:0; left:0;" dir="ltr">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                Tasks Add
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close" data-toggle="tooltip"
                                                                data-placement="bottom" title=""
                                                                data-original-title="Close Modal">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body pd-0">
                                                            <div class="task-list-form">
                                                                <ul>
                                                                    <li>
                                                                        <form>
                                                                            <div class="form-group row">
                                                                                <label class="col-md-4">Task
                                                                                    Type</label>
                                                                                <div class="col-md-8">
                                                                                    <input type="text"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-md-4">Task
                                                                                    Message</label>
                                                                                <div class="col-md-8">
                                                                                    <textarea
                                                                                        class="form-control"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-md-4">Assigned
                                                                                    to</label>
                                                                                <div class="col-md-8">
                                                                                    <div
                                                                                        class="dropdown bootstrap-select show-tick form-control">
                                                                                        <select
                                                                                            class="selectpicker form-control"
                                                                                            data-style="btn-outline-primary"
                                                                                            title="Not Chosen"
                                                                                            multiple=""
                                                                                            data-selected-text-format="count"
                                                                                            data-count-selected-text="{0} people selected"
                                                                                            tabindex="-98">
                                                                                            <option>Ferdinand M.
                                                                                            </option>
                                                                                            <option>Don H. Rabon
                                                                                            </option>
                                                                                            <option>Ann P. Harris
                                                                                            </option>
                                                                                            <option>
                                                                                                Katie D. Verdin
                                                                                            </option>
                                                                                            <option>
                                                                                                Christopher S. Fulghum
                                                                                            </option>
                                                                                            <option>
                                                                                                Matthew C. Porter
                                                                                            </option>
                                                                                        </select><button type="button"
                                                                                            class="btn dropdown-toggle btn-outline-primary bs-placeholder"
                                                                                            data-toggle="dropdown"
                                                                                            role="combobox"
                                                                                            aria-owns="bs-select-1"
                                                                                            aria-haspopup="listbox"
                                                                                            aria-expanded="false"
                                                                                            title="Not Chosen">
                                                                                            <div class="filter-option">
                                                                                                <div
                                                                                                    class="filter-option-inner">
                                                                                                    <div
                                                                                                        class="filter-option-inner-inner">
                                                                                                        Not Chosen</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </button>
                                                                                        <div class="dropdown-menu ">
                                                                                            <div class="inner show"
                                                                                                role="listbox"
                                                                                                id="bs-select-1"
                                                                                                tabindex="-1"
                                                                                                aria-multiselectable="true">
                                                                                                <ul class="dropdown-menu inner show"
                                                                                                    role="presentation">
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-0">
                                                                                <label class="col-md-4">Due Date</label>
                                                                                <div class="col-md-8">
                                                                                    <input type="text"
                                                                                        class="form-control date-picker">
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" class="remove-task"
                                                                            data-toggle="tooltip"
                                                                            data-placement="bottom" title=""
                                                                            data-original-title="Remove Task"><i
                                                                                class="ion-minus-circled"></i></a>
                                                                        <form>
                                                                            <div class="form-group row">
                                                                                <label class="col-md-4">Task
                                                                                    Type</label>
                                                                                <div class="col-md-8">
                                                                                    <input type="text"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-md-4">Task
                                                                                    Message</label>
                                                                                <div class="col-md-8">
                                                                                    <textarea
                                                                                        class="form-control"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-md-4">Assigned
                                                                                    to</label>
                                                                                <div class="col-md-8">
                                                                                    <div
                                                                                        class="dropdown bootstrap-select show-tick form-control">
                                                                                        <select
                                                                                            class="selectpicker form-control"
                                                                                            data-style="btn-outline-primary"
                                                                                            title="Not Chosen"
                                                                                            multiple=""
                                                                                            data-selected-text-format="count"
                                                                                            data-count-selected-text="{0} people selected"
                                                                                            tabindex="-98">
                                                                                            <option>Ferdinand M.
                                                                                            </option>
                                                                                            <option>Don H. Rabon
                                                                                            </option>
                                                                                            <option>Ann P. Harris
                                                                                            </option>
                                                                                            <option>
                                                                                                Katie D. Verdin
                                                                                            </option>
                                                                                            <option>
                                                                                                Christopher S. Fulghum
                                                                                            </option>
                                                                                            <option>
                                                                                                Matthew C. Porter
                                                                                            </option>
                                                                                        </select><button type="button"
                                                                                            class="btn dropdown-toggle btn-outline-primary bs-placeholder"
                                                                                            data-toggle="dropdown"
                                                                                            role="combobox"
                                                                                            aria-owns="bs-select-2"
                                                                                            aria-haspopup="listbox"
                                                                                            aria-expanded="false"
                                                                                            title="Not Chosen">
                                                                                            <div class="filter-option">
                                                                                                <div
                                                                                                    class="filter-option-inner">
                                                                                                    <div
                                                                                                        class="filter-option-inner-inner">
                                                                                                        Not Chosen</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </button>
                                                                                        <div class="dropdown-menu ">
                                                                                            <div class="inner show"
                                                                                                role="listbox"
                                                                                                id="bs-select-2"
                                                                                                tabindex="-1"
                                                                                                aria-multiselectable="true">
                                                                                                <ul class="dropdown-menu inner show"
                                                                                                    role="presentation">
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row mb-0">
                                                                                <label class="col-md-4">Due Date</label>
                                                                                <div class="col-md-8">
                                                                                    <input type="text"
                                                                                        class="form-control date-picker">
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="add-more-task">
                                                                <a href="#" data-toggle="tooltip"
                                                                    data-placement="bottom" title=""
                                                                    data-original-title="Add Task"><i
                                                                        class="ion-plus-circled"></i> Add
                                                                    More Task</a>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary">
                                                                Add
                                                            </button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">
                                                                Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="mCSB_4_scrollbar_vertical"
                                                class="mCSB_scrollTools mCSB_4_scrollbar mCS-dark-2 mCSB_scrollTools_vertical mCSB_scrollTools_onDrag_expand"
                                                style="display: none;">
                                                <div class="mCSB_draggerContainer">
                                                    <div id="mCSB_4_dragger_vertical" class="mCSB_dragger"
                                                        style="position: absolute; min-height: 30px; top: 0px;">
                                                        <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                                                    </div>
                                                    <div class="mCSB_draggerRail"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- add task popup End -->
                                </div>
                            </div>
                        </div>
                        <!-- Tasks Tab End -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $('#personal_details_form').on('submit', function (e) {
        e.preventDefault();
        var form = this;
        var formdata = new FormData(form);

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
                if ($.isEmptyObject(response.error)) {
                    if (response.status === 1) {
                        $('.ci-user-name').each(function () {
                            $(this).html(response.user_info.name);
                        })
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                } else {
                    $.each(response.error, function (prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        })
    })

    $('#user_profile_file').ijaboCropTool({
        preview: '.ci-avatar-photo',
        setRatio: 1,
        allowedExtensions: ['jpg', 'jpeg', 'png'],
        buttonsText: ['CROP', 'QUIT'],
        buttonsColor: ['#30bf7d', '#ee5155', -15],
        processUrl: "<?= route_to('update-profile-picture') ?>",
        onSuccess: function (message, element, status) {
            if (status === 1) {
                toastr.success(message);
            } else {
                toastr.error(message);
            }
        },
        onError: function (message, element, status) {
            alert(message);
        }
    });
</script>
<?= $this->endSection() ?>