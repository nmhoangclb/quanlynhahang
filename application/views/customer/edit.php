<div class="container container-small">
   <div class="row" style="margin-top:100px;">
      <a class="btn btn-default float-right" href="#" onclick="history.back(-1)"style="margin-bottom:10px;">
         <i class="fa fa-arrow-left"></i> <?=label("Back");?></a>
      <?php echo form_open_multipart('customers/edit/'.$customer->id); ?>
            <div class="form-group">
            <label for="CustomerName"><?=label("CustomerName");?></label>
            <input type="text" maxlength="50" Required name="name" value="<?=$customer->name;?>" class="form-control" id="CustomerName" placeholder="<?=label("CustomerName");?>">
           </div>
           <div class="form-group">
            <label for="CustomerPhone"><?=label("CustomerPhone");?></label>
            <input type="text" name="phone" maxlength="30" value="<?=$customer->phone;?>" class="form-control" id="CustomerPhone" placeholder="<?=label("CustomerPhone");?>">
           </div>
           <div class="form-group">
            <label for="CustomerEmail"><?=label("CustomerEmail");?></label>
            <input type="email" maxlength="50" name="email" value="<?=$customer->email;?>" class="form-control" id="CustomerEmail" placeholder="<?=label("CustomerEmail");?>">
           </div>
           <div class="form-group">
            <label for="CustomerDiscount"><?=label("CustomerDiscount");?></label>
            <input type="text" maxlength="5" name="discount" value="<?=$customer->discount;?>" class="form-control" id="CustomerDiscount" placeholder="<?=label("CustomerDiscount");?>">
           </div>
      </div>
      <div class="form-group">
       <button type="submit" class="btn btn-add"><?=label("Submit");?></button>
      </div>
      <?php echo form_close(); ?>
</div>
