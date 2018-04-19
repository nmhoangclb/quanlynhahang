<script type="text/javascript">
$(function() {

   $('#Type').on('change', function() {
     if( this.value == 1 ) //if service
     {
        $("#pushaceP").slideUp();
        $("#alertqty").slideUp();
        $("#supply").slideUp();
        $("#UnitP").slideUp();
     } else if ( this.value == 2 ) {
        $("#pushaceP").slideUp();
        $("#alertqty").slideUp();
        $("#supply").slideUp();
        $("#UnitP").slideUp();
     } else {
        $("#pushaceP").slideDown();
        $("#alertqty").slideDown();
        $("#supply").slideDown();
        $("#UnitP").slideDown();
     }
   });
   if( <?=$product->type !== null ? $product->type : 1;?> == 1 ) //if service
   {
     $("#pushaceP").slideUp();
     $("#supply").slideUp();
     $("#alertqty").slideUp();
     $("#UnitP").slideUp();
  } else if ( <?=$product->type?> == 2 ) {
     $("#pushaceP").slideUp();
     $("#alertqty").slideUp();
     $("#supply").slideUp();
     $("#UnitP").slideUp();
   } else {
     $("#pushaceP").slideDown();
     $("#supply").slideDown();
     $("#alertqty").slideDown();
     $("#UnitP").slideDown();
   }

});
</script>
<div class="container container-small">
   <div class="row" style="margin-top:100px;">
      <a class="btn btn-default float-right" href="#" onclick="history.back(-1)"style="margin-bottom:10px;">
         <i class="fa fa-arrow-left"></i> <?=label("Back");?></a>
      <?php echo form_open_multipart('products/edit/'.$product->id); ?>
         <div class="form-group">
         <label for="Type"><?=label("Type");?></label>
         <select class="form-control" name="type" id="Type">
            <option value="0" <?=$product->type === 0 ? 'selected' : '';?>><?=label("Standard");?></option>
            <option value="1" <?=$product->type === 1 || $product->type === null ? 'selected' : '';?>><?=label("Service");?></option>
            <option value="2" <?=$product->type === 2 ? 'selected' : '';?>><?=label("combination");?></option>
         </select>
         </div>
         <div class="form-group">
         <label for="ProductCode"><?=label("ProductCode");?></label>
         <input type="text" name="code" maxlength="30" Required value="<?=$product->code;?>" class="form-control" id="ProductCode" placeholder="<?=label("ProductCode");?>">
         <p class="red"><?=$this->session->flashdata('error') ? $this->session->flashdata('error') : '';?></p>
        </div>
        <div class="form-group">
         <label for="ProductName"><?=label("ProductName");?></label>
         <input type="text" name="name" maxlength="25" Required value="<?=$product->name;?>" class="form-control" id="ProductName" placeholder="<?=label("ProductName");?>">
        </div>
        <div class="form-group">
         <label for="Category"><?=label("Category");?></label>
         <select class="form-control" value="<?=$product->category;?>" name="category" id="Category">
            <option><?=label("Category");?></option>
            <?php foreach ($categories as $category):?>
               <option <?=$product->category===$category->name ? 'selected' : '';?>><?=$category->name;?></option>
            <?php endforeach;?>
         </select>
        </div>
        <div class="form-group" id="supply">
           <label for="Supplier"><?=label("Supplier");?></label>
           <select class="form-control" name="supplier" id="Supplier">
             <option><?=label("Supplier");?></option>
             <?php foreach ($suppliers as $supplier):?>
                <option <?=$product->supplier===$supplier->name ? 'selected' : '';?>><?=$supplier->name;?></option>
             <?php endforeach;?>
          </select>
       </div>
        <div class="form-group" id="pushaceP">
         <label for="PurchasePrice"><?=label("PurchasePrice");?> (<?=$this->setting->currency;?>)</label>
         <input type="number" step="any" Required name="cost" value="<?=$product->cost;?>" class="form-control" id="PurchasePrice" placeholder="<?=label("PurchasePrice");?>">
        </div>
        <div class="form-group">
          <label for="Tax"><?=label("ProductTax");?></label>
          <input type="text" name="tax" maxlength="10" value="<?=$product->tax;?>" class="form-control" id="Tax" placeholder="<?=label("ProductTax");?>">
        </div>
        <div class="form-group">
           <label for="taxType"><?=label("TaxMethod");?></label>
           <select class="form-control" name="taxmethod" id="taxType">
             <option value="0" <?=$product->taxmethod === 0 ? 'selected' : '';?>><?=label("inclusive");?></option>
             <option value="1" <?=$product->taxmethod === 1 ? 'selected' : '';?>><?=label("exclusive");?></option>
           </select>
        </div>
        <div class="form-group">
         <label for="Price"><?=label("Price");?> (<?=$this->setting->currency;?>)</label>
         <input type="number" step="any" Required name="price" value="<?=$product->price;?>" class="form-control" id="Price" placeholder="<?=label("Price");?>">
        </div>
        <div class="form-group" id="UnitP">
          <label for="Unit"><?=label("Unit");?></label>
          <input type="text" step="any" name="unit" value="<?=$product->unit;?>" class="form-control" id="Unit" placeholder="<?=label("Unit");?>">
        </div>
        <div class="form-group" id="alertqty">
          <label for="AlertQt"><?=label("AlertQt");?></label>
          <input type="number" value="<?=$product->alertqt;?>" name="alertqt" class="form-control" id="AlertQt" placeholder="<?=label("AlertQt");?>">
        </div>
        <div class="form-group">
          <label for="ProductOptions"><?=label("ProductOptions");?></label>
          <textarea class="form-control" id="ProductOptions" name="options"><?=$product->options;?></textarea>
       </div>
        <div class="form-group">
         <label for="exampleInputFile"><?=label("Imageinput");?></label>
         <input type="file" name="userfile" id="ImageInput">
        </div>
        <div class="form-group">
         <label for="ProductDescription"><?=label("ProductDescription");?></label>
         <textarea id="summernote" name="description"><?=$product->description;?></textarea>
      </div>
        <div class="form-group">
           <div class="btn-group white" data-toggle="buttons">
              <p class="help-block"><?=label("ProductColor");?></p>
              <label class="btn color01">
                 <input type="radio" name="color" id="option1" value="color01" autocomplete="off" <?php if($product->color == 'color01'){echo 'checked'; } ?>> C1
              </label>
              <label class="btn color02">
                 <input type="radio" name="color" id="option2" value="color02" autocomplete="off" <?php if($product->color == 'color02'){echo 'checked'; } ?>> C2
              </label>
              <label class="btn color03">
                 <input type="radio" name="color" id="option3" value="color03" autocomplete="off" <?php if($product->color == 'color03'){echo 'checked'; } ?>> C3
              </label>
              <label class="btn color04">
                 <input type="radio" name="color" id="option4" value="color04" autocomplete="off" <?php if($product->color == 'color04'){echo 'checked'; } ?>> C4
              </label>
              <label class="btn color05">
                 <input type="radio" name="color" id="option5" value="color05" autocomplete="off" <?php if($product->color == 'color05'){echo 'checked'; } ?>> C5
              </label>
              <label class="btn color06">
                 <input type="radio" name="color" id="option6" value="color06" autocomplete="off" <?php if($product->color == 'color06'){echo 'checked'; } ?>> C6
              </label>
              <label class="btn color07">
                 <input type="radio" name="color" id="option7" value="color07" autocomplete="off" <?php if($product->color == 'color07'){echo 'checked'; } ?>> C7
              </label>
              <label class="btn color08">
                 <input type="radio" name="color" id="option8" value="color08" autocomplete="off" <?php if($product->color == 'color08'){echo 'checked'; } ?>> C7
              </label>
           </div>
           <?php if($product->photo){ ?><img src="<?=base_url()?>files/products/<?=$product->photo;?>" alt="" class="float-right" width="150px"/><?php } ?>
         </div>
      <div class="form-group">
         <button type="submit" class="btn btn-green col-md-6 flat-box-btn"><?=label("Submit");?></button>
      </div>
      <?php echo form_close(); ?>
   </div>
</div>
