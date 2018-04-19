<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (! $this->user) {
            redirect('login');
        }
    }

    public function index()
    {
        $this->view_data['categories'] = Category::all();
        $this->content_view = 'category/view';
    }

    public function add()
    {
        date_default_timezone_set($this->setting->timezone);
        $date = date("Y-m-d H:i:s");
        $_POST['created_at'] = $date;
        $user = Category::create($_POST);
        redirect("categories", "refresh");
    }

    public function edit($id = FALSE)
    {
        if ($_POST) {
            $category = Category::find($id);
            $category->update_attributes($_POST);
            redirect("categories", "refresh");
        } else {
            $this->view_data['category'] = Category::find($id);
            $this->content_view = 'category/edit';
        }
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        redirect("categories", "refresh");
    }
}
