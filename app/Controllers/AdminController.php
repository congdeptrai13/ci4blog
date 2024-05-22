<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Setting;
use App\Models\SocialMedia;
use App\Models\SubCategory;
use CodeIgniter\HTTP\ResponseInterface;

use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\User;
use Config\Services;
use Mberecall\CI_Slugify\SlugService;
use PSpell\Config;

use SSP;

class AdminController extends BaseController
{



    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions', 'CISiteSource'];
    protected $db;
    public function __construct()
    {
        require APPPATH . "/ThirdParty/ssp.php";
        $this->db = db_connect();
    }
    public function index()
    {
        //
        $data = [
            'pageTitle' => 'Dashboard',
            // 'loadJS' => $this->LoadJS('Dashboard')
        ];
        return view('backend/pages/home', $data);
    }

    // private function __construct()
    // {

    // }

    private function LoadJS($pageTitle)
    {
        return RunQueryJsCSSPage(array('/assets/js/' . strtolower($pageTitle) . '.js'), 'js');   /*Position Add Js*/
    }

    public function logoutHandler()
    {
        CIAuth::forget();
        return redirect('admin.login.form')->with('fail', 'You are logged out!');
    }

    public function profile()
    {
        $data = array(
            'pageTitle' => 'Profile',
            'loadJS' => $this->LoadJS('Profile')
        );
        return view('backend/pages/profile', $data);
    }

    public function updatePersonalDetails()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $user_id = CIAuth::id();

        if ($request->isAJAX()) {
            $this->validate([
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Full name is required'
                    ]
                ],
                'username' => [
                    'rules' => 'required|min_length[4]|is_unique[users.username,id,' . $user_id . ']',
                    'errors' => [
                        'required' => 'Username is required',
                        'min_length' => 'Username must have minimum of 4 characters',
                        'is_unique' => 'Username is already taken'
                    ]
                ]
            ]);
            if ($validation->run() === false) {
                $errors = $validation->getErrors();
                return json_encode(['status' => 0, 'error' => $errors]);
            } else {
                $user = new User();
                $update = $user->where('id', $user_id)->set([
                    'name' => $request->getVar('name'),
                    'username' => $request->getVar('username'),
                    'bio' => $request->getVar('bio')
                ])->update();
                if ($update) {
                    $user_info = $user->find($user_id);
                    return json_encode(['status' => 1, 'user_info' => $user_info, 'msg' => 'Your personal details have been successfully updated.']);
                } else {
                    return json_encode(['status' => 0, 'msg' => 'Something went wrong']);
                }
            }
        } else {
            return json_encode(['status' => 0, 'msg' => 'Something went wrong']);
        }
    }

    public function updateProfilePicture()
    {
        $request = Services::request();
        $user_id = CIAuth::id();
        $user = new User();
        $user_info = $user->asObject()->where('id', $user_id)->first();
        $path = 'images/users/';
        $file = $request->getFile('user_profile_file');
        $old_picture = $user_info->picture;
        $new_filename = 'UIMG_' . $user_id . $file->getRandomName();

        //normal ways
        // if ($file->move($path, $new_filename)) {
        //     if ($old_picture != null && file_exists($path . $old_picture)) {
        //         unlink($path . $old_picture);
        //     }
        //     $user->where('id', $user_info->id)
        //         ->set(['picture' => $new_filename])
        //         ->update();
        //     return json_encode(['status' => 1, 'msg' => 'Done!, Your Profile picture has been successfully updated']);
        // } else {
        //     return json_encode(['status' => 0, 'msg' => 'Something went wrong']);
        // }

        //image manipulation 
        $upload_image = Services::image()->withFile($file)->resize(450, 450, true, 'height')->save($path . $new_filename);
        if ($upload_image) {
            if ($old_picture !== null && file_exists($path . $new_filename)) {
                unlink($path . $old_picture);
            }
            $user->where('id', $user_info->id)->set(['picture' => $new_filename])->update();
            echo json_encode(['status' => 1, 'msg' => 'Done!, your profile picture has been successfully updated.']);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'Something went wrong!']);
        }
    }

    public function changePassword()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $validation = Services::validation();
            $user_id = CIAuth::id();
            $user = new User();
            $user_info = $user->asObject()->where('id', $user_id)->first();

            //validate the form
            $this->validate([
                'current_password' => [
                    'rules' => 'required|min_length[5]|check_current_password[current_password]',
                    'errors' => [
                        'required' => 'enter current password',
                        'min_length' => 'password must have atleast 5 characters',
                        'check_current_password' => 'the current password is incorrect'
                    ]
                ],
                'new_password' => [
                    'rules' => 'required|min_length[5]|max_length[20]|is_password_strong[new_password]',
                    'errors' => [
                        'required' => 'new password is required',
                        'min_length' => 'new password must have atleast 5 characters',
                        'max_length' => 'new password must not excess more than 20 characters',
                        'is_password_strong' => 'Password must contains atleast 1 uppercase, 1 lowercase, 1 number and 1 special character.'
                    ]
                ],
                'confirm_new_password' => [
                    'rules' => 'required|matches[new_password]',
                    'errors' => [
                        'required' => 'confirm new password',
                        'matches' => 'password missmatch'
                    ]
                ]
            ]);

            if ($validation->run() === false) {
                $errors = $validation->getErrors();
                return $this->response->setJSON([
                    'status' => 1,
                    'token' => csrf_hash(),
                    'error' => $errors
                ]);
            } else {

                //update user(admin) password in DB
                $user->where('id', $user_info->id)->set(['password' => Hash::make($request->getVar('new_password'))])->update();

                // send email notification to user(admin) email address 
                $mail_data = array(
                    'user' => $user_info,
                    'new_password' => $this->request->getVar('new_password')
                );

                $view = Services::renderer();
                $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/password-changed-email-template');

                $mailConfig = array(
                    'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                    'mail_from_name' => env('EMAIL_FROM_NAME'),
                    'mail_recipient_email' => $user_info->email,
                    'mail_recipient_name' => $user_info->name,
                    'mail_subject' => 'Password Changed',
                    'mail_body' => $mail_body
                );

                sendEmail($mailConfig);
                return $this->response->setJSON([
                    'status' => 1,
                    'token' => csrf_hash(),
                    'msg' => "Done! Your password has been successfully updated"
                ]);
            }
        }
    }

    public function settings()
    {
        $data = [
            'pageTitle' => 'Settings',
            'loadJS' => $this->LoadJS('Settings')
        ];
        return view('backend/pages/settings', $data);

    }

    public function updateGeneralSettings()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $validation = Services::validation();
            $this->validate([
                'blog_title' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "blog title is required"
                    ]
                ],
                'blog_email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Blog email is required',
                        'valid_email' => 'Invalid email address'
                    ]
                ]
            ]);

            if ($validation->run() === false) {
                $errors = $validation->getErrors();
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'error' => $errors
                ]);
            } else {
                $settings = new Setting();
                $setting_id = $settings->asObject()->first()->id;
                $update = $settings->where('id', $setting_id)->set([
                    'blog_title' => $request->getVar('blog_title'),
                    'blog_email' => $request->getVar('blog_email'),
                    'blog_phone' => $request->getVar('blog_phone'),
                    'blog_meta_keywords' => $request->getVar('blog_meta_keywords'),
                    'blog_meta_description' => $request->getVar('blog_meta_description'),
                ])->update();
                if ($update) {
                    return $this->response->setJSON([
                        'status' => 1,
                        'token' => csrf_hash(),
                        'msg' => 'General settings have been updated successfully.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'token' => csrf_hash(),
                        'msg' => 'something went wrong.'
                    ]);
                }

            }
        }
    }

    public function updateBlogLogo()
    {
        $request = Services::request();

        if ($request->isAJAX()) {
            $path = 'images/blogs/';
            $file = $request->getFile('blog_logo');
            $settings = new Setting();
            $setting_data = $settings->asObject()->first();
            $old_blog_logo = $setting_data->blog_logo;
            $new_filename = 'CI4blog_logo' . $file->getRandomName();
            if ($file->move($path, $new_filename)) {
                if ($old_blog_logo != null && file_exists($path . $old_blog_logo)) {
                    unlink($path . $old_blog_logo);
                }
            }

            $update = $settings->where('id', $setting_data->id)->set([
                'blog_logo' => $new_filename
            ])->update();

            if ($update) {
                return $this->response->setJSON([
                    'status' => 1,
                    'token' => csrf_hash(),
                    'msg' => 'Done!, CI4Blog logo has been successfully updated.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'msg' => 'Something went wrong.'
                ]);
            }

        } else {
            return $this->response->setJSON([
                'status' => 0,
                'token' => csrf_hash(),
                'msg' => 'Something went wrong on uploading new logo.'
            ]);
        }
    }

    public function updateBlogFavicon()
    {

        $request = Services::request();
        if ($request->isAJAX()) {
            $path = 'images/blogs/';
            $file = $request->getFile('blog_favicon');
            $settings = new Setting();
            $setting_data = $settings->asObject()->first();
            $old_blog_favicon = $setting_data->blog_favicon;
            $new_filename = 'CI4Blog_favicon' . $file->getRandomName();
            if ($file->move($path, $new_filename)) {
                if ($old_blog_favicon !== null && file_exists($path . $old_blog_favicon)) {
                    unlink($path . $old_blog_favicon);
                }
                $update = $settings->where('id', $setting_data->id)->set([
                    'blog_favicon' => $new_filename
                ])->update();
                if ($update) {
                    return $this->response->setJSON([
                        'status' => 1,
                        'token' => csrf_hash(),
                        'msg' => "Done!, CI4Blog favicon has been successfully updated."
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'token' => csrf_hash(),
                        'msg' => 'Something went wrong.'
                    ]);
                }
            }
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'token' => csrf_hash(),
                'msg' => 'Something went wrong on uploading new favicon'
            ]);
        }
    }

    public function updateSocialMedia()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $validation = Services::validation();
            $this->validate([
                'facebook_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Invalid Facebook page URL'
                    ]
                ],
                'twitter_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Invalid Twitter page URL'
                    ]
                ],
                'instagram_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Invalid Instagram page URL'
                    ]
                ],
                'youtube_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Invalid Youtube page URL'
                    ]
                ],
                'github_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Invalid Github page URL'
                    ]
                ],
                'linkedin_url' => [
                    'rules' => 'permit_empty|valid_url_strict',
                    'errors' => [
                        'valid_url_strict' => 'Invalid Linkedin page URL'
                    ]
                ],
            ]);

            if ($validation->run() === false) {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'error' => $validation->getErrors()
                ]);
            } else {

                $social_media = new SocialMedia();
                $social_media_id = $social_media->asObject()->first()->id;

                $update = $social_media->where('id', $social_media_id)->set([
                    'facebook_url' => $request->getVar('facebook_url'),
                    'twitter_url' => $request->getVar('twitter_url'),
                    'instagram_url' => $request->getVar('instagram_url'),
                    'youtube_url' => $request->getVar('youtube_url'),
                    'github_url' => $request->getVar('github_url'),
                    'linkedin_url' => $request->getVar('linkedin_url'),
                ])->update();

                if ($update) {
                    return $this->response->setJSON([
                        'status' => 1,
                        'token' => csrf_hash(),
                        'msg' => 'Done!, Blog social media have been successfully updated.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'token' => csrf_hash(),
                        'msg' => 'Something went wrong on updating blog social media'
                    ]);
                }


            }
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'token' => csrf_hash(),
                'msg' => "Something went wrong."
            ]);
        }
    }

    public function categories()
    {
        $data = [
            'pageTitle' => 'Categories',
            'loadJS' => $this->LoadJS('Categories')
        ];
        return view('backend/pages/categories', $data);
    }

    public function addCategories()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $validation = Services::validation();
            $this->validate([
                'category_name' => [
                    'rules' => 'required|is_unique[categories.name]',
                    'errors' => [
                        'required' => 'category name is required',
                        'is_unique' => 'Category name is already exists'
                    ]
                ]
            ]);
            if ($validation->run() === false) {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'error' => $validation->getErrors()
                ]);
            } else {
                $category = new Category();
                $save = $category->save(['name' => $request->getVar('category_name')]);
                if ($save) {
                    return $this->response->setJSON([
                        'status' => 1,
                        'token' => csrf_hash(),
                        'msg' => 'New category has been successfully added'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'token' => csrf_hash(),
                        'msg' => 'New category has been successfully added'
                    ]);
                }

            }
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'token' => csrf_hash(),
                'msg' => 'something went wrong'
            ]);
        }
    }

    public function getCategories()
    {
        // db details
        $dbDetails = array(
            'host' => $this->db->hostname,
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database
        );
        $table = 'categories';
        $primaryKey = 'id';
        $columns = array(
            array(
                'db' => 'id',
                'dt' => 0
            ),
            array(
                'db' => 'name',
                'dt' => 1
            ),
            array(
                'db' => 'id',
                'dt' => 2,
                'formatter' => function ($d, $row) {
                    $sub_category = new SubCategory();
                    $sub_category_data = $sub_category->where('parent_cat', $row['id'])->findAll();
                    return count($sub_category_data);
                }
            ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    return "
                    <div class='btn-group'>
                        <button class='btn btn-sm btn-link p-0 mx-1 editCategoryBtn' data-id='" . $row['id'] . "' data-route='" . route_to('get-category') . "'>Edit</button>
                        <button class='btn btn-sm btn-link p-0 mx-1 deleteCategoryBtn' data-id='" . $row['id'] . "' data-route='" . route_to('delete-category') . "'>Delete</button>
                    </div>
                    ";
                }
            ),
            array(
                'db' => 'ordering',
                'dt' => 4
            )
        );
        return json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }

    public function getCategory()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $id = $request->getVar('category_id');
            $category = new Category();
            $category_data = $category->find($id);
            return $this->response->setJSON(['data' => $category_data]);

        }
    }

    public function updateCategories()
    {
        $request = Services::request();

        if ($request->isAJAX()) {
            $id = $request->getVar('category_id');
            $validation = Services::validation();
            $this->validate([
                'category_name' => [
                    'rules' => 'required|is_unique[categories.name,id,' . $id . ']',
                    'errors' => [
                        'required' => 'Category name is required',
                        'is_unique' => 'Category name is already exists'
                    ]
                ]
            ]);
            if ($validation->run() === false) {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'error' => $validation->getErrors()
                ]);
            } else {
                $category = new Category();
                $update = $category->where('id', $id)->set([
                    'name' => $request->getVar('category_name')
                ])->update();
                if ($update) {
                    return $this->response->setJSON([
                        'status' => 1,
                        'token' => csrf_hash(),
                        'msg' => "Done!, update Category success"
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'token' => csrf_hash(),
                        'msg' => "something went wrong with update category"
                    ]);
                }
            }
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'token' => csrf_hash(),
                'msg' => "something went wrong"
            ]);
        }
    }

    public function deleteCategory()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $id = $request->getVar('category_id');
            $category = new Category();

            //check it's related sub category in fure video

            //check it's related posts through it's subcategories in future video

            //delete category 
            $delete = $category->where('id', $id)->delete();
            // $delete = $category->delete($id);

            if ($delete) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'category has been successfully deleted.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Something went wrong'
                ]);
            }
        }
    }

    public function reorderCategories()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $positions = $request->getVar('positions');
            $category = new Category();
            foreach ($positions as $position) {
                $index = $position[0];
                $newPosition = $position[1];
                $category->where('id', $index)->set(['ordering' => $newPosition])->update();
            }
            return $this->response->setJSON(['status' => 1, 'msg' => 'Categories ordering has been successfully updated']);
        }
    }


    public function getParentCategories()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $id = $request->getVar('parent_category_id');
            $option = '<option value="0">Uncategorized</option>';
            $category = new Category();
            $parent_categories = $category->findAll();
            if (count($parent_categories)) {
                foreach ($parent_categories as $parent_category) {
                    $isSelected = $parent_category['id'] == $id ? 'selected' : "";
                    $option .= '<option value="' . $parent_category['id'] . '" ' . $isSelected . '>' . $parent_category['name'] . '</option>';
                }
                return $this->response->setJSON([
                    'status' => 1,
                    'data' => $option
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 1,
                    'data' => $option
                ]);
            }
        } else {
            $this->response->setJSON([
                'status' => 0,
                'msg' => 'something went wrong'
            ]);
        }
    }

    public function addSubCategory()
    {
        $request = Services::request();

        if ($request->isAJAX()) {
            $validation = Services::validation();
            $this->validate([
                'subcategory_name' => [
                    'rules' => 'required|is_unique[sub_categories.name]',
                    'errors' => [
                        'required' => 'Sub Category is required',
                        'is_unique' => 'sub category name is already exists'
                    ]
                ]
            ]);
            if ($validation->run() === false) {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'error' => $validation->getErrors()
                ]);
            } else {
                $sub_category = new SubCategory();
                $save = $sub_category->save([
                    'name' => $request->getVar('subcategory_name'),
                    'slug' => SlugService::model(SubCategory::class)->make($request->getVar('subcategory_name')),
                    'parent_cat' => $request->getVar('parent_cat'),
                    'description' => $request->getVar('description')
                ]);
                if ($save) {
                    return $this->response->setJSON([
                        'status' => 1,
                        'token' => csrf_hash(),
                        'msg' => 'Done! create sub categories successfully'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'token' => csrf_hash(),
                        'msg' => 'something went wrong'
                    ]);
                }
            }
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'token' => csrf_hash(),
                'msg' => 'something went wrong'
            ]);
        }
    }

    public function getSubCategories()
    {
        $category = new Category();
        $subcategory = new SubCategory();
        // db details
        $dbDetails = array(
            'host' => $this->db->hostname,
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database
        );
        $table = 'sub_categories';
        $primaryKey = 'id';
        $columns = array(
            array(
                'db' => 'id',
                'dt' => 0
            ),
            array(
                'db' => 'name',
                'dt' => 1
            ),
            array(
                'db' => 'id',
                'dt' => 2,
                'formatter' => function ($d, $row) use ($category, $subcategory) {
                    $parent_cat_id = $subcategory->asObject()->where('id', $row['id'])->first()->parent_cat;
                    $parent_cat_name = " - ";
                    if ($parent_cat_id != 0) {
                        $parent_cat_name = $category->asObject()->where('id', $parent_cat_id)->first()->name;
                    }
                    return $parent_cat_name;
                }
            ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($d, $row) {
                    return "(x) will be added later";
                }
            ),
            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($d, $row) {
                    return "
                    <div class='btn-group'>
                        <button class='btn btn-sm btn-link p-0 mx-1 editSubCategoryBtn' data-id='" . $row['id'] . "' data-route-get-subcategory='" . route_to('get-subcategory') . "'>Edit</button>
                        <button class='btn btn-sm btn-link p-0 mx-1 deleteSubCategoryBtn' data-id='" . $row['id'] . "' data-route='" . route_to('delete-subcategory') . "'>Delete</button>
                    </div>
                    ";
                }
            ),
            array(
                'db' => 'ordering',
                'dt' => 5
            )
        );
        return json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }


    public function getSubCategory()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $id = $request->getVar('sub_category_id');
            $sub_category = new SubCategory();
            $sub_category_data = $sub_category->find($id);
            $option = '<option value="0">Uncategorized</option>';
            $category = new Category();
            $parent_categories = $category->findAll();
            if (count($parent_categories)) {
                foreach ($parent_categories as $parent_category) {
                    $isSelected = $parent_category['id'] == $sub_category_data['parent_cat'] ? 'selected' : "";
                    $option .= '<option value="' . $parent_category['id'] . '" ' . $isSelected . '>' . $parent_category['name'] . '</option>';
                }
                return $this->response->setJSON([
                    'status' => 1,
                    'data_category' => $option,
                    'data_subcategory' => $sub_category_data
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 1,
                    'data_category' => $option,
                    'data_subcategory' => $sub_category_data
                ]);
            }
        }
    }

    public function updateSubCategory()
    {
        $request = Services::request();

        if ($request->isAJAX()) {
            $id = $request->getVar('subcategory_id');
            $validation = Services::validation();
            $this->validate([
                'subcategory_name' => [
                    'rules' => 'required|is_unique[sub_categories.name,id,' . $id . ']',
                    'errors' => [
                        'required' => 'Sub Category name is required',
                        'is_unique' => 'Sub Category name is already exists'
                    ]
                ]
            ]);
            if ($validation->run() === false) {
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'error' => $validation->getErrors()
                ]);
            } else {
                $sub_category = new SubCategory();
                $update = $sub_category->where('id', $id)->set([
                    'name' => $request->getVar('subcategory_name'),
                    'parent_cat' => $request->getVar('parent_cat'),
                    'description' => $request->getVar('description'),
                    'slug' => SlugService::model(SubCategory::class)->sid($id)->make($request->getVar('subcategory_name'))
                ])->update();
                if ($update) {
                    return $this->response->setJSON([
                        'status' => 1,
                        'token' => csrf_hash(),
                        'msg' => "Done!, update Sub Category success"
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'token' => csrf_hash(),
                        'msg' => "something went wrong with update category"
                    ]);
                }
            }
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'token' => csrf_hash(),
                'msg' => "something went wrong"
            ]);
        }
    }

    public function reorderSubCategories()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $positions = $request->getVar('positions');
            $sub_category = new SubCategory();
            foreach ($positions as $position) {
                $index = $position[0];
                $newPosition = $position[1];
                $sub_category->where('id', $index)->set(['ordering' => $newPosition])->update();
            }
            return $this->response->setJSON(['status' => 1, 'msg' => 'Sub Categories ordering has been successfully updated']);
        }
    }

    public function deleteSubCategory()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $id = $request->getVar('subcategory_id');
            $sub_category = new SubCategory();

            //delete  subcategory 
            $delete = $sub_category->where('id', $id)->delete();

            if ($delete) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Subcategory has been successfully deleted.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Something went wrong'
                ]);
            }
        }
    }

    public function addPost()
    {
        $category = new Category();
        $data = [
            'pageTitle' => 'Add New Post',
            'loadJS' => $this->LoadJS('AddNewPost'),
            'categories' => $category->asObject()->findAll()
        ];
        return view('backend/pages/new-post', $data);
    }

}