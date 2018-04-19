<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (! $this->user) {
            redirect('login');
        }
        $this->register = $this->session->userdata('register') ? $this->session->userdata('register') : FALSE;
        $this->store = $this->session->userdata('store') ? $this->session->userdata('store') : FALSE;
        $this->selectedTable = $this->session->userdata('selectedTable') ? $this->session->userdata('selectedTable') : FALSE;
    }

    public function index()
    {
      $products = Product::all();
      if($this->register){

         $this->view_data['header'] = $this->selectedTable ? ($this->selectedTable != '0h' ? label('Table').' - '.Table::find($this->selectedTable)->name : label("WalkinCustomer")) : label("WalkinCustomer");
         $tables = Table::find('all', array('conditions' => array('store_id = ?', $this->store)));
         $zones = Zone::find('all', array('conditions' => array('store_id = ?', $this->store)));
         $waiters = Waiter::find('all', array('conditions' => array('store_id = ?', $this->store)));
         $this->view_data['waiters'] = $waiters;
         $this->view_data['zones'] = $zones;
         $this->view_data['tables'] = $tables;
         $register = Register::find($this->register);
         foreach ($products as $product) {
            if($product->type == '0'){
               $stock = Stock::find('first', array('conditions' => array('store_id = ? AND product_id = ?', $register->store_id, $product->id)));
               $price = $stock ? ($stock->price > 0 ? $stock->price : $product->price) :$product->price;
               $product->price = $price;
            }
         }
      }
        date_default_timezone_set($this->setting->timezone);
        $this->view_data['customers'] = Customer::all();
        $this->view_data['products'] = $products;
        $this->view_data['categories'] = Category::all();
        $this->view_data['Stores'] = Store::all();
        if (! Posale::first()) {
            $hold = Hold::last();
            if ($hold)
                $hold->update_attributes(array(
                    'time' => date("H:i")
                ));
        }
        $this->content_view = 'pos';
    }

    public function change($type)
    {
        $this->session->set_userdata('lang', $type);
        $this->setting->language = $type;
        $this->setting->save();
        redirect("", "refresh");
    }
}
