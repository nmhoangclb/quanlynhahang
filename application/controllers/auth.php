<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    function login()
    {
        $this->layout_view = 'login';
        
        if ($_POST) {
            $user = User::validate_login($_POST['username'], $_POST['password']);
            
            if ($user) {
                
                redirect('');
            } else {
                $this->view_data['username'] = $_POST['username'];
                $this->view_data['message'] = $this->lang->line('login_incorrect');
            }
        }
    }

    function logout()
    {
        if (! $this->user) {
            redirect('login');
        } else {
            $update = User::find($this->user->id);
            $update->last_active = date("Y-m-d H:i:s");
            $update->save();
            
            User::logout();
            redirect('login');
        }
    }
}
