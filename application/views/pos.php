<!-- Page Content -->
<?php if (!$this->session->userdata('register'))
{?>
   <div class="container container-small">
      <div class="row">
         <h1 class="text-center choose_store"> <?=label('ChooseStore');?> </h1>
      </div>
      <div class="row">
         <ul id="storeline">
           <?php if($this->user->role !== 'admin' && $this->user->role !== 'sales') { ?>
             <?php foreach ($Stores as $store):?>
               <?php if($this->user->store_id == $store->id) { ?>
             <a <?= $store->status == 1 ? "" : 'style="pointer-events: none; display: inline-block;opacity: 0.3;"';?> href="javascript:void(0)"  onclick="OpenRegister(<?=$store->status ? $store->status : 0;?>, <?=$store->id;?>, '<?=$this->user->role;?>')">
               <li class="listing clearfix">
                 <div class="image_wrapper">
                   <img src="<?=base_url()?>assets/img/store.svg" alt="store">
                 </div>
                 <div class="info">
                   <span class="store_title"><?=$store->name;?></span>
                   <span class="store_info"><?=$store->city;?> <span>&bull;</span> <?=$store->phone;?> <span>&bull;</span> <?=$store->email;?></span>
                 </div>
                 <span class="store_type <?= $store->status == 1 ? 'store_open' : 'store_close';?>"><?= $store->status == 1 ? label('open') : label('close');?></span>
               </li>
             </a>
             <?php } ?>
             <?php endforeach;?>
           <?php }else{ ?>
            <?php foreach ($Stores as $store):?>
            <a href="javascript:void(0)"  onclick="OpenRegister(<?=$store->status ? $store->status : 0;?>, <?=$store->id;?>, '<?=$this->user->role;?>')">
              <li class="listing clearfix">
                <div class="image_wrapper">
                  <img src="<?=base_url()?>assets/img/store.svg" alt="store">
                </div>
                <div class="info">
                  <span class="store_title"><?=$store->name;?></span>
                  <span class="store_info"><?=$store->city;?> <span>&bull;</span> <?=$store->phone;?> <span>&bull;</span> <?=$store->email;?></span>
                </div>
                <span class="store_type <?= $store->status == 1 ? 'store_open' : 'store_close';?>"><?= $store->status == 1 ? label('open') : label('close');?></span>
              </li>
            </a>
            <?php endforeach;?>
            <?php } ?>
         </ul>
      </div>
   </div>
   <script type="text/javascript">

   var waitersCach = [];
   function OpenRegister(status, storeid, userRole){
      if(status == 0) {
         $('#waiterscach').load("<?php echo site_url('pos/storewaitercash')?>/"+storeid, function(){
            $( "[id='waiterid']" ).on('change', function() {
               var waiterID = $(this).attr("waiter-id");
               waitersCach[waiterID] = $(this).val();
               console.log(waitersCach);
            });
         });
         $('#CashinHand').modal('show');
         $('#store').val(storeid);
      }else {
         window.location.href = "<?php echo site_url('pos/openregister/')?>/" + storeid + "/" + userRole;
      }
   }

   // function opennewregister(){
   //    var CashinHand = $('#CashinHand').val();
   //    var store = $('#store').val();
   //    $.ajax({
   //        url : "<?php echo site_url('pos/openregister')?>",
   //        type: "POST",
   //        data: {cash: CashinHand, store: store, waitersCach: waitersCach},
   //        success: function(data)
   //        {
   //           window.location.href = "<?php echo site_url('pos/openregister/')?>/" + store;
   //        },
   //        error: function (jqXHR, textStatus, errorThrown)
   //        {
   //           alert("error");
   //        }
   //    });
   // }
   $(function() {
      $('#cachIH').submit(function(event){
         var CashinHand = $('#CashinHando').val();
         var store = $('#store').val();
         $.ajax({
             url : "<?php echo site_url('pos/openregister')?>",
             type: "POST",
             data: {cash: CashinHand, store: store, waitersCach: waitersCach},
             success: function(data)
             {
                window.location.href = "<?php echo site_url('pos/openregister/')?>/" + store;
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
                alert("error");
             }
         });
         event.preventDefault();
      });
});

   </script>
   <!-- Modal Cash in Hand -->
   <div class="modal fade" id="CashinHand" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" id="myModalLabel"><?=label("CashinHand");?></h4>
         </div>
         <form id="cachIH">
         <div class="modal-body">
               <div class="form-group">
                <label for="CashinHand"><?=label("CashinHand");?></label>
                <input type="number" step="any" name="cash" Required class="form-control" id="CashinHando" placeholder="<?=label("CashinHand");?>">
                <input type="hidden" name="store" class="form-control" id="store">
             </div><hr>
              <div id="waiterscach"></div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal"><?=label("Close");?></button>
           <button type="submit" class="btn btn-add"><?=label("Submit");?></button>
         </div>
      </form>
       </div>
    </div>
   </div>
   <!-- /.Modal -->
   <?php
}else { if (!$this->session->userdata('selectedTable'))
   {?>
      <!-- *************************************************** if no table was choosen ********************************** -->
      <div class="container">
         <ul class="cbp-vimenu">
         	<li data-toggle="tooltip"  data-html="true" data-placement="left" title="<?=label('CloseRegister');?>"><a href="javascript:void(0)" onclick="CloseRegister()"><i class="fa fa-times" aria-hidden="true"></i></a></li>
            <li data-toggle="tooltip"  data-html="true" data-placement="left" title="<?=label('SwitchStore');?>"><a href="pos/switshregister"><i class="fa fa-random" aria-hidden="true"></i></a></li>
         	<li data-toggle="tooltip"  data-html="true" data-placement="left" title="<?=label('Kitchenpage');?>"><a href="kitchens"><i class="fa fa-cutlery" aria-hidden="true"></i></a></li>
         </ul>
         <a class="btn btn-green float-right" style="margin-top:60px" href="pos/selectTable/0"><?=label("WalkinCustomer");?></a>
         <?=!$zones ? '<h4 style="margin-top:60px">'.label("NoTables").'</h4>' : '';?>
         <?php foreach ($zones as $zone):?>
         <div class="row">
            <h1 class="choose_store"> <?=$zone->name;?> </h1><hr>
         </div>
         <div class="row tablesrow">
            <?php foreach ($tables as $table):?>
               <?php if($table->zone_id == $zone->id) {?>
            <div class="col-sm-2 col-xs-4 tableList">
               <?php if($table->time != ''){?><span class="tabletime"><?=$table->time;?></span><?php } ?>
                  <a href="pos/selectTable/<?=$table->id;?>">
                       <img src="<?=base_url()?>assets/img/<?= $table->status == 1 ? 'tableB'.rand(1, 6).'.svg' : 'table.svg'; ?>" alt="store">
                       <h2><?=$table->name;?></h2>
                  </a>
            </div>
            <?php } ?>
            <?php endforeach;?>
         </div>
      <?php endforeach;?>

<?php
}else {?>





   <!-- *************************************************** if a table was choosen ********************************** -->
<div class="container-fluid">
   <div class="row text-center">
      <h3 style="font-family: 'Kaushan Script', cursive;"><?=$header;?></h3>
   </div>
   <div class="row">
      <ul class="cbp-vimenu2">
      	<li data-toggle="tooltip"  data-html="true" data-placement="left" title="<?=label('CancelAll');?>"><a href="javascript:void(0)" onclick="CloseTable()"><i class="fa fa-times" aria-hidden="true"></i></a></li>
      	<li data-toggle="tooltip"  data-html="true" data-placement="left" title="<?=label('Return');?>"><a href="pos/switshtable"><i class="fa fa-reply" aria-hidden="true"></i></a></li>
        <li data-toggle="tooltip"  data-html="true" data-placement="left" title="<?=label('Kitchenpage');?>"><a href="kitchens"><i class="fa fa-cutlery" aria-hidden="true"></i></a></li>
      </ul>
      <div class="col-md-5 left-side">
         <div class="row">
            <div class="row row-horizon">
               <span class="holdList">
                  <!-- list Holds goes here -->
               </span>
               <span class="Hold pl" onclick="AddHold()">+</i></span>
               <span class="Hold pl" onclick="RemoveHold()">-</span>
            </div>
         </div>
         <div class="col-xs-8">
            <h2><?=label("ChooseClient");?></h2>
         </div>
         <div class="col-xs-4 client-add">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#AddCustomer">
               <span class="fa-stack fa-lg" data-toggle="tooltip" data-placement="top" title="<?=label('AddNewCustomer');?>">
                  <i class="fa fa-square fa-stack-2x grey"></i>
                  <i class="fa fa-user-plus fa-stack-1x fa-inverse dark-blue"></i>
               </span>
            </a>
            <a href="javascript:void(0)" onclick="showticket()">
               <span class="fa-stack fa-lg" data-toggle="tooltip" data-placement="top" title="<?=label('ShowlastReceipt');?>">
                  <i class="fa fa-square fa-stack-2x grey"></i>
                  <i class="fa fa-ticket fa-stack-1x fa-inverse dark-blue"></i>
               </span>
            </a>
         </div>
         <div class="col-sm-6">
            <select class="js-select-options form-control" id="customerSelect">
              <option value="0"><?=label("WalkinCustomer");?></option>
              <?php foreach ($customers as $customer):?>
                 <option value="<?=$customer->id;?>"><?=$customer->name;?> / <?=$customer->phone;?></option>
              <?php endforeach;?>
            </select>
            <span class="hidden" id="customerS"></span>
         </div>
         <div class="col-sm-6">
            <select class="js-select-options form-control" id="WaiterName">
              <option value="0"><?=label("withoutWaiter");?></option>
              <?php foreach ($waiters as $waiter):?>
                 <option value="<?=$waiter->id;?>"><?=$waiter->name;?></option>
              <?php endforeach;?>
            </select>
            <span class="hidden" id="waiterS"></span>
         </div>
         <div class="col-sm-12">
            <form onsubmit="return barcode()">
               <input type="text" autofocus id="<?=strval($this->setting->keyboard) === '1' ? 'keyboard' : ''?>" class="form-control barcode" placeholder="<?=label('BarcodeScanner');?>">
            </form>
         </div>
         <div class="col-xs-5 table-header">
            <h3><?=label("Product");?></h3>
         </div>
         <div class="col-xs-2 table-header">
            <h3><?=label("price");?></h3>
         </div>
         <div class="col-xs-3 table-header nopadding">
            <h3 class="text-left"><?=label("Quantity");?></h3>
         </div>
         <div class="col-xs-2 table-header nopadding">
            <h3><?=label("Total");?></h3>
         </div>
         <div id="productList">
            <!-- product List goes here  -->
         </div>
         <div class="footer-section">
            <div class="table-responsive col-sm-12 totalTab">
               <table class="table">
                  <tr>
                     <td class="active" width="40%"><?=label("SubTotal");?></td>
                     <td class="whiteBg" width="60%"><span id="Subtot"></span> <?=$this->setting->currency?>
                        <span class="float-right"><b id="ItemsNum"><span></span> <?=label("item");?></b></span>
                     </td>
                  </tr>
                  <tr>
                     <td class="active"><?=label("OrderTAX");?></td>
                     <td class="whiteBg"><input type="text" value="<?=$this->setting->tax;?>" onchange="total_change()" id="<?=strval($this->setting->keyboard) === '1' ? 'num01' : ''?>" class="total-input TAX" placeholder="N/A"  maxlength="8">
                        <span class="float-right"><b id="taxValue"></b></span>
                     </td>
                  </tr>
                  <tr>
                     <td class="active"><?=label("Discount");?></td>
                     <td class="whiteBg"><input type="text" value="<?=$this->setting->discount;?>" onchange="total_change()" id="<?=strval($this->setting->keyboard) === '1' ? 'num02' : ''?>" class="total-input Remise" placeholder="N/A"  maxlength="8">
                        <span class="float-right"><b id="RemiseValue"></b></span>
                     </td>
                  </tr>
                  <tr>
                     <td class="active"><?=label("Total");?></td>
                     <td class="whiteBg light-blue text-bold"><span id="total"></span> <?=$this->setting->currency?></td>
                  </tr>
               </table>
            </div>
            <button type="button" onclick="cancelPOS()" class="btn btn-red col-md-6 flat-box-btn"><h5 class="text-bold"><?=label('CANCEL');?></h5></button>
            <button type="button" class="btn btn-green col-md-6 flat-box-btn" data-toggle="modal" data-target="#AddSale"><h5 class="text-bold"><?=label('PAYEMENT');?></h5></button>
         </div>

      </div>
      <div class="col-md-7 right-side nopadding">
         <div class="row row-horizon">
                  <span class="categories selectedGat" id=""><i class="fa fa-home"></i></span>
                  <?php foreach ($categories as $category):?>
                     <span class="categories" id="<?=$category->name;?>"><?=$category->name;?></span>
                  <?php endforeach;?>
               </div>
               <div class="col-sm-12">
                  <div id="searchContaner">
                      <div class="input-group stylish-input-group">
                          <input type="text" id="searchProd" class="form-control"  placeholder="<?=label('Search');?>" >
                          <span class="input-group-addon">
                              <button type="submit">
                                  <span class="glyphicon glyphicon-search"></span>
                              </button>
                          </span>
                      </div>
                  </div>
              </div>
              <!-- product list section -->
         <div id="productList2">
            <?php foreach ($products as $product):?>
               <?php $cheked = true;
               $invis = $product->h_stores;
               $invis = trim($invis, ",");
               $array = explode(',', $invis); //split string into array seperated by ', '
               foreach($array as $value) //loop over values
               {
                  $cheked = $value == $this->store ? false : $cheked;
               }
               if($cheked) {?>
               <div class="col-sm-2 col-xs-4">
                     <a href="javascript:void(0)" class="addPct" id="product-<?=$product->code;?>" onclick="add_posale('<?=$product->id;?>')">
                        <div class="product <?=$product->color;?> flat-box">
                           <h3 id="proname"><?=$product->name;?></h3>
                           <input type="hidden" id="idname-<?=$product->id;?>" name="name" value="<?=$product->name;?>" />
                           <input type="hidden" id="idprice-<?=$product->id;?>" name="price" value="<?=$product->price;?>" />
                           <input type="hidden" id="category" name="category" value="<?=$product->category;?>" />
                           <div class="mask">
                              <h3><?=number_format((float)$product->price, $this->setting->decimals, '.', '');?> <?=$this->setting->currency;?></h3>
                              <p><?=character_limiter($product->description, 40);?></p>
                           </div>
                           <?php if($product->photo){ ?><img src="<?=base_url()?>files/products/<?=$product->photothumb;?>" alt="<?=$product->name;?>"><?php } ?>
                        </div>
                     </a>
               </div>
               <?php } ?>
            <?php endforeach;?>
         </div>
      </div>
   </div>
</div>

<!-- /.container -->
<script type="text/javascript">

$(document).ready(function() {
   $('#productList').load("<?php echo site_url('pos/load_posales')?>");
   $('#Subtot').load("<?php echo site_url('pos/subtot')?>", null, total_change);
   $('#ItemsNum span, #ItemsNum2 span').load("<?php echo site_url('pos/totiems')?>");
   $('.holdList').load("<?php echo site_url('pos/holdList/'.$this->register)?>", function(){
      var holdi = $('.selectedHold').attr("id");
      $('#waiterS').load("<?php echo site_url('pos/WaiterName')?>/"+holdi, function(){
         var res = $('#waiterS').text();
         if(res>0) {$('#WaiterName').val(res).trigger("change");}else{$('#WaiterName').val(0).trigger("change");}
      });
      $('#customerS').load("<?php echo site_url('pos/CustomerName')?>/"+holdi, function(){
         var res = $('#customerS').text();
         if(res>0) {$('#customerSelect').val(res).trigger("change");}else{$('#customerSelect').val(0).trigger("change");}
      });
   });

   $("#WaiterName").on('change', function(){
      var num = $('.selectedHold').attr("id");
      var id = $(this).val();
     $.ajax({
         url : "<?php echo site_url('pos/changewaiterS')?>/",
         data: {num: num,id: id},
         type: "POST",
         success: function(data){},
         error: function (jqXHR, textStatus, errorThrown)
         {
            alert("error");
         }
     });
   });

   $("#customerSelect").on('change', function(){
      var num = $('.selectedHold').attr("id");
      var id = $(this).val();
     $.ajax({
         url : "<?php echo site_url('pos/changecustomerS')?>/",
         data: {num: num,id: id},
         type: "POST",
         success: function(data){},
         error: function (jqXHR, textStatus, errorThrown)
         {
            alert("error");
         }
     });
   });


   $('.Paid').show();
   $('.ReturnChange').show();
   $('.CreditCardNum').hide();
   $('.CreditCardHold').hide();
   $('.ChequeNum').hide();
   $('.stripe-btn').hide();



   $("#paymentMethod").change(function(){

      var p_met = $(this).find('option:selected').val();

      if (p_met === '0') {
         $('.Paid').show();
         $('.ReturnChange').show();
         $('.CreditCardNum').hide();
         $('.CreditCardHold').hide();
         $('.CreditCardMonth').hide();
         $('.CreditCardYear').hide();
         $('.CreditCardCODECV').hide();
         $('#CreditCardNum').val('');
         $('#CreditCardHold').val('');
         $('#CreditCardYear').val('');
         $('#CreditCardMonth').val('');
         $('#CreditCardCODECV').val('');
         $('.stripe-btn').hide();
         $('.ChequeNum').hide();
      } else if (p_met === '1') {
         $('.Paid').show();
         $('.ReturnChange').hide();
         $('.CreditCardNum').show();
         $('.CreditCardHold').show();
         $('.CreditCardMonth').show();
         $('.CreditCardYear').show();
         $('.CreditCardCODECV').show();
         $('.stripe-btn').show();
         $('.ChequeNum').hide();
      } else if (p_met === '2') {
         $('.Paid').hide();
         $('.ReturnChange').hide();
         $('.CreditCardNum').hide();
         $('.CreditCardHold').hide();
         $('.CreditCardMonth').hide();
         $('.CreditCardYear').hide();
         $('.CreditCardCODECV').hide();
         $('#CreditCardNum').val('');
         $('#CreditCardHold').val('');
         $('#CreditCardYear').val('');
         $('#CreditCardMonth').val('');
         $('#CreditCardCODECV').val('');
         $('.stripe-btn').hide();
         $('.ChequeNum').show();
      }

   });
   /********************************* Credit Card infos section ****************************************/
   $('#CreditCardNum').validateCreditCard(function(result) {
      var cardtype = result.card_type == null ? '-' : result.card_type.name;
      $('.CreditCardNum i').removeClass('dark-blue');
      $('#' + cardtype).addClass('dark-blue');
   });

   $('#CreditCardNum').keypress(function (e) {
      var data = $(this).val();
      if(data.length > 22){

       if (e.keyCode == 13) {
           e.preventDefault();

           var c = new SwipeParserObj(data);

               $('#CreditCardNum').val(c.account);
               $('#CreditCardHold').val(c.account_name);
               $('#CreditCardYear').val(c.exp_year);
               $('#CreditCardMonth').val(c.exp_month);
               $('#CreditCardCODECV').val('');

           }
           else {
               $('#CreditCardNum').val('');
               $('#CreditCardHold').val('');
               $('#CreditCardYear').val('');
               $('#CreditCardMonth').val('');
               $('#CreditCardCODECV').val('');
           }

           $('#CreditCardCODECV').focus();
           $('#CreditCardNum').validateCreditCard(function(result) {
              var cardtype = result.card_type == null ? '-' : result.card_type.name;
              $('.CreditCardNum i').removeClass('dark-blue');
              $('#' + cardtype).addClass('dark-blue');
           });
   }

   });


   // ********************************* change calculations
   $('#Paid').on('keyup',function() {
      var change = -(parseFloat($('#total').text()) - parseFloat($(this).val()));
      if(change < 0){
         $('#ReturnChange span').text(change.toFixed(<?=$this->setting->decimals;?>));
         $('#ReturnChange span').addClass( "red" );
         $('#ReturnChange span').removeClass( "light-blue" );
      }else{
         $('#ReturnChange span').text(change.toFixed(<?=$this->setting->decimals;?>));
         $('#ReturnChange span').removeClass( "red" );
         $('#ReturnChange span').addClass( "light-blue" );
      }
    });



    //  search product
   $("#searchProd").keyup(function(){
      // Retrieve the input field text
      var filter = $(this).val();
      // Loop through the list
      $("#productList2 #proname").each(function(){
         // If the list item does not contain the text phrase fade it out
         if ($(this).text().search(new RegExp(filter, "i")) < 0) {
             $(this).parent().parent().parent().hide();
         // Show the list item if the phrase matches
         } else {
             $(this).parent().parent().parent().show();
         }
      });
   });
});
// barcode scanner
function barcode(){
   var code = $('.barcode').val();
   $.ajax({
       url : "<?php echo site_url('pos/findproduct')?>/"+code,
       type: "POST",
       dataType: "JSON",
       success: function(data)
       {
          add_posale(data);
          $('.barcode').val('');
       },
       error: function (jqXHR, textStatus, errorThrown)
       {
          alert("error");
       }
   });
   return false;
};

//  **********************select categorie

$(".categories").on("click", function () {
   // Retrieve the input field text
   var filter = $(this).attr('id');
   $(this).parent().children().removeClass('selectedGat');

   $(this).addClass('selectedGat');
   // Loop through the list
   $("#productList2 #category").each(function(){
      // If the list item does not contain the text phrase fade it out
      if ($(this).val().search(new RegExp(filter, "i")) < 0) {
         $(this).parent().parent().parent().hide();
         // Show the list item if the phrase matches
      } else {
         $(this).parent().parent().parent().show();
      }
   });
});
// function to calculate a percentage from a number
function percentage(tot, n) {
   var perc;
   perc = ((parseFloat(tot) * (parseFloat(n ? n : 0)*0.01)));
   return perc;
}
// function to calculate the total number
function total_change() {
   var tot;
   if ( ($('.TAX').val().indexOf('%') == -1) && ($('.Remise').val().indexOf('%') == -1) ) {
      tot = parseFloat($('#Subtot').text().replace(/ /g,'')) + parseFloat($('.TAX').val() ? $('.TAX').val() : 0);
      $('#taxValue').text('<?=$this->setting->currency;?>');
      $('#RemiseValue').text('<?=$this->setting->currency;?>');
      tot = tot - parseFloat($('.Remise').val() ? $('.Remise').val() : 0);
      $('#total').text(tot.toFixed(<?=$this->setting->decimals;?>));
      $('#Paid').val(tot.toFixed(<?=$this->setting->decimals;?>));
      $('#TotalModal').text('<?=label("Total");?> '+tot.toFixed(<?=$this->setting->decimals;?>)+' <?=$this->setting->currency;?>');
   }else if ( ($('.TAX').val().indexOf('%') != -1) && ($('.Remise').val().indexOf('%') == -1) ) {
      tot = parseFloat($('#Subtot').text()) + percentage($('#Subtot').text(), $('.TAX').val());
      $('#taxValue').text(percentage($('#Subtot').text(), $('.TAX').val()).toFixed(<?=$this->setting->decimals;?>) + ' <?=$this->setting->currency;?>');
      $('#RemiseValue').text('<?=$this->setting->currency;?>');
      tot = tot - parseFloat($('.Remise').val() ? $('.Remise').val() : 0);
      $('#total').text(tot.toFixed(<?=$this->setting->decimals;?>));
      $('#Paid').val(tot.toFixed(<?=$this->setting->decimals;?>));
      $('#TotalModal').text('<?=label("Total");?> '+tot.toFixed(<?=$this->setting->decimals;?>)+' <?=$this->setting->currency;?>');
   }else if ( ($('.TAX').val().indexOf('%') != -1) && ($('.Remise').val().indexOf('%') != -1) ) {
      tot = parseFloat($('#Subtot').text()) + percentage($('#Subtot').text(), $('.TAX').val());
      $('#taxValue').text(percentage($('#Subtot').text(), $('.TAX').val()).toFixed(<?=$this->setting->decimals;?>) + ' <?=$this->setting->currency;?>');
      tot = tot - percentage($('#Subtot').text(), $('.Remise').val());
      $('#RemiseValue').text(percentage($('#Subtot').text(), $('.Remise').val()).toFixed(<?=$this->setting->decimals;?>) + ' <?=$this->setting->currency;?>');
      $('#total').text(tot.toFixed(<?=$this->setting->decimals;?>));
      $('#Paid').val(tot.toFixed(<?=$this->setting->decimals;?>));
      $('#TotalModal').text('<?=label("Total");?> '+tot.toFixed(<?=$this->setting->decimals;?>)+' <?=$this->setting->currency;?>');
   }else if ( ($('.TAX').val().indexOf('%') == -1) && ($('.Remise').val().indexOf('%') != -1) ) {
      tot = parseFloat($('#Subtot').text()) + parseFloat($('.TAX').val() ? $('.TAX').val() : 0);
      tot = tot - percentage($('#Subtot').text(), $('.Remise').val());
      $('#taxValue').text('<?=$this->setting->currency;?>');
      $('#RemiseValue').text(percentage($('#Subtot').text(), $('.Remise').val()).toFixed(<?=$this->setting->decimals;?>) + ' <?=$this->setting->currency;?>');
      $('#total').text(tot.toFixed(<?=$this->setting->decimals;?>));
      $('#Paid').val(tot.toFixed(<?=$this->setting->decimals;?>));
      $('#TotalModal').text('<?=label("Total");?> '+tot.toFixed(<?=$this->setting->decimals;?>)+' <?=$this->setting->currency;?>');
   }
}


function delete_posale(id)
{
  // ajax delete data to database
  $.ajax({
      url : "<?php echo site_url('pos/delete')?>/"+id,
      type: "POST",
      dataType: "JSON",
      success: function(data)
      {
         $('#productList').load("<?php echo site_url('pos/load_posales')?>");
         $('#ItemsNum span, #ItemsNum2 span').load("<?php echo site_url('pos/totiems')?>");
         $('#Subtot').load("<?php echo site_url('pos/subtot')?>", null, total_change);
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
         alert("error");
      }
  });

}

/********************************** Hold functions ************************************/
function AddHold()
{
  $.ajax({
      url : "<?php echo site_url('pos/AddHold')?>/<?=$this->register?>",
      type: "POST",
      dataType: "JSON",
      success: function(data)
      {
         $('#productList').load("<?php echo site_url('pos/load_posales')?>");
         $('#ItemsNum span, #ItemsNum2 span').load("<?php echo site_url('pos/totiems')?>");
         $('#Subtot').load("<?php echo site_url('pos/subtot')?>", null, total_change);
         $('.holdList').load("<?php echo site_url('pos/holdList/'.$this->register)?>");
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
         alert("error");
      }
  });

}

function RemoveHold()
{
   var number = $('.selectedHold').clone().children().remove().end().text();
   if(number !=1) {
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
            url : "<?php echo site_url('pos/RemoveHold')?>/"+number+"/<?=$this->register;?>",
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               $('#productList').load("<?php echo site_url('pos/load_posales')?>");
               $('#ItemsNum span, #ItemsNum2 span').load("<?php echo site_url('pos/totiems')?>");
               $('#Subtot').load("<?php echo site_url('pos/subtot')?>", null, total_change);
               $('.holdList').load("<?php echo site_url('pos/holdList/'.$this->register)?>");
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
               alert("error");
            }
        });
      swal.close(); });
   }

}

function SelectHold(number)
{
  // ajax delete data to database
  $.ajax({
      url : "<?php echo site_url('pos/SelectHold')?>/"+number,
      type: "POST",
      dataType: "JSON",
      success: function(data)
      {
         $('#productList').load("<?php echo site_url('pos/load_posales')?>");
         $('#ItemsNum span, #ItemsNum2 span').load("<?php echo site_url('pos/totiems')?>");
         $('#Subtot').load("<?php echo site_url('pos/subtot')?>", null, total_change);
         $('#'+number).parent().children().removeClass('selectedHold');
         $('#'+number).addClass('selectedHold');
         $('#waiterS').load("<?php echo site_url('pos/WaiterName')?>/"+number, function(){
            var res = $('#waiterS').text();
            if(res>0) {$('#WaiterName').val(res).trigger("change");}else{$('#WaiterName').val(0).trigger("change");}
         });
         $('#customerS').load("<?php echo site_url('pos/CustomerName')?>/"+number, function(){
            var res = $('#customerS').text();
            if(res>0) {$('#customerSelect').val(res).trigger("change");}else{$('#customerSelect').val(0).trigger("change");}
         });
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
         alert("error");
      }
  });

}

/********************************** end Hold functions ************************************/

function add_posale(id)
{
   var name1 = $('#idname-'+id).val();
   var price1 = $('#idprice-'+id).val();
   var number = $('.selectedHold').clone().children().remove().end().text();
   var waiterID = $('#WaiterName').find('option:selected').val();
     // ajax delete data to database
     $.ajax({
         url : "<?php echo site_url('pos/addpdc')?>/",
         type: "POST",
         data: {name: name1, price: price1, product_id: id, number: number, registerid: <?=$this->register;?>, waiter: waiterID},
         success: function(data)
         {
            if(data === 'stock'){
               swal("<?=label("Lowinventory");?>");
            }else{
                $('#productList').load("<?php echo site_url('pos/load_posales')?>");
                $('#ItemsNum span, #ItemsNum2 span').load("<?php echo site_url('pos/totiems')?>");
                $('#Subtot').load("<?php echo site_url('pos/subtot')?>", null, total_change);
            }
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
            alert("error");
         }
     });

}


function addoptions(id, posale)
{
   $('#optionsSection').load("<?php echo site_url('pos/getoptions')?>/"+id+"/"+posale, function(){
      $(".js-select-basic-multiple").select2();
   });
   $('#options').modal('show');
}

function addPoptions()
{
   var options = $('#optionsselect').val();
   var posale = $('#optprd').val();
   $.ajax({
       url : "<?php echo site_url('pos/addposaleoptions')?>",
       type: "POST",
       data: {options: options, posale: posale},
       success: function(data)
       {
          $('#options').modal('hide');
          $('#pooptions-'+posale).text(options);
       },
       error: function (jqXHR, textStatus, errorThrown)
       {
          alert("error");
       }
   });
}

function edit_posale(id)
{
   var qt1 = $('#qt-'+id).val();
        $.ajax({
            url : "<?php echo site_url('pos/edit')?>/"+id,
            type: "POST",
            data: {qt: qt1},
            success: function(data)
            {
               if(data === 'stock'){
                  swal("<?=label("Lowinventory");?>");
                  $('#productList').load("<?php echo site_url('pos/load_posales')?>");
               }else{
                   $('#productList').load("<?php echo site_url('pos/load_posales')?>");
                   $('#ItemsNum span, #ItemsNum2 span').load("<?php echo site_url('pos/totiems')?>");
                   $('#Subtot').load("<?php echo site_url('pos/subtot')?>", null, total_change);
               }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
               alert("error");
            }
        });

}


$("#customerSelect").change(function(){

  var id = $(this).find('option:selected').val();
  if(id === '0') {
      $('.Remise').val('<?=$this->setting->discount;?>');
  } else {
     $.ajax({
         url : "<?php echo site_url('pos/GetDiscount')?>/"+id,
         type: "POST",
         success: function(data)
         {
            var values = data.split('~');
            $('#customerName span').text(values[1]);
            $('.Remise').val(values[0]);
            $('#Subtot').load("<?php echo site_url('pos/subtot')?>", null, total_change);
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
            alert("error");
         }
    });
 }
});

function cancelPOS(){
   swal({   title: '<?=label("Areyousure");?>',
   text: '<?=label("Deletemessage");?>',
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#DD6B55",
   confirmButtonText: '<?=label("yesiam");?>',
   closeOnConfirm: false },
   function(){

  $('#customerSelect').val('0');
  $('#customerSelect').trigger('change.select2');
  $('.Remise').val('<?=$this->setting->discount;?>');
  $('.TAX').val('<?=$this->setting->tax;?>');

  $.ajax({
      url : "<?php echo site_url('pos/ResetPos')?>/",
      type: "POST",
      success: function(data)
      {
          $('#productList').load("<?php echo site_url('pos/load_posales')?>");
          $('#Subtot').load("<?php echo site_url('pos/subtot')?>", null, total_change);
          $('#ItemsNum span, #ItemsNum2 span').text("0");
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
         alert("error");
      }
 });
 swal('<?=label("Deleted");?>', '<?=label("Deletedmessage");?>', "success"); });
};


function saleBtn(type) {
   var clientID = $('#customerSelect').find('option:selected').val();
   var clientName = $('#customerName span').text();
   var Tax = $('.TAX').val();
   var Discount = $('.Remise').val();
   var Subtotal = $('#Subtot').text();
   var Total = $('#total').text();
   var createdBy = '<?php echo $this->user->firstname." ".$this->user->lastname;?>';
   var totalItems = $('#ItemsNum span').text();
   var Paid = $('#Paid').val();
   var paidMethod = $('#paymentMethod').find('option:selected').val();
   var Status = 0;
   var ccnum = $('#CreditCardNum').val();
   var ccmonth = $('#CreditCardMonth').val();
   var ccyear = $('#CreditCardYear').val();
   var ccv = $('#CreditCardCODECV').val();
   var waiter = $('#WaiterName').val();
   switch(paidMethod) {
       case '1':
           paidMethod += '~'+$('#CreditCardNum').val()+'~'+$('#CreditCardHold').val();
           break;
       case '2':
           paidMethod += '~'+$('#ChequeNum').val()
           break;
       case '0':
           var change = parseFloat(Total) - parseFloat(Paid);
           if(change==parseFloat(Total)) Status = 1;
           else if(change>0) Status = 2;
           else if(change<=0) Status = 0;
   }
   var taxamount = $('.TAX').val().indexOf('%') != -1 ? parseFloat($('#taxValue').text()) : $('.TAX').val();
   var discountamount = $('.Remise').val().indexOf('%') != -1 ? parseFloat($('#RemiseValue').text()) : $('.Remise').val();

  $.ajax({
      url : "<?php echo site_url('pos/AddNewSale')?>/"+type,
      type: "POST",
      data: {client_id: clientID, clientname: clientName, waiter_id: waiter, discountamount: discountamount, taxamount: taxamount, tax: Tax, discount: Discount, subtotal: Subtotal, total: Total, created_by: createdBy, totalitems: totalItems, paid: Paid, status: Status, paidmethod: paidMethod, ccnum: ccnum, ccmonth: ccmonth, ccyear: ccyear, ccv: ccv},
      success: function(data)
      {
         $('#printSection').html(data);
         $('#productList').load("<?php echo site_url('pos/load_posales')?>");
         $('#ItemsNum span, #ItemsNum2 span').load("<?php echo site_url('pos/totiems')?>");
         $('#Subtot').load("<?php echo site_url('pos/subtot')?>", null, total_change);
         $('#AddSale').modal('hide');
         $('#ticket').modal('show');
         $('#ReturnChange span').text('0');
         $('#Paid').val('0');
         $('.holdList').load("<?php echo site_url('pos/holdList/'.$this->register)?>");
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
         alert("error");
      }
  });

  $('#CreditCardNum').val('');
  $('#CreditCardHold').val('');
  $('#CreditCardYear').val('');
  $('#CreditCardMonth').val('');
  $('#CreditCardCODECV').val('');

}

function PrintTicket() {
   $('.modal-body').removeAttr('id');
   window.print();
   $('.modal-body').attr('id', 'modal-body');
}



function email()
{
   $('#ticket').modal('hide');
   swal({
      title: "An input!",
      text: "Email:",
      type: "input",
      showCancelButton: true,
      closeOnConfirm: false,
      animation: "slide-from-top",
      inputPlaceholder: "Email" },
      function(inputValue){
         if (inputValue === false) return false;
         if (inputValue === "") {
            swal.showInputError("You need to write an email!");
            return false   }
            var content = $('#printSection').html();
            $.ajax({
               url : "<?php echo site_url('pos/email')?>/",
               type: "POST",
               data: {content: content, email: inputValue},
               success: function(data)
               {
                  $('#ticket').modal('show');
                  swal.close();
               },
               error: function (jqXHR, textStatus, errorThrown)
               {
                   alert("error");
               }
            });
             });
}

function pdfreceipt(){


   var content = $('#printSection').html();
   $.redirect('<?php echo site_url('pos/pdfreceipt')?>/', { content: content });

}

function showticket(){
   var hold = $('.selectedHold').attr("id");
   var Total = $('#total').text();
   var totalItems = $('#ItemsNum span').text();
   var waiter = $('#WaiterName').val();
   $('#printSection').load("<?php echo site_url('pos/showticket')?>/"+hold+"/"+Total+"/"+totalItems+"/"+waiter);
   $('#ticket').modal('show');
}


function myFunction() {
    window.print();
}

</script>


<!-- Modal -->
<div class="modal fade" id="AddSale" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="AddSale"><?=label("AddSale");?></h4>
      </div>
      <form>
      <div class="modal-body">
            <div class="form-group">
               <h2 id="customerName"><?=label("Customer");?> <span><?=label("WalkinCustomer");?></span></h2>
           </div>
           <div class="form-group">
             <h3 id="ItemsNum2"><span></span> <?=label("item");?></h3>
          </div>
           <div class="form-group">
             <h2 id="TotalModal"></h2>
          </div>
           <div class="form-group">
             <label for="paymentMethod"><?=label("paymentMethod");?></label>
             <select class="js-select-options form-control" id="paymentMethod">
               <option value="0"><?=label("Cash");?></option>
               <option value="1"><?=label("CreditCard");?></option>
               <option value="2"><?=label("Cheque");?></option>
            </select>
           </div>
           <div class="form-group Paid">
             <label for="Paid"><?=label("Paid");?></label>
             <input type="text" value="0" name="paid" class="form-control <?=strval($this->setting->keyboard) === '1' ? 'paidk' : ''?>" id="Paid" placeholder="<?=label("Paid");?>">
           </div>
           <div class="form-group CreditCardNum">
             <i class="fa fa-cc-visa fa-2x" id="visa" aria-hidden="true"></i>
             <i class="fa fa-cc-mastercard fa-2x" id="mastercard" aria-hidden="true"></i>
             <i class="fa fa-cc-amex fa-2x" id="amex" aria-hidden="true"></i>
             <i class="fa fa-cc-discover fa-2x" id="discover" aria-hidden="true"></i>
             <label for="CreditCardNum"><?=label("CreditCardNum");?></label>
             <input type="text" class="form-control cc-num" id="CreditCardNum" placeholder="<?=label("CreditCardNum");?>">
           </div>
           <div class="clearfix"></div>
           <div class="form-group CreditCardHold col-md-4 padding-s">
             <input type="text" class="form-control" id="CreditCardHold" placeholder="<?=label("CreditCardHold");?>">
           </div>
           <div class="form-group CreditCardHold col-md-2 padding-s">
             <input type="text" class="form-control" id="CreditCardMonth" placeholder="<?=label("Month");?>">
           </div>
           <div class="form-group CreditCardHold col-md-2 padding-s">
             <input type="text" class="form-control" id="CreditCardYear" placeholder="<?=label("Year");?>">
           </div>
           <div class="form-group CreditCardHold col-md-4 padding-s">
             <input type="text" class="form-control" id="CreditCardCODECV" placeholder="<?=label("CODECV");?>">
           </div>
           <div class="form-group ChequeNum">
             <label for="ChequeNum"><?=label("ChequeNum");?></label>
             <input type="text" name="chequenum" class="form-control" id="ChequeNum" placeholder="<?=label("ChequeNum");?>">
           </div>
          <div class="form-group ReturnChange">
             <h3 id="ReturnChange"><?=label("Change");?> <span>0</span> <?=$this->setting->currency;?></h3>
          </div>
          <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=label("Close");?></button>
        <?=strval($this->setting->stripe) === '1' ? '<button type="button" class="btn btn-add stripe-btn" onclick="saleBtn(2)"><i class="fa fa-cc-stripe" aria-hidden="true"></i> '.label("StripePayment").'</button>' : ''; ?>
        <button type="button" class="btn btn-add" onclick="saleBtn(1)"><?=label("Submit");?></button>
      </div>
   <?php echo form_close(); ?>
    </div>
 </div>
</div>
<!-- /.Modal -->


<!-- Modal ticket -->
<div class="modal fade" id="ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document" id="ticketModal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ticket"><?=label("Receipt");?></h4>
      </div>
      <div class="modal-body" id="modal-body">
         <div id="printSection">
            <!-- Ticket goes here -->
            <center><h1 style="color:#34495E"><?=label("empty");?></h1></center>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal"><?=label("Close");?></button>
        <button type="button" class="btn btn-add hiddenpr" href="javascript:void(0)" onClick="pdfreceipt()">PDF</button>
        <button type="button" class="btn btn-add hiddenpr" onclick="email()"><?=label("email");?></button>
        <button type="button" class="btn btn-add hiddenpr" onclick="PrintTicket()"><?=label("print");?></button>
        <button onclick="myFunction()">Print this page</button>
      </div>
    </div>
 </div>
</div>
<!-- /.Modal -->

<!-- Modal options -->
<div class="modal fade" id="options" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document" id="ticketModal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ticket"><?=label("Options");?></h4>
      </div>
      <div class="modal-body" id="modal-body">
         <div id="optionsSection">
            <!-- Ticket goes here -->
            <center><h1 style="color:#34495E"><?=label("empty");?></h1></center>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal"><?=label("Close");?></button>
        <button type="submit" class="btn btn-add" onclick="addPoptions()"><?=label("Submit");?></button>
      </div>
    </div>
 </div>
</div>
<!-- /.Modal -->

<!-- Modal add user -->
<div class="modal fade" id="AddCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("AddCustomer");?></h4>
      </div>
      <?php echo form_open_multipart('customers/add'); ?>
      <div class="modal-body">
            <div class="form-group">
             <label for="CustomerName"><?=label("CustomerName");?></label>
             <input type="text" name="name" class="form-control" id="CustomerName" placeholder="<?=label("CustomerName");?>">
           </div>
           <div class="form-group">
             <label for="CustomerPhone"><?=label("CustomerPhone");?></label>
             <input type="text" name="phone" class="form-control" id="CustomerPhone" placeholder="<?=label("CustomerPhone");?>">
           </div>
           <div class="form-group">
             <label for="CustomerEmail"><?=label("CustomerEmail");?></label>
             <input type="email" name="email" class="form-control" id="CustomerEmail" placeholder="<?=label("CustomerEmail");?>">
           </div>
           <div class="form-group">
             <label for="CustomerDiscount"><?=label("CustomerDiscount");?></label>
             <input type="text" name="discount" class="form-control" id="CustomerDiscount" placeholder="<?=label("CustomerDiscount");?>">
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


<?php } ?>
<?php } ?>

<script type="text/javascript">
function CloseRegister() {
   $.ajax({
      url : "<?php echo site_url('pos/CloseRegister')?>/",
      type: "POST",
      success: function(data)
      {
         $('#closeregsection').html(data);
         $('#CloseRegister').modal('show');
         setTimeout(function(){$('#countedcash').focus()}, 1000);
         $('#countedcash').on('keyup',function() {
           var change = -(parseFloat($('#expectedcash').text()) - parseFloat($(this).val()));
           var difftot = change + parseFloat($('#diffcc').text()) + parseFloat($('#diffcheque').text());
           var total = parseFloat($('#countedcc').val()) + parseFloat($('#countedcheque').val()) + parseFloat($('#countedcash').val());
           $('#countedtotal').text(total.toFixed(<?=$this->setting->decimals;?>));
           $('#difftotal').text(difftot.toFixed(<?=$this->setting->decimals;?>))
           if(change < 0){
               $('#diffcash').text(change.toFixed(<?=$this->setting->decimals;?>));
               $('#diffcash').addClass( "red" );
               $('#diffcash').removeClass( "light-blue" );
           }else{
               $('#diffcash').text(change.toFixed(<?=$this->setting->decimals;?>));
               $('#diffcash').removeClass( "red" );
               $('#diffcash').addClass( "light-blue" );
           }
         });

         $('#countedcc').on('keyup',function() {
           var change = -(parseFloat($('#expectedcc').text()) - parseFloat($(this).val()));
           var difftot = change + parseFloat($('#diffcash').text()) + parseFloat($('#diffcheque').text());
           var total = parseFloat($('#countedcc').val()) + parseFloat($('#countedcheque').val()) + parseFloat($('#countedcash').val());
           $('#countedtotal').text(total.toFixed(<?=$this->setting->decimals;?>));
           $('#difftotal').text(difftot.toFixed(<?=$this->setting->decimals;?>))
           if(change < 0){
               $('#diffcc').text(change.toFixed(<?=$this->setting->decimals;?>));
               $('#diffcc').addClass( "red" );
               $('#diffcc').removeClass( "light-blue" );
           }else{
               $('#diffcc').text(change.toFixed(<?=$this->setting->decimals;?>));
               $('#diffcc').removeClass( "red" );
               $('#diffcc').addClass( "light-blue" );
           }
         });

         $('#countedcheque').on('keyup',function() {
           var change = -(parseFloat($('#expectedcheque').text()) - parseFloat($(this).val()));
           var difftot = change + parseFloat($('#diffcc').text()) + parseFloat($('#diffcash').text());
           var total = parseFloat($('#countedcc').val()) + parseFloat($('#countedcheque').val()) + parseFloat($('#countedcash').val());
           $('#countedtotal').text(total.toFixed(<?=$this->setting->decimals;?>));
           $('#difftotal').text(difftot.toFixed(<?=$this->setting->decimals;?>))
           if(change < 0){
               $('#diffcheque').text(change.toFixed(<?=$this->setting->decimals;?>));
               $('#diffcheque').addClass( "red" );
               $('#diffcheque').removeClass( "light-blue" );
           }else{
               $('#diffcheque').text(change.toFixed(<?=$this->setting->decimals;?>));
               $('#diffcheque').removeClass( "red" );
               $('#diffcheque').addClass( "light-blue" );
           }
         });
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert("error");
      }
   });
}

function SubmitRegister() {
   var expectedcash = $('#expectedcash').text();
   var countedcash = $('#countedcash').val();
   var expectedcc = $('#expectedcc').text();
   var countedcc = $('#countedcc').val();
   var expectedcheque = $('#expectedcheque').text();
   var countedcheque = $('#countedcheque').val();
   var RegisterNote = $('#RegisterNote').val();

   swal({   title: '<?=label("Areyousure");?>',
   text: '<?=label("CloseMessageRegister");?>',
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#DD6B55",
   confirmButtonText: '<?=label("yesClose");?>',
   closeOnConfirm: false },
   function(){

   $.ajax({
      url : "<?php echo site_url('pos/SubmitRegister')?>/",
      type: "POST",
      data: {expectedcash: expectedcash, countedcash: countedcash, expectedcc: expectedcc, countedcc: countedcc, expectedcheque: expectedcheque, countedcheque: countedcheque, RegisterNote: RegisterNote},
      success: function(data)
      {
         window.location.href = "<?php echo site_url()?>";
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert("error");
      }
   });

   swal.close(); });
}

function CloseTable() {

   swal({   title: '<?=label("Areyousure");?>',
   text: '<?=label("CloseMessageRegister");?>',
   type: "warning",
   showCancelButton: true,
   confirmButtonColor: "#DD6B55",
   confirmButtonText: '<?=label("yesClose");?>',
   closeOnConfirm: false },
   function(){

   $.ajax({
      url : "<?php echo site_url('pos/CloseTable')?>/",
      type: "POST",
      success: function(data)
      {
         window.location.href = "<?php echo site_url()?>";
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert("error");
      }
   });

   swal.close(); });
}

</script>
<!-- Modal close register -->
<div class="modal fade" id="CloseRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("CloseRegister");?></h4>
      </div>
      <div class="modal-body">
         <div id="closeregsection">
            <!-- close register detail goes here -->
         </div>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0)" onclick="SubmitRegister()" class="btn btn-red col-md-12 flat-box-btn"><?=label("CloseRegister");?></a>
      </div>
    </div>
 </div>
</div>
<!-- /.Modal -->
