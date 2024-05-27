<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//will enable config for you access through uri matches with controller::method
// $routes->setAutoRoute('true');
$routes->get('/', 'BlogController::index');
$routes->get('post/(:segment)', 'BlogController::readPost/$1', ['as' => 'read-post']);

$routes->get('category/(:segment)', 'BlogController::categoryPost/$1', ['as' => 'category-post']);
$routes->get('tag/(:segment)', 'BlogController::tagPost/$1', ['as' => 'tag-post']);
$routes->get('search', 'BlogController::searchPost', ['as' => 'search-post']);
$routes->get('contact-us', 'BlogController::contactUs', ['as' => 'contact-us']);
$routes->post('contact-us', 'BlogController::contactUsForm', ['as' => 'contact-us-form']);



$routes->group('admin', static function ($routes) {
    $routes->group('', ['filter' => 'cifilter:auth'], static function ($routes) {
        // $routes->view('example-page', 'example-page');
        $routes->get('home', 'AdminController::index', ['as' => 'admin.home']);
        $routes->get('logout', 'AdminController::logoutHandler', ['as' => 'admin.logout']);
        $routes->get('profile', 'AdminController::profile', ['as' => 'admin.profile']);
        $routes->post('update-personal-details', 'AdminController::updatePersonalDetails', ['as' => 'update-personal-details']);
        $routes->post('update-profile-picture', 'AdminController::updateProfilePicture', ['as' => 'update-profile-picture']);
        $routes->post('change-password', 'AdminController::changePassword', ['as' => 'change-password']);
        $routes->get('settings', 'AdminController::settings', ['as' => 'settings']);
        $routes->post('update-general-settings', 'AdminController::updateGeneralSettings', ['as' => 'update-general-settings']);
        $routes->post('update-blog-logo', 'AdminController::updateBlogLogo', ['as' => 'update-blog-logo']);
        $routes->post('update-blog-favicon', 'AdminController::updateBlogFavicon', ['as' => 'update-blog-favicon']);
        $routes->post('update-social-media', 'AdminController::updateSocialMedia', ['as' => 'update-social-media']);
        $routes->get('categories', 'AdminController::categories', ['as' => 'categories']);
        $routes->post('add-categories', 'AdminController::addCategories', ['as' => 'add-categories']);
        $routes->get('get-categories', 'AdminController::getCategories', ['as' => 'get-categories']);
        $routes->get('get-category', 'AdminController::getCategory', ['as' => 'get-category']);
        $routes->post('update-categories', 'AdminController::updateCategories', ['as' => 'update-categories']);
        $routes->get('delete-category', 'AdminController::deleteCategory', ['as' => 'delete-category']);
        $routes->get('reorder-categories', 'AdminController::reorderCategories', ['as' => 'reorder-categories']);
        $routes->get('get-parent-categories', 'AdminController::getParentCategories', ['as' => 'get-parent-categories']);
        $routes->post('add-subcategory', 'AdminController::addSubCategory', ['as' => 'add-subcategory']);
        $routes->get('get-subcategories', 'AdminController::getSubCategories', ['as' => 'get-subcategories']);
        $routes->get('get-subcategory', 'AdminController::getSubCategory', ['as' => 'get-subcategory']);
        $routes->post('update-subcategory', 'AdminController::updateSubCategory', ['as' => 'update-subcategory']);
        $routes->get('reorder-subcategories', 'AdminController::reorderSubCategories', ['as' => 'reorder-subcategories']);
        $routes->get('delete-subcategory', 'AdminController::deleteSubCategory', ['as' => 'delete-subcategory']);

        $routes->group('posts', static function ($routes) {
            $routes->get('new-post', 'AdminController::addPost', ['as' => 'new-post']);
            $routes->post('create-post', 'AdminController::createPost', ['as' => 'create-post']);
            $routes->get('/', 'AdminController::allPosts', ['as' => 'all-posts']);
            $routes->get('get-posts', 'AdminController::getPosts', ['as' => 'get-posts']);
            $routes->get('edit-post/(:any)', 'AdminController::editPost/$1', ['as' => 'edit-post']);
            $routes->post('update-post', 'AdminController::updatePost', ['as' => 'update-post']);
            $routes->get('delete-post', 'AdminController::deletePost', ['as' => 'delete-post']);

        });
    });
    $routes->group('', ['filter' => 'cifilter:guest'], static function ($routes) {
        // $routes->view('example-auth', 'example-auth');
        $routes->get('login', 'AuthController::loginForm', ['as' => 'admin.login.form']);
        $routes->post('login', 'AuthController::loginHandler', ['as' => 'admin.login.handler']);
        $routes->get('forgot-password', 'AuthController::forgotForm', ['as' => 'admin.forgot.form']);
        $routes->post('send-password-reset-link', 'AuthController::sendPasswordResetLink', ['as' => 'send-password-reset-link']);
        $routes->get('password/reset/(:any)', 'AuthController::resetPassword/$1', ['as' => 'admin.reset-password']);
        $routes->post('reset-password-handler/(:any)', 'AuthController::resetPasswordHandler/$1', ['as' => 'reset-password-handler']);
    });
});