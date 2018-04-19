<html lang="en">
<head>
<body>
<script type="text/javascript">
$(document).ready(function() {$('#ticket').modal({show: false, backdrop: 'static', keyboard: false});});

var id = setTimeout(function(){
 window.location.reload(1);
}, 6000);

function showticket(table){
   $('#printSection').load("<?php echo site_url('pos/showticketKit')?>/"+table);
   clearTimeout(id);
   $('#ticket').modal('show');
}
function PrintTicket() {
   $('.modal-body').removeAttr('id');
   window.print();
   $('.modal-body').attr('id', 'modal-body');
}
function closeModal() {
  window.location.reload(1);
}


</script>




<!-- Page Content -->
<center>
<div class="container">
   <div class="row" style="margin-top:100px;">
        <?=!$zones ? '<h4 style="margin-top:60px">'.label("NoTables").'</h4>' : '';?>
        <?php foreach ($zones as $zone):?>
        <div class="row">
           <h1 class="choose_store"> <?=$zone->name;?> </h1><hr>
        </div>
        <div class="row tablesrow">
           <?php foreach ($tables as $table):?>
              <?php if($table->zone_id == $zone->id) {?>
           <div class="col-sm-2 col-xs-4 tableList nohover-item"  style="">
              <?php if($table->time == 'n'){?><span class="tablenotif">.</span><script>function Hello(){alert("Thông báo, Có thêm món mới!"); } window.onload = Hello</script><audio autoplay><source src="http://greenlove.online/beep.mp3" type="audio/mpeg"></audio><?php } ?>
              <a class="btn btn-lg <?= $table->status == 1 ? 'kitchentable-btn' : 'kitchentableoff-btn disabled'; ?>" href="javascript:void(0)" onclick="showticket(<?=$table->id;?>)">
                <?=$table->name;?>
              </a>
           </div>
           <?php } ?>
           <?php endforeach;?>
        </div>
     <?php endforeach;?>


</div>
<!-- /.container -->

<!-- Modal ticket -->
<div class="modal fade" id="ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document" id="ticketModal">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="ticket"><?=label("Receipt");?></h4>
      </div>
      <div class="modal-body" id="modal-body">
         <div id="printSection">
            <!-- Ticket goes here -->
            <center><h1 style="color:#34495E"><?=label("empty");?></h1></center>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default hiddenpr" onclick="closeModal()"><?=label("Close");?></button>
        <button type="button" class="btn btn-add hiddenpr" onclick="PrintTicket()"><?=label("print");?></button>
      </div>
    </div>
 </div>
</div>
<!-- /.Modal -->
</center>
</body>
</head>
</html>