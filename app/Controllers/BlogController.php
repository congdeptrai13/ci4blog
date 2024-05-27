<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Post;
use App\Models\SubCategory;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class BlogController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions', 'text'];
    public function index()
    {
        //
        $data = [
            'pageTitle' => get_settings()->blog_title

        ];
        return view('frontend/pages/home', $data);
    }

    public function readPost($slug)
    {
        $post = new Post();
        $post_data = $post->asObject()->where('slug', $slug)->first();
        // dd($post_data);
        $data = [
            'pageTitle' => $post_data->title,
            'post' => $post_data
        ];
        return view('frontend/pages/single_post', $data);
    }

    public function categoryPost($slug)
    {
        $subCat = new SubCategory();
        $subCat_data = $subCat->asObject()->where('slug', $slug)->first();
        $post = new Post();
        $data = [];
        $data['pageTitle'] = 'Category: ' . $subCat_data->name;
        $data['page'] = (int) ($this->request->getGet('page') ?? 1);
        $data['perPage'] = 4;
        $data['total'] = count($post->asObject()->where('visibility', 1)->where('category_id', $subCat_data->id)->findAll());
        $data['post_data'] = $post->asObject()->where('visibility', 1)->where('category_id', $subCat_data->id)->paginate($data['perPage']);
        $data['pager'] = $post->where('visibility', 1)->where('category_id', $subCat_data->id)->pager;
        return view('frontend/pages/category', $data);
    }

    public function tagPost($tag)
    {
        $post = new Post();
        $data['pageTitle'] = 'Tag: ' . $tag;
        $data['page'] = (int) ($this->request->getGet('page') ?? 1);
        $data['perPage'] = 4;
        $data['total'] = count($post->asObject()->where('visibility', 1)->like('tags', $tag, 'both')->findAll());
        $data['post_data'] = $post->asObject()->where('visibility', 1)->like('tags', $tag, 'both')->paginate($data['perPage']);
        $data['pager'] = $post->where('visibility', 1)->like('tags', $tag, 'both')->pager;
        return view('frontend/pages/category', $data);
    }

    public function searchPost()
    {
        $request = Services::request();
        $q = $request->getVar('q') ?? "";
        $post = new Post();
        $post1 = new Post();
        if (empty($q)) {
            $data = [];
            $data['pageTitle'] = 'Search for: ' . $q;
            $data['page'] = (int) ($this->request->getGet('page') ?? 1);
            $data['perPage'] = 4;
            $data['total'] = count($post->asObject()->where('visibility', 1)->findAll());
            $data['post_data'] = $post->asObject()->where('visibility', 1)->paginate($data['perPage']);
            $data['pager'] = $post->where('visibility', 1)->pager;
        } else {
            $arrQuery = explode(" ", trim($q));
            $post_data = $this->handleSearch($post, $arrQuery);
            $post_count = $this->handleSearch($post1, $arrQuery);
            $data = [];
            $data['pageTitle'] = 'Search for: ' . $q;
            $data['page'] = (int) ($this->request->getGet('page') ?? 1);
            $data['perPage'] = 1;
            $data['post_data'] = $post_data->asObject()->where('visibility', 1)->paginate($data['perPage']);
            $data['total'] = count($post_count->asObject()->where('visibility', 1)->findAll());
            $data['pager'] = $post->where('visibility', 1)->pager;
        }

        return view('frontend/pages/search_posts', $data);

    }

    protected function handleSearch($object, $arrQuery)
    {
        $object->select("*");
        $object->groupStart();
        foreach ($arrQuery as $query) {
            $object->orLike('title', $query, 'both')->orLike('tags', $query, 'both');
        }
        return $object->groupEnd();
    }

    public function contactUs()
    {
        $data = [
            'pageTitle' => 'Contact Us',
            'validation' => null
        ];
        return view('frontend/pages/contact', $data);
    }

    public function contactUsForm()
    {
        $request = Services::request();
        $validation = Services::validation();
        $this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'name is required',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'email is required',
                    'valid_email' => 'Invalid email address'
                ]
            ],
            'subject' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'subject is required'
                ]
            ],
            'message' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'message is required'
                ]
            ]
        ]);
        if ($validation->run() === false) {
            $data = [
                'pageTitle' => 'Contact Us',
                'validation' => $this->validator
            ];
            return view('frontend/pages/contact', $data);
        } else {

            // send email notification
            $mail_body = "message from:<b>" . $request->getVar('email') . "</b> </br>";
            $mail_body .= "------------------------------------</br>";
            $mail_body .= $request->getVar('message');


            $mailConfig = array(
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_recipient_email' => get_settings()->blog_email,
                'mail_recipient_name' => get_settings()->blog_title,
                'mail_subject' => $request->getVar('subject'),
                'mail_body' => $mail_body
            );

            sendEmail($mailConfig);
            return redirect()->back()->with('success', 'Your message has been sent');
        }
    }
}
