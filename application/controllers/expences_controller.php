<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expences_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('expence_model', 'expence');
        $this->load->model('categorie_expence', 'Categorie_expence');
        $this->user = $this->session->userdata('user_id') ? User::find_by_id($this->session->userdata('user_id')) : FALSE;
        $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
        $this->lang->load($lang, $lang);

        $this->setting = Setting::find(1);
    }

    public function ajax_list()
    {
      date_default_timezone_set($this->setting->timezone);
        $list = $this->expence->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $expence) {
            $no ++;
            $row = array();
            $row[] = $expence->date;
            $row[] = $expence->reference;
            $row[] = number_format((float)$expence->amount, $this->setting->decimals, '.', '');
            try{$category = Categorie_expence::find($expence->category_id)->name;}catch (\Exception $e){$category = "-";}
            $row[] = $category;
            try{$store = Store::find($expence->store_id)->name;}catch (\Exception $e){$store = "-";}
            $row[] = $store;
            try{$username = User::find($expence->created_by)->username;}catch (\Exception $e){$username = "-";}
            $row[] = $username;

            // add html for action
            if ($this->user->role === "admin")
                $row[] = '<div class="btn-group">
                      <a class="btn btn-default" href="javascript:void(0)" onclick="delete_expences(' . $expence->id . ')" title="' . label("Delete") . '"><i class="fa fa-times"></i></a>
                      <a class="btn btn-default" href="expences/edit/' . $expence->id . '" title="' . label("Edit") . '"><i class="fa fa-pencil"></i></a>
                      ' . ($expence->attachment ? '<a class="btn color02 white open-modalimage" target="_blank" href="' . site_url() . 'files/expences/' . $expence->attachment . '" title="' . label("ViewFile") . '"><i class="fa fa-file-archive-o"></i></a>' : '') . '
                    </div>';
            else
                $row[] = '<div class="btn-group"><a class="btn btn-default" href="expences/edit/' . $expence->id . '" title="' . label("Edit") . '"><i class="fa fa-pencil"></i></a>
                      ' . ($expence->attachment ? '<a class="btn color02 white open-modalimage" target="_blank" href="' . site_url() . 'files/expences/' . $expence->attachment . '" title="' . label("ViewFile") . '"><i class="fa fa-file-archive-o"></i></a>' : '') . '
                    </div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->expence->count_all(),
            "recordsFiltered" => $this->expence->count_filtered(),
            "data" => $data
        );
        // output to json format
        echo json_encode($output);
    }

    public function ajax_delete($id)
    {
        $expence = Expence::find($id);
        if ($expence->attachment !== '') {
            unlink('./files/expences/' . $expence->attachment);
        }
        $this->expence->delete_by_id($id);
        echo json_encode(array(
            "status" => TRUE
        ));
    }
}
