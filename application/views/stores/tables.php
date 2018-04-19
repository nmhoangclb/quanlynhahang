<!-- Page Content -->
<div class="container  container-small">

   <div class="row" style="margin-top:100px;">
      <div class="row">
         <h2>Store Zones</h2>
      </div>
      <div class="row">
         <?php foreach($zones as $zone): ?>
         <span class="zone"><?=$zone->name?><i id='<?=$zone->id?>' zone-name="<?=$zone->name?>" class="fa fa-pencil editzone" aria-hidden="true"></i><i id='<?=$zone->id?>' class="fa fa-times deletezone"></i></span>
         <?php endforeach;?>
         <span data-toggle="modal" data-target="#AddZone" class="zone"><?=!empty($zones) ? '' : label("AddZone");?><i class="fa fa-plus" style="margin-left:0px;"></i></span>
      </div>
      <div class="row">
         <h2>Store Tables</h2>
      </div>
      <!-- Button trigger modal -->
      <div class="row">
         <button type="button" class="btn btn-add btn-lg" data-toggle="modal" data-target="#Addtable" style="margin: 10px 0 !important;">
            <?=label("Addtable");?>
         </button>
      </div>
      <div class="row">
         <table class="table table-striped table-bordered" cellspacing="0" width="100%">
             <thead>
                <tr>
                   <th><?=label("TableName");?></th>
                   <th><?=label("ZoneName");?></th>
                   <th><?=label("Action");?></th>
                </tr>
             </thead>

             <tbody>
                <?php foreach ($tables as $table):?>
                <tr>
                   <td><?=$table->name;?></td>
                    <td><?=$zones02[$table->zone_id];?></td>
                    <td><div class="btn-group">
                          <a class="btn btn-default" href="<?=base_url();?>stores/deletetable/<?=$table->id;?>/<?=$storeid;?>" data-toggle="tooltip" data-placement="top" title="<?=label('Delete');?>"><i class="fa fa-times"></i></a>
                          <a class="btn btn-default" href="<?=base_url();?>stores/editTable/<?=$table->id;?>" data-toggle="tooltip" data-placement="top" title="<?=label('Edit');?>"><i class="fa fa-pencil"></i></a>
                       </div>
                     </td>
                </tr>
                <?php endforeach;?>
             </tbody>
         </table>
      </div>
   </div>
</div>
<!-- /.container -->

<script type="text/javascript">

$(function() {
   /*************** edit zone **********/
   $(document).on('click', '.deletezone', function () {

      var zone_id = $(this).attr('id');
         swal({   title: '<?=label("Areyousure");?>',
         text: '<?=label("TablesDeleted");?>',
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: '<?=label("yesiam");?>',
         closeOnConfirm: false },
         function(){
           // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('stores/deletezone')?>/"+zone_id,
                type: "POST",
                success: function(data){
                   location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown){alert("error");}
           });
     swal.close(); });
  });

  /*************** delete zone **********/
  $(document).on('click', '.editzone', function () {
     var id = $(this).attr('id');
     var name = $(this).attr('zone-name');
     $("#zone_id").val(id);
     $("#ZoneName").val(name);
     $('#EditZone').modal('show');
});
});


</script>

<!-- add table Modal -->
<div class="modal fade" id="Addtable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("Addtable");?></h4>
      </div>
      <?php echo form_open_multipart('stores/addTable'); ?>
      <div class="modal-body">
            <div class="form-group">
             <label for="TableName"><?=label("TableName");?> *</label>
             <input type="text" name="name" class="form-control" id="TableName" placeholder="<?=label("TableName");?>" required>
             <input type="hidden" name="store_id" value="<?=$storeid?>">
           </div>
           <label for="Zones"><?=label("ChooseZone");?> *</label>
          <select class="form-control" id="Zones" name="zone_id" required>
             <option value=''><?=label("ChooseZone");?></option>
             <?php foreach ($zones as $zone):?>
                <option value="<?=$zone->id;?>"><?=$zone->name;?></option>
             <?php endforeach;?>
          </select>
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

<!-- add Zone Modal -->
<div class="modal fade" id="AddZone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("AddZone");?></h4>
      </div>
      <?php echo form_open_multipart('stores/addzone'); ?>
      <div class="modal-body">
            <div class="form-group">
             <label for="ZonesName"><?=label("ZoneName");?> *</label>
             <input type="text" name="name" class="form-control" id="ZonesName" placeholder="<?=label("ZoneName");?>" required>
             <input type="hidden" name="store_id" value="<?=$storeid;?>">
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

<!-- edit Zone Modal -->
<div class="modal fade" id="EditZone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("AddZone");?></h4>
      </div>
      <?php echo form_open_multipart('stores/editzone'); ?>
      <div class="modal-body">
            <div class="form-group">
             <label for="ZoneName"><?=label("ZoneName");?> *</label>
             <input type="text" name="name" class="form-control" id="ZoneName" placeholder="<?=label("ZoneName");?>" required>
             <input type="hidden" name="store_id" value="<?=$storeid;?>">
             <input type="hidden" name="zone_id" id="zone_id" value="">
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
