<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Waiters extends MY_Controller
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
      $stores = Store::all();
      $strs = array();
      foreach ($stores as $store) {
         $strs[$store->id] = $store->name;
      }
      $this->view_data['stores'] = $stores;
      $this->view_data['strs'] = $strs;
        $this->view_data['waiters'] = Waiter::all();
        $this->content_view = 'waiter/view';
    }

    public function add()
    {
        date_default_timezone_set($this->setting->timezone);
        $date = date("Y-m-d H:i:s");
        $_POST['created_at'] = $date;
        $waiter = Waiter::create($_POST);
        redirect("waiters", "refresh");
    }

    public function edit($id = FALSE)
    {
        if ($_POST) {
            $waiter = Waiter::find($id);
            $waiter->update_attributes($_POST);
            redirect("waiters", "refresh");
        } else {
            $this->view_data['waiter'] = Waiter::find($id);
            $this->view_data['stores'] = Store::all();
            $this->content_view = 'waiter/edit';
        }
    }

    public function delete($id)
    {
        $waiter = Waiter::find($id);
        $waiter->delete();
        redirect("waiters", "refresh");
    }
}
