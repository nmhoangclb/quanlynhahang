<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warehouses extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (! $this->user) {
            redirect('login');
        }
    }

    public function add()
    {
        date_default_timezone_set($this->setting->timezone);
        $date = date("Y-m-d H:i:s");
        $_POST['created_at'] = $date;
        $warehouse = Warehouse::create($_POST);
        redirect("/settings?tab=warehouses", "location");
    }

    public function edit($id = FALSE)
    {
        if ($_POST) {
            $warehouse = Warehouse::find($id);
            $warehouse->update_attributes($_POST);
            redirect("/settings?tab=warehouses", "location");
        } else {
            $this->view_data['warehouse'] = Warehouse::find($id);
            $this->content_view = 'setting/modifyWarehouse';
        }
    }

    public function delete($id)
    {
        $warehouse = Warehouse::find($id);
        $warehouse->delete();
        redirect("/settings?tab=warehouses", "location");
    }
}
