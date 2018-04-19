<div class="container container-small">
   <div class="row" style="margin-top:100px;">
      <a class="btn btn-default float-right" href="#" onclick="history.back(-1)"style="margin-bottom:10px;">
         <i class="fa fa-arrow-left"></i> <?=label("Back");?></a>
      <?php echo form_open_multipart('stores/edit/'.$store->id); ?>

      <div class="form-group">
      <label for="StoreName"><?=label("StoreName");?> *</label>
      <input type="text" name="name" value="<?=$store->name;?>" class="form-control" id="StoreName" placeholder="<?=label("StoreName");?>" required>
     </div>
     <div class="form-group">
      <label for="email"><?=label("Email");?></label>
      <input type="email" name="email" value="<?=$store->email;?>" class="form-control" id="email" placeholder="<?=label("Email");?>">
    </div>
     <div class="form-group">
      <label for="StorePhone"><?=label("StorePhone");?></label>
      <input type="text" name="phone" value="<?=$store->phone;?>" class="form-control" id="StorePhone" placeholder="<?=label("StorePhone");?>">
     </div>
     <div class="form-group">
      <label for="Country"><?=label("Country");?></label>
      <input type="text" name="country" value="<?=$store->country;?>" class="form-control" id="Country" placeholder="<?=label("Country");?>">
     </div>
     <div class="form-group">
      <label for="City"><?=label("City");?></label>
      <input type="text" name="city" value="<?=$store->city;?>" class="form-control" id="City" placeholder="<?=label("City");?>">
     </div>
     <div class="form-group">
      <label for="Adresse"><?=label("Adresse");?></label>
      <input type="text" name="adresse" value="<?=$store->adresse;?>" class="form-control" id="Adresse" placeholder="<?=label("Adresse");?>">
     </div>
     <div class="form-group">
      <label for="CustomeFooter"><?=label("CustomeFooter");?></label>
      <input type="text" name="footer_text" value="<?=$store->footer_text;?>" class="form-control" id="CustomeFooter" placeholder="<?=label("CustomeFooter");?>">
     </div>

      <div class="form-group">
        <button type="submit" class="btn btn-green col-md-6 flat-box-btn"><?=label("Submit");?></button>
      </div>
      <?php echo form_close(); ?>
    </div>
</div>
