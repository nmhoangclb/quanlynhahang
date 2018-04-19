<div class="container container-small">
   <div class="row" style="margin-top:100px;">
      <a class="btn btn-default float-right" href="#" onclick="history.back(-1)"style="margin-bottom:10px;">
         <i class="fa fa-arrow-left"></i> <?=label("Back");?></a>
      <?php echo form_open_multipart('warehouses/edit/'.$warehouse->id); ?>

      <div class="form-group">
      <label for="WarehouseName"><?=label("WarehouseName");?> *</label>
      <input type="text" name="name" value="<?=$warehouse->name;?>" class="form-control" id="WarehouseName" placeholder="<?=label("WarehouseName");?>" required>
     </div>
     <div class="form-group">
        <label for="WarehousePhone"><?=label("WarehousePhone");?></label>
        <input type="text" name="phone" value="<?=$warehouse->phone;?>" class="form-control" id="WarehousePhone" placeholder="<?=label("WarehousePhone");?>">
     </div>
     <div class="form-group">
      <label for="email"><?=label("Email");?></label>
      <input type="email" name="email" value="<?=$warehouse->email;?>" class="form-control" id="email" placeholder="<?=label("Email");?>">
    </div>
     <div class="form-group">
      <label for="Adresse"><?=label("Adresse");?></label>
      <input type="text" name="adresse" value="<?=$warehouse->adresse;?>" class="form-control" id="Adresse" placeholder="<?=label("Adresse");?>">
     </div>
     
      <div class="form-group">
        <button type="submit" class="btn btn-green col-md-6 flat-box-btn"><?=label("Submit");?></button>
      </div>
      <?php echo form_close(); ?>
    </div>
</div>
