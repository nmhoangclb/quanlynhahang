<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kitchens extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (! $this->user) {
            redirect('login');
        }
        $this->register = $this->session->userdata('register') ? $this->session->userdata('register') : FALSE;
        $this->store = $this->session->userdata('store') ? $this->session->userdata('store') : FALSE;
    }

    public function index()
    {
      $tables = Table::find('all', array('conditions' => array('store_id = ?', $this->store)));
      $zones = Zone::find('all', array('conditions' => array('store_id = ?', $this->store)));
      foreach ($tables as $table) {
        if($table->status === 1){
          $hold = Hold::find('first', array('conditions' => array('register_id = ? AND table_id = ?', $this->register, $table->id)));
          if($hold){
            $posales = Posale::find('all', array('conditions' => array('number = ? AND register_id = ? AND table_id = ?', 1, $this->register, $table->id)));
            foreach ($posales as $posale) {
              $d1 = new DateTime($posale->time);
              $d2 = new DateTime($table->checked);
              if($d1 < $d2){
                $table->time = 'y';
              }else{
                $table->time = 'n';
                break;
              }
            }
          }
        }else{
          $table->time = 'y';
        }
    }
      $this->view_data['zones'] = $zones;
      $this->view_data['tables'] = $tables;
      $this->content_view = 'kitchen';
    }

}
