<div class="container container-small">
   <div class="row" style="margin-top:100px;">
      <a class="btn btn-default float-right" href="#" onclick="history.back(-1)"style="margin-bottom:10px;">
         <i class="fa fa-arrow-left"></i> <?=label("Back");?></a>
      <?php echo form_open_multipart('settings/editUser/'.$user->id); ?>

            <div class="form-group">
             <label for="username"><?=label("Username");?></label>
             <input type="text" name="username" value="<?=$user->username?>" class="form-control" id="username" placeholder="<?=label("Username");?>">
           </div>
           <div class="form-group">
             <label for="firstname"><?=label("firstname");?></label>
             <input type="text" name="firstname" value="<?=$user->firstname?>" class="form-control" id="firstname" placeholder="<?=label("firstname");?>">
           </div>
           <div class="form-group">
             <label for="lastname"><?=label("lastname");?></label>
             <input type="text" name="lastname" value="<?=$user->lastname?>" class="form-control" id="lastname" placeholder="<?=label("lastname");?>">
           </div>
           <div class="form-group">
               <label for="role"><?=label("Role");?></label><br>
               <label class="radio-inline">
                 <input type="radio" name="role" id="role" value="admin"> <?=label("RoleAdimn");?>
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
                         <option value="<?=$store->id;?>" <?=$user->store_id===$store->id ? 'selected' : '';?> ><?=$store->name;?></option>
                      <?php endforeach;?>
                    </select>

            </div>
           <div class="form-group">
             <label for="email"><?=label("Email");?></label>
             <input type="email" name="email" value="<?=$user->email?>" class="form-control" id="email" placeholder="<?=label("Email");?>">
           </div>
           <div class="form-group">
             <label for="password"><?=label("Password");?></label>
             <input type="password" name="password" class="form-control" id="password" placeholder="<?=label('Password');?>">
          </div>
           <div class="form-group">
             <label for="PasswordRepeat"><?=label("PasswordRepeat");?></label>
             <input type="password" name="PasswordRepeat" class="form-control" id="PasswordRepeat" placeholder="<?=label('PasswordRepeat');?>">
           </div>
           <div class="form-group">
             <label for="Avatar"><?=label("Avatar");?></label>
             <input type="file" name="userfile" id="Avatar">
           </div>
           <?php if($user->avatar){ ?><img src="<?=base_url()?>files/Avatars/<?=$user->avatar;?>" alt="" class="float-right" width="150px"/><?php }else{ ?><img src="<?=base_url()?>assets/img/Avatar.jpg" alt="" class="float-right" width="150px"/><?php } ?>

      <div class="form-group">
        <button type="submit" class="btn btn-green col-md-6 flat-box-btn"><?=label("Submit");?></button>
      </div>
      <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {

<?=$user->role==='admin' || $user->role==='sales' ? '$("#Storeslist").slideUp();' : '';?>

$('input[type=radio][name=role]').on('change', function() {
  if( this.value == "waiter" || this.value == "kitchen" ) //if waiter or kitchen
  {
    $("#Storeslist").slideDown();
  } else {
     $("#Storeslist").slideUp();
  }
});

});
</script>
