<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stores extends MY_Controller
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
      $this->view_data['Stores'] = Store::all();
      $this->content_view = 'stores/view';
  }

    public function add()
    {
        date_default_timezone_set($this->setting->timezone);
        $date = date("Y-m-d H:i:s");
        $_POST['created_at'] = $date;
        $store = Store::create($_POST);
        redirect("/stores", "location");
    }

    public function edit($id = FALSE)
    {
        if ($_POST) {
            $store = Store::find($id);
            $store->update_attributes($_POST);
            redirect("/stores", "location");
        } else {
            $this->view_data['store'] = Store::find($id);
            $this->content_view = 'stores/modifyStore';
        }
    }


    public function delete($id)
    {
        $store = Store::find($id);
        $store->delete();
        redirect("/stores", "location");
    }

    /**************************************************** table & zone functions ************************************************/

    public function editTables($id = FALSE)
    {
      $tables = Table::find('all', array('conditions'=> array('store_id = ?', $id)));
      $zones = Zone::find('all', array('conditions'=> array('store_id = ?', $id)));
      $zones02 = array();
      foreach ($zones as $zone) {
         $zones02[$zone->id] = $zone->name;
      }
      $this->view_data['storeid'] = $id;
      $this->view_data['tables'] = $tables;
      $this->view_data['zones'] = $zones;
      $this->view_data['zones02'] = $zones02;
      $this->content_view = 'stores/tables';
   }

   public function addTable()
   {
      $table = Table::create($_POST);
      redirect('stores/editTables/'.$_POST['store_id'], 'refresh');
   }

   public function addzone()
   {
      $zone = Zone::create($_POST);
      redirect('stores/editTables/'.$_POST['store_id'], 'refresh');
   }

   public function editzone()
   {
      $zone = Zone::find($_POST['zone_id']);
      $zone->name = $_POST['name'];
      $zone->save();

      redirect('stores/editTables/'.$_POST['store_id'], 'refresh');
   }

   public function deletetable($id, $storeid)
   {
      $table = Table::find($id);
      $table->delete();
      redirect('stores/editTables/'.$storeid, 'refresh');
   }

   public function deletezone($id)
   {
      $tables = Table::delete_all(array(
          'conditions' => array(
             'zone_id = ?',
             $id
          )
      ));
      $zone = Zone::find($id);
      $zone->delete();
      redirect('stores/editTables/'.$storeid, 'refresh');
   }

   public function editTable($id = FALSE)
   {
      if ($_POST) {
           $table = Table::find($id);
           $table->update_attributes($_POST);
           redirect("/stores/editTables/".$table->store_id, "location");
      } else {

         $table = Table::find($id);
         $zones = Zone::find('all', array('conditions'=> array('store_id = ?', $table->store_id)));
           $this->view_data['zones'] = $zones;
           $this->view_data['table'] = $table;
           $this->content_view = 'stores/editTable';
      }
   }
}
