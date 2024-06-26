<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html">
            <img src="<?= get_settings()->blog_logo !== null ? '/images/blogs/' . get_settings()->blog_logo : "" ?>"
                alt="" class="dark-logo" />
            <img src="<?= get_settings()->blog_logo !== null ? '/images/blogs/' . get_settings()->blog_logo : "" ?>"
                alt="" class="light-logo" />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="<?= route_to('admin.home') ?>"
                        class="dropdown-toggle no-arrow <?= current_route_name() === 'admin.home' ? "active" : "" ?>">
                        <span class="micon dw dw-home"></span><span class="mtext">Home</span>
                    </a>
                </li>

                <li>
                    <a href="<?= route_to('categories') ?>"
                        class="dropdown-toggle no-arrow <?= current_route_name() === 'categories' ? "active" : "" ?>">
                        <span class="micon dw dw-list"></span><span class="mtext">Categories</span>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="javascript:;"
                        class="dropdown-toggle <?= current_route_name() === 'all-posts' ? "active" : "" ?> <?= current_route_name() === 'new-post' ? "active" : "" ?> <?= current_route_name() === 'edit-post' ? "active" : "" ?>">
                        <span class="micon bi bi-table"></span><span class="mtext">Posts</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= route_to('all-posts') ?>"
                                class="<?= current_route_name() === 'all-posts' ? "active" : "" ?>">All Posts</a></li>
                        <li><a href="<?= route_to('new-post') ?>"
                                class="<?= current_route_name() === 'new-post' ? "active" : "" ?>">Add new</a></li>
                    </ul>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="sidebar-small-cap">Settings</div>
                </li>
                <li>
                    <a href="<?= route_to('admin.profile') ?>" class="dropdown-toggle no-arrow <?= current_route_name() === 'admin.profile' ? "active" : "" ?> ">
                        <span class="micon dw dw-user"></span>
                        <span class="mtext">Profile
                        </span>
                    </a>
                </li>
                <li>
                    <a href="<?= route_to('settings') ?>" class="dropdown-toggle no-arrow <?= current_route_name() === 'settings' ? "active" : "" ?> ">
                        <span class="micon dw dw-settings"></span>
                        <span class="mtext">Settings
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>