<?php
require_once('traits/uniquecheck.php');
class Product extends ActiveRecord\Model {

   public static $table_name = 'zarest_products';
  //  static $validates_uniqueness_of = array(
  //     array('code')
  //  );
  use uniquecheck;
  public function validate() {
       $this->uniquecheck(array('code','message' => 'Can\'t have duplicate code.'));
   }

}
