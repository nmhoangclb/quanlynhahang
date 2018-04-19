<div class="container container-small">
   <div class="row" style="margin-top:100px;">
      <a class="btn btn-default float-right" href="#" onclick="history.back(-1)"style="margin-bottom:10px;">
         <i class="fa fa-arrow-left"></i> <?=label("Back");?></a>
     <?php echo form_open_multipart('categories/edit/'.$category->id); ?>
         <div class="form-group">
            <label for="CategoryName"><?=label("CategoryName");?></label>
            <input type="text" maxlength="50" name="name" value="<?=$category->name;?>" class="form-control" id="CategoryName" placeholder="<?=label("CategoryName");?>" required>
         </div>
     <div class="form-group">
       <button type="submit" class="btn btn-add"><?=label("Submit");?></button>
     </div>
     <?php echo form_close(); ?>
   </div>
</div>
