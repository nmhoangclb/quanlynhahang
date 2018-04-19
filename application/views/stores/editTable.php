<div class="container container-small">
   <div class="row" style="margin-top:100px;">
      <a class="btn btn-default float-right" href="#" onclick="history.back(-1)"style="margin-bottom:10px;">
         <i class="fa fa-arrow-left"></i> <?=label("Back");?></a>
     <?php echo form_open_multipart('stores/editTable/'.$table->id); ?>
        <div class="form-group">
         <label for="TableName"><?=label("TableName");?> *</label>
         <input type="text" name="name" class="form-control" id="TableName" value="<?=$table->name;?>" placeholder="<?=label("TableName");?>" required>
       </div>
       <label for="Zones"><?=label("ChooseZone");?></label>
      <select class="form-control" id="Zones" name="zone_id">
         <option value=''><?=label("ChooseZone");?></option>
         <?php foreach ($zones as $zone):?>
            <option value="<?=$zone->id;?>" <?=$zone->id == $table->zone_id ? 'selected' : '';?>><?=$zone->name;?></option>
         <?php endforeach;?>
      </select>
     <div class="form-group">
       <button type="submit" class="btn btn-add"><?=label("Submit");?></button>
     </div>
     <?php echo form_close(); ?>
   </div>
</div>
