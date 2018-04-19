<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suppliers extends MY_Controller
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
        $this->view_data['suppliers'] = Supplier::all();
        $this->content_view = 'supplier/view';
    }

    public function add()
    {
        date_default_timezone_set($this->setting->timezone);
        $date = date("Y-m-d H:i:s");
        $_POST['created_at'] = $date;
        $supplier = Supplier::create($_POST);
        redirect("suppliers", "refresh");
    }

    public function edit($id = FALSE)
    {
        if ($_POST) {
            $supplier = Supplier::find($id);
            $supplier->update_attributes($_POST);
            redirect("suppliers", "refresh");
        } else {
            $this->view_data['supplier'] = Supplier::find($id);
            $this->content_view = 'supplier/edit';
        }
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        redirect("suppliers", "refresh");
    }
}
