<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (! $this->user) {
            redirect('login');
        }
        if ($this->user->role !== "admin") {
            redirect('');
        }
    }

    public function index()
    {
      $this->view_data['warehouses'] = Warehouse::all();
        $this->view_data['Users'] = User::all();
        $this->view_data['stores'] = Store::all();
        $this->view_data['Timezones'] = $this->tz_list();
        $this->content_view = 'setting/setting';
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        unlink('./files/Avatars/' . $user->avatar);
        $user->delete();
        redirect("/settings?tab=users", "location");
    }

    public function addUser()
    {
        date_default_timezone_set($this->setting->timezone);
        $date = date("Y-m-d H:i:s");
        $config['upload_path'] = './files/Avatars/';
        $config['encrypt_name'] = TRUE;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_width'] = '1000';
        $config['max_height'] = '1000';

        $this->load->library('upload', $config);
        if ($this->upload->do_upload()) {
            $data = array(
                'upload_data' => $this->upload->data()
            );
            $image = $data['upload_data']['file_name'];
            $_POST['avatar'] = $image;
            $_POST['created_at'] = $date;
            unset($_POST['PasswordRepeat']);
            $user = User::create($_POST);
            redirect("/settings?tab=users", "location");
        } else {
            $_POST['created_at'] = $date;
            unset($_POST['PasswordRepeat']);
            $user = User::create($_POST);
            redirect("/settings?tab=users", "location");
        }
    }

    public function editUser($id = FALSE)
    {
        date_default_timezone_set($this->setting->timezone);
        $date = date("Y-m-d H:i:s");
        if ($_POST) {
            $config['upload_path'] = './files/Avatars/';
            $config['encrypt_name'] = TRUE;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_width'] = '1000';
            $config['max_height'] = '1000';

            $user = User::find($id);

            $this->load->library('upload', $config);
            if ($this->upload->do_upload()) {
                $data = array(
                    'upload_data' => $this->upload->data()
                );
                $image = $data['upload_data']['file_name'];
                unlink('./files/Avatars/' . $user->avatar);
                $_POST['avatar'] = $image;
                $_POST['created_at'] = $date;
                unset($_POST['PasswordRepeat']);
                if ($_POST['password'] === '')
                    unset($_POST['password']);
                $user->update_attributes($_POST);
                redirect("/settings?tab=users", "location");
            } else {
                $_POST['created_at'] = $date;
                unset($_POST['PasswordRepeat']);
                if ($_POST['password'] === '')
                    unset($_POST['password']);
                $user->update_attributes($_POST);
                redirect("/settings?tab=users", "location");
            }
        } else {
          $this->view_data['stores'] = Store::all();
            $this->view_data['user'] = User::find($id);
            $this->content_view = 'setting/modifyUser';
        }
    }

    // Settings
    public function updateSettings()
    {
        $config['upload_path'] = './files/Setting/';
        $config['encrypt_name'] = TRUE;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_width'] = '1000';
        $config['max_height'] = '1000';

        $setting = Setting::find(1);

        $this->load->library('upload', $config);
        if ($this->upload->do_upload()) {
            $data = array(
                'upload_data' => $this->upload->data()
            );
            $image = $data['upload_data']['file_name'];
            unlink('./files/Setting/' . $setting->logo);
            $_POST['logo'] = $image;
            $setting->update_attributes($_POST);
            redirect("/settings?tab=setting", "location");
        } else {
            $setting->update_attributes($_POST);
            redirect("/settings?tab=setting", "location");
        }
    }
}
