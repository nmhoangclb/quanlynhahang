  <div class="container">

    <h3><?=label('Expence');?></h3>
    <br />
    <br />
    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead class="thead-inverse">
        <tr>
          <th><?=label('Date');?></th>
          <th><?=label('Reference');?></th>
          <th><?=label('Amount');?></th>
          <th><?=label('Category');?></th>
          <th><?=label('Store');?></th>
          <th><?=label('Createdby');?></th>
          <th><?=label('Action');?></th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>

    <!-- Button trigger modal -->
   <button type="button" class="btn btn-add btn-lg" data-toggle="modal" data-target="#AddExpence">
     <?=label("AddExpence");?>
   </button>
  </div>


  <script type="text/javascript">

    var save_method; //for save method string
    var table;


    $(document).ready(function() {

      $('#Date').datepicker({
          todayHighlight: true
      });

      $('#summernote').summernote({
         height: 200,
         toolbar: [
          // [groupName, [list of button]]
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', []],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']]
        ]
      });

      table = $('#table').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('expences_controller/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],
         "bInfo": false,
         // "fnRowCallback": function(nRow, aData, iDisplayIndex) {
         //     nRow.setAttribute('data-order',aData[4]);
         // }
      });
    });


    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax
    }

    function delete_expences(id)
    {
      swal({   title: '<?=label("Areyousure");?>',
      text: '<?=label("Deletemessage");?>',
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: '<?=label("yesiam");?>',
      closeOnConfirm: false },
      function(){
         // ajax delete data to database
         $.ajax({
            url : "<?php echo site_url('expences_controller/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
               alert('Error adding / update data');
            }
         });
         swal('<?=label("Deleted");?>', '<?=label("Deletedmessage");?>', "success"); });
    }


  </script>


  <!-- Modal -->
  <div class="modal fade" id="AddExpence" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><?=label("AddExpence");?></h4>
        </div>
        <?php
        $attributes = array('id' => 'addform');
        echo form_open_multipart('expences/add', $attributes);
        ?>
        <div class="modal-body">
              <div class="form-group controls">
               <label for="Date"><?=label("Date");?> *</label>
               <input type="text" maxlength="30" Required name="date" class="form-control" id="Date" placeholder="<?=label("Date");?>">
             </div>
             <div class="form-group">
               <label for="Reference"><?=label("Reference");?> *</label>
               <input type="text" name="reference" maxlength="25" Required class="form-control" id="Reference" placeholder="<?=label("Reference");?>">
             </div>
             <div class="form-group">
               <label for="Category"><?=label("Category");?></label>
               <select class="form-control" name="category" id="Category">
                 <option value="0"><?=label("Category");?></option>
                 <?php foreach ($categories as $category):?>
                    <option value="<?=$category->id;?>"><?=$category->name;?></option>
                 <?php endforeach;?>
              </select>
             </div>
             <div class="form-group">
               <label for="store_id"><?=label("Store");?></label>
                  <?php if(isset($storeId)):?>
                     <input type="text" value="<?=$storeName;?>" class="form-control" id="store_id" disabled>
                     <input type="hidden" value="<?=$storeId;?>" name="store_id">
                     <?php else:?>
                     <select class="form-control" name="store_id" id="store_id">
                       <option value="0"><?=label("Store");?></option>
                       <?php foreach ($stores as $store):?>
                          <option value="<?=$store->id;?>"><?=$store->name;?></option>
                       <?php endforeach;?>
                       </select>
                   <?php endif;?>

             </div>
             <div class="form-group">
               <label for="Amount"><?=label("Amount");?> (<?=$this->setting->currency;?>) *</label>
               <input type="number" step="any" Required name="amount" class="form-control" id="Amount" placeholder="<?=label("Amount");?>">
             </div>
             <div class="form-group">
                <label for="exampleInputFile"><?=label("Attachment");?></label>
                <input type="file" name="userfile" id="attachment">
                 <p class="help-block"><?=label("AttachmentInfos");?></p>
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
