<!-- Page Content -->
<div class="container">
   <div class="row" style="margin-top:100px;">
      <table id="Table" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th><?=label("WaiterName");?></th>
                  <th><?=label("WaiterPhone");?></th>
                  <th class="hidden-xs"><?=label("WaiterEmail");?></th>
                  <th class="hidden-xs"><?=label("Store");?></th>
                  <th class="hidden-xs"><?=label("CreatedAt");?></th>
                  <th><?=label("Action");?></th>
              </tr>
          </thead>

          <tbody>
             <?php foreach ($waiters as $waiter):?>
              <tr>
                 <td><?=$waiter->name;?></td>
                 <td><?=$waiter->phone;?></td>
                 <td class="hidden-xs"><?=$waiter->email;?></td>
                 <td class="hidden-xs"><?=$strs[$waiter->store_id];?></td>
                 <td class="hidden-xs"><?=$waiter->created_at;?></td>
                 <td><div class="btn-group">
                       <a class="btn btn-default" href="javascript:void(0)" data-toggle="popover" data-placement="left"  data-html="true" title='<?=label("Areyousure");?>' data-content='<a class="btn btn-danger" href="waiters/delete/<?=$waiter->id;?>"><?=label("yesiam");?></a>'><i class="fa fa-times"></i></a>
                       <a class="btn btn-default" href="waiters/edit/<?=$waiter->id;?>" data-toggle="tooltip" data-placement="top" title="<?=label('Edit');?>"><i class="fa fa-pencil"></i></a>
                     </div>
                  </td>
              </tr>
           <?php endforeach;?>
          </tbody>
      </table>
   </div>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-add btn-lg" data-toggle="modal" data-target="#AddWaiter">
     <?=label("AddWaiter");?>
   </button>
</div>
<!-- /.container -->

<!-- Modal -->
<div class="modal fade" id="AddWaiter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("AddWaiter");?></h4>
      </div>
      <?php echo form_open_multipart('waiters/add'); ?>
      <div class="modal-body">
            <div class="form-group">
             <label for="WaiterName"><?=label("WaiterName");?></label>
             <input type="text" name="name" maxlength="50" Required class="form-control" id="WaiterName" placeholder="<?=label("WaiterName");?>">
           </div>
           <div class="form-group">
             <label for="WaiterPhone"><?=label("WaiterPhone");?></label>
             <input type="text" name="phone" maxlength="30" class="form-control" id="WaiterPhone" placeholder="<?=label("WaiterPhone");?>">
           </div>
           <div class="form-group">
             <label for="WaiterEmail"><?=label("WaiterEmail");?></label>
             <input type="email" maxlength="50" name="email" class="form-control" id="WaiterEmail" placeholder="<?=label("WaiterEmail");?>">
           </div>
           <div class="form-group" id="supply">
             <label for="WaiterStore"><?=label("Store");?></label>
             <select class="form-control" name="store_id" id="WaiterStore" Required>
               <option><?=label("Store");?></option>
               <?php foreach ($stores as $store):?>
                  <option value="<?=$store->id;?>"><?=$store->name;?></option>
               <?php endforeach;?>
            </select>
           </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=label("Close");?></button>
        <button type="submit" class="btn btn-add"><?=label("Submit");?></button>
      </div>
   <?php echo form_close(); ?>
    </div>
 </div>
</div>
<!-- /.Modal -->
