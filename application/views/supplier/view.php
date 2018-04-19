<!-- Page Content -->
<div class="container">
   <div class="row" style="margin-top:100px;">
      <table id="Table" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th><?=label("SupplierName");?></th>
                  <th><?=label("SupplierPhone");?></th>
                  <th class="hidden-xs"><?=label("SupplierEmail");?></th>
                  <th class="hidden-xs"><?=label("CreatedAt");?></th>
                  <th><?=label("Action");?></th>
              </tr>
          </thead>

          <tbody>
             <?php foreach ($suppliers as $supplier):?>
              <tr>
                 <td><?=$supplier->name;?></td>
                 <td><?=$supplier->phone;?></td>
                 <td class="hidden-xs"><?=$supplier->email;?></td>
                 <td class="hidden-xs"><?=$supplier->created_at;?></td>
                 <td><div class="btn-group">
                       <a class="btn btn-default" href="javascript:void(0)" data-toggle="popover" data-placement="left"  data-html="true" title='<?=label("Areyousure");?>' data-content='<a class="btn btn-danger" href="suppliers/delete/<?=$supplier->id;?>"><?=label("yesiam");?></a>'><i class="fa fa-times"></i></a>
                       <a class="btn btn-default" href="suppliers/edit/<?=$supplier->id;?>" data-toggle="tooltip" data-placement="top" title="<?=label('Edit');?>"><i class="fa fa-pencil"></i></a>
                     </div>
                  </td>
              </tr>
           <?php endforeach;?>
          </tbody>
      </table>
   </div>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-add btn-lg" data-toggle="modal" data-target="#AddSupplier">
     <?=label("AddSupplier");?>
   </button>
</div>
<!-- /.container -->

<!-- Modal -->
<div class="modal fade" id="AddSupplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("AddSupplier");?></h4>
      </div>
      <?php echo form_open_multipart('suppliers/add'); ?>
      <div class="modal-body">
            <div class="form-group">
             <label for="SupplierName"><?=label("SupplierName");?></label>
             <input type="text" name="name" maxlength="50" Required class="form-control" id="SupplierName" placeholder="<?=label("SupplierName");?>">
           </div>
           <div class="form-group">
             <label for="SupplierPhone"><?=label("SupplierPhone");?></label>
             <input type="text" name="phone" maxlength="30" class="form-control" id="SupplierPhone" placeholder="<?=label("SupplierPhone");?>">
           </div>
           <div class="form-group">
             <label for="SupplierEmail"><?=label("SupplierEmail");?></label>
             <input type="email" maxlength="50" name="email" class="form-control" id="SupplierEmail" placeholder="<?=label("SupplierEmail");?>">
           </div>
           <div class="form-group">
           <label for="Note"><?=label("Note");?></label>
           <textarea id="summernote" name="note"></textarea>
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
