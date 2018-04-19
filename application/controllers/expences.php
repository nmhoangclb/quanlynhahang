<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expences extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Categorie_expence', 'Categorie_expence');
        if (! $this->user) {
            redirect('login');
        }
        $this->register = $this->session->userdata('register') ? $this->session->userdata('register') : FALSE;
    }

    public function index()
    {
        if ($this->register) {
            $Register = Register::find($this->register);
            $store = Store::find($Register->store_id);
            $this->view_data['storeName'] = $store->name;
            $this->view_data['storeId'] = $store->id;
        } else {
            $this->view_data['stores'] = Store::all();
        }
        $this->view_data['categories'] = Categorie_expence::all();
        $this->content_view = 'expence/view';
    }

    public function add()
    {
        $config['upload_path'] = './files/expences/';
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = FALSE;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx|zip';
        $config['max_size'] = '2048';

        $this->load->library('upload', $config);
        if ($this->upload->do_upload()) {
            $data = array(
                'upload_data' => $this->upload->data()
            );
            $attachment = $data['upload_data']['file_name'];
            $data = array(
                "date" => $this->input->post('date'),
                "reference" => $this->input->post('reference'),
                "category_id" => $this->input->post('category'),
                "store_id" => $this->input->post('store_id'),
                "amount" => $this->input->post('amount'),
                "note" => $this->input->post('note'),
                "attachment" => $attachment,
                "created_by" => $this->session->userdata('user_id')
            );
            $expence = Expence::create($data);
            redirect("expences", "refresh");
        } else {
            $data = array(
                "date" => $this->input->post('date'),
                "reference" => $this->input->post('reference'),
                "category_id" => $this->input->post('category'),
                "store_id" => $this->input->post('store_id'),
                "amount" => $this->input->post('amount'),
                "note" => $this->input->post('note'),
                "attachment" => "",
                "created_by" => $this->session->userdata('user_id')
            );
            $expence = Expence::create($data);
            redirect("expences", "refresh");
        }
    }

    public function edit($id = FALSE)
    {
        if ($_POST) {
            $expence = Expence::find($id);

            $config['upload_path'] = './files/expences/';
            $config['encrypt_name'] = TRUE;
            $config['overwrite'] = FALSE;
            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx|zip';
            $config['max_size'] = '2048';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload()) {
                $data = array(
                    'upload_data' => $this->upload->data()
                );
                $attachment = $data['upload_data']['file_name'];
                $data = array(
                    "date" => $this->input->post('date'),
                    "reference" => $this->input->post('reference'),
                    "category_id" => $this->input->post('category'),
                    "store_id" => $this->input->post('store_id'),
                    "amount" => $this->input->post('amount'),
                    "note" => $this->input->post('note'),
                    "attachment" => $attachment,
                    "created_by" => $this->session->userdata('user_id')
                );
                if ($expence->attachment !== '') {
                    unlink('./files/expences/' . $expence->attachment);
                }
                $expence->update_attributes($data);
                redirect("expences", "refresh");
            } else {
                $data = array(
                    "date" => $this->input->post('date'),
                    "reference" => $this->input->post('reference'),
                    "category_id" => $this->input->post('category'),
                    "store_id" => $this->input->post('store_id'),
                    "amount" => $this->input->post('amount'),
                    "note" => $this->input->post('note'),
                    "created_by" => $this->session->userdata('user_id')
                );
                $expence->update_attributes($data);
                redirect("expences", "refresh");
            }
        } else {

            $expence = Expence::find($id);

            $store = $expence->store_id == 0 ? FALSE : Store::find($expence->store_id);
            $this->view_data['storeName'] = $store ? $store->name : 'Store';
            $this->view_data['stores'] = Store::all();
            $this->view_data['categories'] = Categorie_expence::all();

            $this->view_data['expence'] = $expence;
            $this->content_view = 'expence/edit';
        }
    }
}
