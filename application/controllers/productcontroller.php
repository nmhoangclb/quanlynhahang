<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Productcontroller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->user = $this->session->userdata('user_id') ? User::find_by_id($this->session->userdata('user_id')) : FALSE;
        $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
        $this->lang->load($lang, $lang);

        $this->setting = Setting::find(1);
    }


    public function add()
    {
      $warehouses = Warehouse::find('all');
      $stores = Store::find('all');
      $content = "";

      if($this->input->post('type') === '0'){
         $content .= '<div class="col-md-12"><table class="table table-striped"><thead><tr><th width="40%">'.label("Store").'</th><th width="30%">'.label("Quantity").'</th><th width="30%">'.label("price").'</th></tr></thead><tbody class="itemslist">';
         foreach ($stores as $store) {
            $content .= '<tr><td>'.$store->name.'</td><td><input type="number" id="quantity" store-id="'.$store->id.'" value="0"></td><td><input type="number" id="pricestr" store-id="'.$store->id.'" value="0"></td></tr>';
         }
         $content .= '  </tbody></table><script type="text/javascript"> $( "[id=\'quantity\']" ).on("change", function() { var storeID = $(this).attr("store-id"); quant.push({ "store_id": storeID, "quantity": $(this).val() }); console.log(quant); }); $( "[id=\'quantityw\']" ).on("change", function() { var warehouseID = $(this).attr("warehouse-id"); quantw.push({ "warehouse_id": warehouseID, "quantity": $(this).val() }); }); $( "[id=\'pricestr\']" ).on("change", function() { var storeID = $(this).attr("store-id"); pricestore.push({ "store_id": storeID, "price": $(this).val() }); });</script></div>';

         $content .= '<div class="col-md-12"><table class="table table-striped"><thead><tr><th width="40%">'.label("Warehouses").'</th><th width="30%">'.label("Quantity").'</th><th width="30%">'.label("price").'</th></tr></thead><tbody class="itemslist">';
         foreach ($warehouses as $warehouse) {
            $content .= '<tr><td>'.$warehouse->name.'</td><td><input type="number" id="quantityw" warehouse-id="'.$warehouse->id.'" value="0"></td><td><input type="number" id="price" value="" disabled="true"></td></tr>';
         }
         $content .= '  </tbody></table></div>';
      } elseif ($this->input->post('type') === '2') {
                  $content .= '<div><label for="add_item">'.label("AddProduct").'</label><input type="text" id="add_item" class="col-md-12"></div><div><label for="Comboprd">'.label("combination").'</label><table id="Comboprd" class="table items table-striped table-bordered table-condensed table-hover"><thead><tr><th class="col-xs-9">'.label("ProductName").'</th><th class="col-xs-2">'.label("Quantity").'</th><th class=" col-xs-1 text-center"><i class="fa fa-trash-o trash-opacity-50"></i></th></tr></thead><tbody></tbody></table></div>';
      }

        date_default_timezone_set($this->setting->timezone);
        $date = date("Y-m-d H:i:s");
        $config['upload_path'] = './files/products/';
        $config['encrypt_name'] = TRUE;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_width'] = '1000';
        $config['max_height'] = '1000';

        $this->load->library('upload', $config);
        $this->load->library('image_lib');
        if ($this->upload->do_upload()) {
            $data = array(
                'upload_data' => $this->upload->data()
            );
            $config2['image_library'] = 'gd2';
            $config2['source_image'] = $data['upload_data']['full_path'];
            $config2['create_thumb'] = TRUE;
            $config2['maintain_ratio'] = TRUE;
            $config2['width'] = 120;
            $config2['height'] = 120;

            $this->image_lib->clear();
            $this->image_lib->initialize($config2);
            $this->image_lib->resize();

            $image = $data['upload_data']['file_name'];
            $image_thumb = $data['upload_data']['raw_name'] . '_thumb' . $data['upload_data']['file_ext'];
            $data = array(
               "type" => $this->input->post('type'),
                "code" => $this->input->post('code'),
                "name" => $this->input->post('name'),
                "category" => $this->input->post('category'),
                "cost" => $this->input->post('cost'),
                "description" => $this->input->post('description'),
                "tax" => $this->input->post('tax'),
                "alertqt" => $this->input->post('alertqt'),
                "price" => $this->input->post('price'),
                "color" => $this->input->post('color'),
                "supplier" => $this->input->post('supplier'),
                "unit" => $this->input->post('unit'),
                "taxmethod" => $this->input->post('taxmethod'),
                "options" => $this->input->post('options'),
                "photo" => $image,
                "photothumb" => $image_thumb,
                "created_at" => $date,
                "modified_at" => $date
            );
            $product = Product::create($data);
            $content .= '<input type="hidden" id="prodctID" value="'.$product->id.'">';
            if($this->input->post('type') === '0')
               echo $content;
            elseif ($this->input->post('type') === '2')
               echo $content;
            else
               echo 'service';
               //redirect("products", "refresh");
        } else {
            $data = array(
               "type" => $this->input->post('type'),
                "code" => $this->input->post('code'),
                "name" => $this->input->post('name'),
                "category" => $this->input->post('category'),
                "description" => $this->input->post('description'),
                "alertqt" => $this->input->post('alertqt'),
                "cost" => $this->input->post('cost'),
                "tax" => $this->input->post('tax'),
                "price" => $this->input->post('price'),
                "color" => $this->input->post('color'),
                "supplier" => $this->input->post('supplier'),
                "unit" => $this->input->post('unit'),
                "taxmethod" => $this->input->post('taxmethod'),
                "options" => $this->input->post('options'),
                "photo" => "",
                "photothumb" => "",
                "created_at" => $date,
                "modified_at" => $date
            );
            $product = Product::create($data);
            $content .= '<input type="hidden" id="prodctID" value="'.$product->id.'">';
            if($this->input->post('type') === '0')
               echo $content;
            elseif ($this->input->post('type') === '2')
               echo $content;
            else
               echo 'service';
            //redirect("products", "refresh");
        }
    }


    public function modifystock($id)
    {
      $warehouses = Warehouse::find('all');
      $stores = Store::find('all');

      $content = '<div class="col-md-12"><table class="table table-striped"><thead><tr><th width="40%">'.label("Store").'</th><th width="30%">'.label("Quantity").'</th><th width="30%">'.label("price").'</th></tr></thead><tbody class="itemslist">';
           foreach ($stores as $store) {
             $stock = Stock::find('first', array('conditions' => array('store_id = ? AND product_id = ?', $store->id, $id)));
             $quantity = $stock ? $stock->quantity : '0';
             $price = $stock ? ($stock->price ? $stock->price : '0') : '0';
               $content .= '<tr><td>'.$store->name.'</td><td><input type="number" id="quantity" store-id="'.$store->id.'" value="'.$quantity.'"></td><td><input type="number" id="pricestr" store-id="'.$store->id.'" value="'.$price.'"></td></tr>';
           }
        $content .= '  </tbody>
       </table></div>';

      $content .= '<div class="col-md-12"><table class="table table-striped"><thead><tr><th width="40%">'.label("Warehouses").'</th><th width="30%">'.label("Quantity").'</th><th width="30%">'.label("price").'</th></tr></thead><tbody class="itemslist">';
            foreach ($warehouses as $warehouse) {
               $stock = Stock::find('first', array('conditions' => array('warehouse_id = ? AND product_id = ?', $warehouse->id, $id)));
               $quantity = $stock ? $stock->quantity : '0';
                $content .= '<tr><td>'.$warehouse->name.'</td><td><input type="number" id="quantityw" warehouse-id="'.$warehouse->id.'" value="'.$quantity.'"></td><td><input type="number" id="pricew" value="" disabled="true"></td></tr>';
            }
         $content .= '  </tbody>
        </table></div>';
        $content .= '<input type="hidden" id="prodctID" value="'.$id.'">';
        echo $content;
    }

    public function Viewproduct($id)
    {
      $warehouses = Warehouse::find('all');
      $stores = Store::find('all');
      $product = Product::find($id);

      if($product->photo)
         $photo = '<img class="media-object img-rounded" src="'.base_url().'files/products/'.$product->photo.'" alt="image" width="200px">';
      else
         $photo = '<img class="media-object img-rounded" src="http://dummyimage.com/200x200/e3e0e3/fff" alt="image" width="200px">';
      $content = '<div class="col-md-6"><div class="media"><div class="media-left">'.$photo.'</div><div class="media-body"><h1 class="media-heading">'.$product->name.'</h1><b>'.label("Category").' :</b> '.$product->category.' <br><b>'.label("Cost").' :</b> '.$product->cost.' '.$this->setting->currency.'<br><b>'.label("ProductTax").' :</b> '.$product->tax.' <br><b>'.label("Price").' :</b> '.$product->price.' '.$this->setting->currency.' <br><b>'.label("Suppliers").' :</b> '.$product->supplier.' <br><b>'.label("ProductDescription").' :</b> '.$product->description.'</div></div></div><div class="col-md-6"><table class="table"><thead><tr><th width="40%">'.label("Store").'</th><th width="20%">'.label("Quantity").'</th><th width="20%">'.label("price").'</th><th width="20%"><i class="fa fa-eye" aria-hidden="true"></i></th></tr></thead><tbody class="itemslist">';
       foreach ($stores as $store) {
          if($product->type == '0'){
             $stock = Stock::find('first', array('conditions' => array('store_id = ? AND product_id = ?', $store->id, $id)));
             $quantity = $stock ? $stock->quantity : '0';
             $price = $stock ? ($stock->price ? $stock->price.' '.$this->setting->currency : '0'.' '.$this->setting->currency) : '0'.' '.$this->setting->currency;
          }else {
             $quantity = '-';
             $price = '-';
          }
          /************************************************* store visibility value ***************************************************************/
            $cheked = 'checked';
            $invis = $product->h_stores;
            $invis = trim($invis, ",");
            $array = explode(',', $invis); //split string into array seperated by ', '
            foreach($array as $value) //loop over values
            {
               $cheked = $value == $store->id ? '' : $cheked;
            }
            $content .= '<tr>
             <td>'.$store->name.'</td>
             <td><b>'.$quantity.'</b></td>
             <td><b>'.$price.'</b></td>
             <td><label>
             <input type="checkbox" name="invis" value="1" '.$cheked.' onclick="makePrdInvis('.$store->id.', '.$product->id.')">
             <span class="label-text"></span>
             </label></td>
          </tr>';
       }
       $content .= '  </tbody>
      </table>

      <table class="table">
          <thead>
             <tr>
                <th width="40%">'.label("Store").'</th>
                <th width="20%">'.label("Quantity").'</th>
                <th width="20%">'.label("price").'</th>
                <th width="20%"><i class="fa fa-eye" aria-hidden="true"></i></th>
             </tr>
          </thead>
          <tbody class="itemslist">';
       foreach ($warehouses as $warehouse) {
          if($product->type == '0'){
             $stock = Stock::find('first', array('conditions' => array('warehouse_id = ? AND product_id = ?', $warehouse->id, $id)));
             $quantity = $stock ? $stock->quantity : '0';
          }else {
             $quantity = '-';
          }
           $content .= '<tr>
             <td>'.$warehouse->name.'</td>
             <td><b>'.$quantity.'</b></td>
             <td><b>-</b></td>
             <td><b>-</b></td>
          </tr>';
       }
       $content .= '  </tbody>
      </table></div>';
      if ($product->type == 2) {
         $combos = Combo_item::find('all', array('conditions' => array('product_id = ?', $id)));
         $content .= '<div class="row"><div class="col-md-12"><h1>'.label("combinations").'</h1></div><div class="col-md-12"><table class="table">
             <thead>
                <tr>
                   <th class="col-xs-9">'.label("ProductName").'</th>
                   <th class="col-xs-2">'.label("Quantity").'</th>
                </tr>
             </thead>
             <tbody>';
             foreach ($combos as $combo) {
                $prod = product::find($combo->item_id);
                $content .= '<tr>
                  <td><a href="javascript:void(0)" onclick="Viewproduct('.$combo->item_id.')">'.$prod->name.' ('. $prod->code .')</a></td>
                  <td><b>'.$combo->quantity.'</b></td>
               </tr>';
             }
             $content .= '  </tbody>
           </table></div></div><button type="submit" class="btn btn-add col-md-12" style="margin-bottom:0" onclick="modifycombo('.$id.')">'.label("Modify").'</button>';
      }
      echo $content;

   }

   function GenerateBarcode($code = NULL, $bcs = 'code128', $height = 60, $width = 1)
   {
      $this->load->library('zend');
      $this->zend->load('Zend/Barcode');
      $barcodeOptions = array(
           'text' => $code,
           'barHeight' => $height,
           'barThinWidth' => $width
      );
      $rendererOptions = array(
           'imageType' => 'png',
           'horizontalPosition' => 'center',
           'verticalPosition' => 'middle'
      );
      $imageResource = Zend_Barcode::render($bcs, 'image', $barcodeOptions, $rendererOptions);
      return $imageResource;
   }

   public function barcode($row, $num, $productBcode)
   {
      $content = "";
      $bcs = 'code128';
      $height = 30;
      $width = 2;
      for ($i=0; $i < $num; $i++) {
         $content .= '<div class="col-md-'.$row.'"><img style="margin-top:30px" src="' . site_url('productcontroller/GenerateBarcode/' . sprintf("%05d", $productBcode) . '/' . $bcs . '/' . $height . '/' . $width) . '" alt="'.$productBcode.'" /></div>';
      }

      echo $content;
   }

   /****************************************** combo functions *****************************************/

   public function getProductNames($term) {
      $prd = Product::find('all', array('select' => 'name'), array('conditions' => "(name LIKE '%" . $term . "%'  OR code LIKE '%" . $term . "%') AND type != 2"));
      if ($prd) {
           return $prd;
      }
      return FALSE;
   }

   public function suggest()
   {
        $term = $this->input->get('term', TRUE);

        $rows = $this->getProductNames($term);
        if ($rows) {
            foreach ($rows as $row) {
               $pr[] = array('id' => $row->id, 'label' => $row->name, 'name' => $row->name, 'code' => $row->code, 'cost' => $row->cost);
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array('id' => 0, 'label' => label('NoProduct')));
        }
    }

    public function addcombo()
    {
      $items = $this->input->post('items');
      $productID = $this->input->post('productID');
      if ($items) {
         $combos = Combo_item::delete_all(array(
            'conditions' => array(
                'product_id = ?',
                $productID
            )
        ));
         foreach ($items as $item) {
            $item['product_id'] = $productID;
            unset($item['code']);
            unset($item['name']);
            Combo_item::create($item);
         }
      }
   }

   public function modifycombo($id)
   {
      $combos = Combo_item::find('all', array('conditions' => array('product_id = ?', $id)));

      $content = '<div><label for="add_item">'.label("AddProduct").'</label><input type="text" id="add_item" class="col-md-12"></div>
         <div>
         <label for="Comboprd">'.label("combination").'</label>
         <table id="Comboprd" class="table items table-striped table-bordered table-condensed table-hover">
         <thead>
         <tr>
         <th class="col-xs-9">'.label("ProductName").'</th>
         <th class="col-xs-2">'.label("Quantity").'</th>
         <th class=" col-xs-1 text-center"><i class="fa fa-trash-o trash-opacity-50"></i></th>
         </tr>
         </thead>
         <tbody>';
         foreach ($combos as $combo) {
            $prod = Product::find($combo->item_id);
            $content .= '<tr id="rowid_' . $combo->item_id . '" class="item_' . $combo->item_id . '">
              <td>'.$prod->name.' ('. $prod->code .')</td>
              <td><b>'.$combo->quantity.'</b></td>
              <td><i class="fa fa-times tip delt" id="' . $combo->item_id . '" title="Remove" style="cursor:pointer;"></i></td>
              </tr>';
         }
         $content .= '</tbody>
         </table>
         </div>
         <input type="hidden" id="prodctID" value="'.$id.'">';

      echo $content;

   }

   public function getcombos($id){
      $combos = Combo_item::find('all', array('conditions' => array('product_id = ?', $id)));

      if ($combos) {
          foreach ($combos as $row) {
             $prod = Product::find($row->item_id);
             $pr[] = array('item_id' => $row->item_id, 'quantity' => $row->quantity, 'code' => $prod->code, 'name' => $prod->name);
          }
          echo json_encode($pr);
      }else {
         echo json_encode();
      }

   }




   /********************* make product invisible on a store *******************************/

   public function makePrdInvis($id, $productId){
      $product = Product::find($productId);
      $cheked = false;
      $newVal = '';
      $invis = $product->h_stores;
      $invis = trim($invis, ",");
      $array = explode(',', $invis); //split string into array seperated by ','
      foreach($array as $value) //loop over values
      {
         if(intval($value) == intval($id)){
            $newVal = $newVal;
            $cheked = true;
         }else {
            $newVal .= $value.',';
         }
      }
      if(!$cheked){
         $product->h_stores .= $id.',';
         $product->save();
      }else{
         $product->h_stores = $newVal;
         $product->save();
      }
      echo json_encode(array(
          "status" => TRUE
      ));
   }

}
