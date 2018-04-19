<div class="container container-small">
   <div class="row" style="margin-top:100px;">
      <a class="btn btn-default float-right" href="#" onclick="history.back(-1)"style="margin-bottom:10px;">
         <i class="fa fa-arrow-left"></i> <?=label("Back");?></a>
      <?php echo form_open_multipart('waiters/edit/'.$waiter->id); ?>
            <div class="form-group">
            <label for="WaiterName"><?=label("WaiterName");?></label>
            <input type="text" maxlength="50" Required name="name" value="<?=$waiter->name;?>" class="form-control" id="WaiterName" placeholder="<?=label("WaiterName");?>">
           </div>
           <div class="form-group">
            <label for="WaiterPhone"><?=label("WaiterPhone");?></label>
            <input type="text" name="phone" maxlength="30" value="<?=$waiter->phone;?>" class="form-control" id="WaiterPhone" placeholder="<?=label("WaiterPhone");?>">
           </div>
           <div class="form-group">
            <label for="WaiterEmail"><?=label("WaiterEmail");?></label>
            <input type="email" maxlength="50" name="email" value="<?=$waiter->email;?>" class="form-control" id="WaiterEmail" placeholder="<?=label("WaiterEmail");?>">
           </div>
           <select class="form-control" name="store_id" id="WaiterStore" Required>
             <option><?=label("Store");?></option>
             <?php foreach ($stores as $store):?>
                <option value="<?=$store->id;?>" <?=$waiter->store_id == $store->id ? 'selected' : '';?>><?=$store->name;?></option>
             <?php endforeach;?>
          </select>
      </div>
      <div class="form-group">
       <button type="submit" class="btn btn-add"><?=label("Submit");?></button>
      </div>
      <?php echo form_close(); ?>
</div>
