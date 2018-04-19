<!-- Page Content -->
<div class="container">
   <div class="row" style="margin-top:100px;">
      <div class="col-md-12">
         <!-- tab navigation -->
         <?php $tab = (isset($_GET['tab'])) ? $_GET['tab'] : null; ?>
         <ul class="nav nav-tabs">
            <li class="<?php echo ($tab == 'setting') ? 'active' : ''; ?>"><a href="#setting" data-toggle="tab"><i class="fa fa-cog" aria-hidden="true"></i> <?=label("Settings");?></a></li>
            <li class="<?php echo ($tab == 'users') ? 'active' : ''; ?>"><a href="#users" data-toggle="tab"><i class="fa fa-users" aria-hidden="true"></i> <?=label("users");?></a></li>
            <li class="<?php echo ($tab == 'warehouses') ? 'active' : ''; ?>"><a href="#warehouses" data-toggle="tab"><i class="fa fa-building" aria-hidden="true"></i> <?=label("Warehouses");?></a></li>
         </ul>

         <!-- tab sections -->
         <div class="tab-content">
            <!-- General setting tab -->
            <div class="tab-pane fade in <?php echo ($tab == 'setting') ? 'active' : ''; ?>" id="setting">
               <h1><?=label("Settings");?></h1>
               <p><?=label("SettingsDesciption");?></p>
               <?php echo form_open_multipart('settings/updateSettings'); ?>
                 <div class="form-group col-md-6">
                   <label for="companyName"><?=label("Company");?></label>
                   <input type="text" value="<?=$this->setting->companyname;?>" name="companyname" class="form-control" id="companyName" placeholder="<?=label("Company");?>">
                 </div>
                 <div class="form-group col-md-6">
                    <label for="logo"><?=label("CompanyLogo");?></label>
                    <input type="file" name="userfile" id="logo">
                    <?php if($this->setting->logo){ ?><img src="<?=base_url()?>files/Setting/<?=$this->setting->logo;?>" alt="" class="float-right" width="100px"/><?php } else { ?><img src="<?=base_url()?>assets/img/logo.png" alt="logo" class="float-right" width="100px"><?php } ?>
                 </div>
                 <div class="form-group col-md-6">
                   <label for="phone"><?=label("Phone");?></label>
                   <input type="text" value="<?=$this->setting->phone;?>" name="phone" class="form-control" id="phone" placeholder="<?=label("Phone");?>">
                 </div>
                 <div class="form-group col-md-6">
                   <label for="currency"><?=label("Currency");?></label>
                   <input type="text" value="<?=$this->setting->currency;?>" name="currency" class="form-control" id="currency" placeholder="<?=label("Currency");?>">
                 </div>
                 <div class="form-group col-md-3">
                   <label for="DefaultDiscount"><?=label("DefaultDiscount");?></label>
                   <input type="text" value="<?=$this->setting->discount;?>" name="discount" class="form-control" id="DefaultDiscount" placeholder="<?=label("DefaultDiscount");?>">
                 </div>
                 <div class="form-group col-md-3">
                   <label for="DefualtTax"><?=label("DefualtTax");?></label>
                   <input type="text" value="<?=$this->setting->tax;?>" name="tax" class="form-control" id="DefualtTax" placeholder="<?=label("DefualtTax");?>">
                 </div>
                 <div class="form-group col-md-6">
                   <label for="numberDecimal"><?=label("numberDecimal");?></label>
                   <select class="form-control" name="decimals" id="numberDecimal">
				      <option value="0" <?=$this->setting->decimals===0 ? 'selected' : '';?>>1</option>
                      <option value="1" <?=$this->setting->decimals===1 ? 'selected' : '';?>>0.1</option>
                      <option value="2" <?=$this->setting->decimals===2 ? 'selected' : '';?>>0.01</option>
                      <option value="3" <?=$this->setting->decimals===3 ? 'selected' : '';?>>0.001</option>
                   </select>
                 </div>
                 <div class="form-group col-md-6">
                   <label>
                     <input type="hidden" name="keyboard" value="0" />
                     <input type="checkbox" name="keyboard" value="1" <?=strval($this->setting->keyboard) === '1' ? 'checked' : '';?>>
                     <span class="label-text"><?=label("keyboardDisplay");?></span>
                   </label>
                 </div>
                 <div class="form-group col-md-6">
                   <label>
                      <select name="timezone" class="form-control">
                         <option value="0"><?= label('timezone');?></option>
                         <?php foreach($Timezones as $t) { ?>
                           <option value="<?php print $t['zone'] ?>" <?= $t['zone'] === $this->setting->timezone ? 'selected' : ''; ?>>
                             <?php print $t['diff_from_GMT'] . ' - ' . $t['zone'] ?>
                           </option>
                         <?php } ?>
                       </select>
                   </label>
                 </div>

                 <div class="col-md-6">
                    <h4><?=label("ReceiptHeader");?></h4>
                    <textarea id="summernote" name="receiptheader"><?=$this->setting->receiptheader;?></textarea>
                  </div>
                  <div class="form-group col-md-6">
                     <h4><?=label("ReceiptFooter");?></h4>
                     <textarea  id="summernote2" name="receiptfooter"><?=$this->setting->receiptfooter;?></textarea>
                  </div>
                  <div class="form-group col-md-12">
                    <label data-toggle="collapse" data-target="#collapseStripe">
                      <input type="hidden" name="stripe" value="0" />
                      <input type="checkbox" name="stripe" value="1" <?=strval($this->setting->stripe) === '1' ? 'checked' : '';?>>
                      <span class="label-text">Stripe</span>
                    </label>
                  </div>
                  <div id="collapseStripe" class="panel-collapse collapse <?=strval($this->setting->stripe) === '1' ? 'in' : '';?>">
                     <div class="panel-body">
                       <div class="form-group col-md-6">
                          <label for="stripe_secret_key">stripe secret key</label>
                          <input type="text" value="<?=$this->setting->stripe_secret_key;?>" name="stripe_secret_key" class="form-control" id="stripe_secret_key" placeholder="stripe secret key">
                       </div>
                       <div class="form-group col-md-6">
                          <label for="stripe_publishable_key">stripe publishable key</label>
                          <input type="text" value="<?=$this->setting->stripe_publishable_key;?>" name="stripe_publishable_key" class="form-control" id="stripe_publishable_key" placeholder="stripe publishable key">
                       </div>
                     </div>
                  </div>
                  <div class="form-group col-md-12">
                     <h4><?=label("themesPick");?></h4>
                     <label class="themesPick col-md-3">
                        <input type="radio" name="theme" value="Light" <?=$this->setting->theme === 'Light' ? 'checked' : '';?>/>
                        <img src="<?=base_url()?>assets/img/Light-theme.jpg" alt="Light-theme">
                      </label>
                      <label class="themesPick col-md-3">
                        <input type="radio" name="theme" value="Dark" <?=$this->setting->theme === 'Dark' ? 'checked' : '';?> />
                        <img src="<?=base_url()?>assets/img/Dark-theme.jpg" alt="Dark-theme">
                      </label>
                  </div>
                 <div class="col-md-12">
                    <button type="submit" class="btn btn-add btn-lg"><?=label("Submit");?></button>
                 </div>
               <?php echo form_close(); ?>
            </div>
            <!-- users tab -->
            <div class="tab-pane fade in <?php echo ($tab == 'users') ? 'active' : ''; ?>" id="users">
               <table class="table">
                  <tr>
                     <th><b><?=label("Avatar");?></b></th>
                     <th><b><?=label("firstname");?></b></th>
                     <th><b><?=label("lastname");?></b></th>
                     <th><b><?=label("Username");?></b></th>
                     <th><b><?=label("Role");?></b></th>
                     <th><b><?=label("lastActive");?></b></th>
                     <th><b><?=label("Action");?></b></th>
                     <th><b><?=label("Store");?></b></th>
                  </tr>
                  <?php foreach ($Users as $user):?>
                   <tr>
                      <td><img class="img-circle topbar-userpic hidden-xs" src="<?=$user->avatar ? base_url().'files/Avatars/'.$user->avatar : base_url().'assets/img/Avatar.jpg' ?>" width="30px" height="30px"></td>
                      <td><?=$user->firstname;?></td>
                      <td><?=$user->lastname;?></td>
                      <td><?=$user->username;?></td>
                      <td><?=$user->role;?></td>
                      <td><?=$user->last_active;?></td>
                      <td><div class="btn-group">
                            <?php if($user->id !== 1){?><a class="btn btn-default" href="settings/deleteUser/<?=$user->id;?>" data-toggle="tooltip" data-placement="top" title="<?=label('Delete');?>"><i class="fa fa-times"></i></a><?php } ?>
                            <a class="btn btn-default" href="settings/editUser/<?=$user->id;?>" data-toggle="tooltip" data-placement="top" title="<?=label('Edit');?>"><i class="fa fa-pencil"></i></a>
                          </div>
                       </td>
                       <td><?php foreach ($stores as $store):?>
                          <?php if($store->id == $user->store_id) { echo $store->name; }?>
                       <?php endforeach;?></td>
                   </tr>
                <?php endforeach;?>
               </table>
               <!-- Button trigger modal -->
               <button type="button" class="btn btn-add btn-lg" data-toggle="modal" data-target="#AddUser">
                  <?=label("Adduser");?>
               </button>
            </div>
            <!-- Warehouse tab -->
            <div class="tab-pane fade in <?php echo ($tab == 'warehouses') ? 'active' : ''; ?>" id="warehouses">
               <table class="table">
                  <tr>
                     <th><?=label("WarehouseName");?></th>
                     <th><?=label("WarehousePhone");?></th>
                     <th><?=label("Email");?></th>
                     <th><?=label("Adresse");?></th>
                     <th><?=label("Action");?></th>
                  </tr>
                  <?php foreach ($warehouses as $warehouse):?>
                   <tr>
                      <td><?=$warehouse->name;?></td>
                      <td><?=$warehouse->phone;?></td>
                      <td><?=$warehouse->email;?></td>
                      <td><?=$warehouse->adresse;?></td>
                      <td><div class="btn-group">
                            <a class="btn btn-default" href="warehouses/delete/<?=$warehouse->id;?>" data-toggle="tooltip" data-placement="top" title="<?=label('Delete');?>"><i class="fa fa-times"></i></a>
                            <a class="btn btn-default" href="warehouses/edit/<?=$warehouse->id;?>" data-toggle="tooltip" data-placement="top" title="<?=label('Edit');?>"><i class="fa fa-pencil"></i></a>
                          </div>
                       </td>
                   </tr>
                   <?php endforeach;?>
                  </table>
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-add btn-lg" data-toggle="modal" data-target="#AddWarehouse">
                     <?=label("AddWarehouse");?>
                  </button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /.container -->
<!-- add user Modal -->
<div class="modal fade" id="AddUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("Adduser");?></h4>
      </div>
      <?php echo form_open_multipart('settings/addUser'); ?>
      <div class="modal-body">
            <div class="form-group">
             <label for="username"><?=label("Username");?> *</label>
             <input type="text" name="username" class="form-control" id="username" placeholder="<?=label("Username");?>" required>
           </div>
           <div class="form-group">
             <label for="firstname"><?=label("firstname");?> *</label>
             <input type="text" name="firstname" class="form-control" id="firstname" placeholder="<?=label("firstname");?>" required>
           </div>
           <div class="form-group">
             <label for="lastname"><?=label("lastname");?></label>
             <input type="text" name="lastname" class="form-control" id="lastname" placeholder="<?=label("lastname");?>">
           </div>
           <div class="form-group">
               <label for="role"><?=label("Role");?> *</label><br>
               <label class="radio-inline">
                 <input type="radio" name="role" id="role" value="admin" checked> <?=label("RoleAdimn");?>
               </label>
               <label class="radio-inline">
                 <input type="radio" name="role" id="role" value="sales"> <?=label("RoleSales");?>
               </label>
               <label class="radio-inline">
                 <input type="radio" name="role" id="role" value="waiter"> <?=label("Waiter");?>
               </label>
               <label class="radio-inline">
                 <input type="radio" name="role" id="role" value="kitchen"> <?=label("Kitchen");?>
               </label>
            </div>
            <div class="form-group" id="Storeslist">
              <label for="store_id"><?=label("Store");?></label>
                    <select class="form-control" name="store_id" id="store_id">
                      <?php foreach ($stores as $store):?>
                         <option value="<?=$store->id;?>"><?=$store->name;?></option>
                      <?php endforeach;?>
                    </select>

            </div>
           <div class="form-group">
             <label for="email"><?=label("Email");?></label>
             <input type="email" name="email" class="form-control" id="email" placeholder="<?=label("Email");?>">
           </div>
           <div class="form-group">
             <label for="password"><?=label("Password");?> *</label>
             <input type="password" name="password" class="form-control" id="password" placeholder="<?=label('Password');?>" required>
          </div>
           <div class="form-group">
             <label for="confirm_password"><?=label("PasswordRepeat");?> *</label>
             <input type="password" name="PasswordRepeat" class="form-control" id="confirm_password" placeholder="<?=label('PasswordRepeat');?>" required>
           </div>
           <div class="form-group">
             <label for="Avatar"><?=label("Avatar");?></label>
             <input type="file" name="userfile" id="Avatar">
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


<!-- add warehouse Modal -->
<div class="modal fade" id="AddWarehouse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=label("AddWarehouse");?></h4>
      </div>
      <?php echo form_open_multipart('warehouses/add'); ?>
      <div class="modal-body">
            <div class="form-group">
             <label for="WarehouseName"><?=label("WarehouseName");?> *</label>
             <input type="text" name="name" class="form-control" id="WarehouseName" placeholder="<?=label("WarehouseName");?>" required>
           </div>
           <div class="form-group">
             <label for="WarehousePhone"><?=label("WarehousePhone");?></label>
             <input type="text" name="phone" class="form-control" id="WarehousePhone" placeholder="<?=label("WarehousePhone");?>">
          </div>
           <div class="form-group">
             <label for="email"><?=label("Email");?></label>
             <input type="email" name="email" class="form-control" id="email" placeholder="<?=label("Email");?>">
          </div>
           <div class="form-group">
             <label for="Adresse"><?=label("Adresse");?></label>
             <input type="text" name="adresse" class="form-control" id="Adresse" placeholder="<?=label("Adresse");?>">
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

<script type="text/javascript">

/******** passwors confirmation validation ****************/

var currency = document.getElementById("currency");

function validatecurrency(){
  if(currency.value.length < 3) {
    currency.setCustomValidity("The Currency code must be at least 3 characters length");
  } else {
    currency.setCustomValidity('');
  }
}
if(currency) currency.onchange = validatecurrency;


$(document).ready(function () {

$("#Storeslist").slideUp();

$('input[type=radio][name=role]').on('change', function() {
  if( this.value == "waiter" || this.value == "kitchen" ) //if waiter or kitchen
  {
    $("#Storeslist").slideDown();
  } else {
     $("#Storeslist").slideUp();
  }
});

});
$('.collapse').collapse()
</script>
