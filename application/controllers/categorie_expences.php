<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categorie_expences extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('categorie_expence', 'Categorie_expence');
        if (! $this->user) {
            redirect('login');
        }
    }

    public function index()
    {
        $this->view_data['categories'] = Categorie_expence::all();
        $this->content_view = 'categorie_expence/view';
    }

    public function add()
    {
        Categorie_expence::create($_POST);
        redirect("categorie_expences", "refresh");
    }

    public function edit($id = FALSE)
    {
        if ($_POST) {
            $category = Categorie_expence::find($id);
            $category->update_attributes($_POST);
            redirect("categorie_expences", "refresh");
        } else {
            $this->view_data['category'] = Categorie_expence::find($id);
            $this->content_view = 'categorie_expence/edit';
        }
    }

    public function delete($id)
    {
        $category = Categorie_expence::find($id);
        $category->delete();
        redirect("categorie_expences", "refresh");
    }
}
