<div class="container container-small">
   <div class="row" style="margin-top:100px;">
      <a class="btn btn-default float-right" href="#" onclick="history.back(-1)"style="margin-bottom:10px;">
         <i class="fa fa-arrow-left"></i> <?=label("Back");?></a>
         <?php
         $attributes = array('id' => 'addform');
         echo form_open_multipart('expences/edit/'.$expence->id, $attributes);
         ?>
         <div class="modal-body">
               <div class="form-group controls">
                <label for="Date"><?=label("Date");?> *</label>
                <input type="text" maxlength="30" Required name="date" value="<?=$expence->date->format('m/d/Y');?>" class="form-control" id="Date" placeholder="<?=label("Date");?>">
              </div>
              <div class="form-group">
                <label for="Reference"><?=label("Reference");?> *</label>
                <input type="text" name="reference" value="<?=$expence->reference;?>" maxlength="25" Required class="form-control" id="Reference" placeholder="<?=label("Reference");?>">
              </div>
              <div class="form-group">
                <label for="Category"><?=label("Category");?></label>
                <select class="form-control" name="category" id="Category">
                  <option value="0"><?=label("Category");?></option>
                  <?php foreach ($categories as $category):?>
                     <option value="<?=$category->id;?>" <?=$expence->category_id == $category->id ? 'selected' : '';?>><?=$category->name;?></option>
                  <?php endforeach;?>
               </select>
              </div>
              <div class="form-group">
                <label for="store_id"><?=label("Store");?></label>
                   <?php if($this->user->role !== "admin"):?>
                         <input type="text" value="<?=$storeName;?>" class="form-control" id="store_id" disabled>
                         <input type="hidden" value="<?=$expence->store_id;?>" name="store_id">
                      <?php else:?>
                      <select class="form-control" name="store_id" id="store_id">
                        <option value="0"><?=label("Store");?></option>
                        <?php foreach ($stores as $store):?>
                           <option value="<?=$store->id;?>" <?=$expence->store_id == $store->id ? 'selected' : '';?>><?=$store->name;?></option>
                        <?php endforeach;
                     endif;?>

               </select>
              </div>
              <div class="form-group">
                <label for="Amount"><?=label("Amount");?> (<?=$this->setting->currency;?>) *</label>
                <input type="number" step="any" Required name="amount" value="<?=$expence->amount;?>" class="form-control" id="Amount" placeholder="<?=label("Amount");?>">
              </div>
              <div class="form-group">
                 <label for="exampleInputFile"><?=label("Attachment");?></label>
                 <input type="file" name="userfile" id="attachment">
                  <p class="help-block"><?=label("AttachmentInfos");?></p>
              </div>
              <div class="form-group">
                <label for="Note"><?=label("Note");?></label>
                <textarea id="summernote" name="note"><?=$expence->note;?></textarea>
              </div>
         </div>

     <div class="form-group">
       <button type="submit" class="btn btn-add"><?=label("Submit");?></button>
     </div>
     <?php echo form_close(); ?>
   </div>
</div>

<script type="text/javascript">

$(document).ready(function() {

  $('#Date').datepicker({
      todayHighlight: true
  });
  });

</script>
