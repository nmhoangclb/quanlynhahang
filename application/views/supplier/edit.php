<div class="container container-small">
   <div class="row" style="margin-top:100px;">
      <a class="btn btn-default float-right" href="#" onclick="history.back(-1)"style="margin-bottom:10px;">
         <i class="fa fa-arrow-left"></i> <?=label("Back");?></a>
      <?php echo form_open_multipart('suppliers/edit/'.$supplier->id); ?>
            <div class="form-group">
            <label for="SupplierName"><?=label("SupplierName");?></label>
            <input type="text" maxlength="50" Required name="name" value="<?=$supplier->name;?>" class="form-control" id="SupplierName" placeholder="<?=label("SupplierName");?>">
           </div>
           <div class="form-group">
            <label for="SupplierPhone"><?=label("SupplierPhone");?></label>
            <input type="text" name="phone" maxlength="30" value="<?=$supplier->phone;?>" class="form-control" id="SupplierPhone" placeholder="<?=label("SupplierPhone");?>">
           </div>
           <div class="form-group">
            <label for="SupplierEmail"><?=label("SupplierEmail");?></label>
            <input type="email" maxlength="50" name="email" value="<?=$supplier->email;?>" class="form-control" id="SupplierEmail" placeholder="<?=label("SupplierEmail");?>">
           </div>
           <div class="form-group">
           <label for="Note"><?=label("Note");?></label>
           <textarea id="summernote" name="note"><?=$supplier->note;?></textarea>
          </div>
      </div>
      <div class="form-group">
       <button type="submit" class="btn btn-add"><?=label("Submit");?></button>
      </div>
      <?php echo form_close(); ?>
</div>
