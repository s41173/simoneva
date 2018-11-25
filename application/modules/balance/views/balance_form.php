<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Tambah Anggaran </h4>
</div>
<div class="modal-body">
 
 <!-- error div -->
 <div class="alert alert-success success"> </div>
 <div class="alert alert-warning warning"> </div>
 <div class="alert alert-error error"> </div>
 
 <!-- form add -->
<div class="x_panel" >
<div class="x_title">
  
  <div class="clearfix"></div> 
</div>
<div class="x_content">

<form id="upload_form_non1" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
action="<?php echo $form_action; ?>" enctype="multipart/form-data">
     
    
    <div class="form-group">
       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Kategori Rekening <span class="required">*</span></label>
       <div class="col-md-9 col-sm-9 col-xs-12">
           
        <?php $js = "class='select2_single form-control' id='ccategory' tabindex='-1' style='width:100%;' "; 
         echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : '', $js); ?>
       </div>
    </div>
    
    <div class="form-group">
       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Kode Rekening <span class="required">*</span></label>
       <div class="col-md-9 col-sm-9 col-xs-12">
           
        <?php $js = "class='select2_single form-control' id='cparent' tabindex='-1' style='width:100%;' "; 
         echo form_dropdown('caccount', $account, isset($default['account']) ? $default['account'] : '', $js); ?>
       </div>
    </div>
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Jumlah </label>
      <div class="col-md-5 col-sm-5 col-xs-12">
        <input id="tamount" class="form-control col-md-7 col-xs-12" type="text" name="tamount" required placeholder="Jumlah Nominal">
      </div>
    </div>
    
     <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Tahun Periode </label>
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="tyear" maxlength="4" class="form-control col-md-7 col-xs-12" type="number" name="tyear" value="<?php echo date('Y'); ?>" required placeholder="Tahun Periode">
        <input type="hidden" name="type" value="non">
      </div>
    </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
          <button type="button" id="bclose" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" id="breset" class="btn btn-warning">Reset</button>
          </div>
      </div>
  </form> 

</div>
</div>
<!-- form add -->

</div>
    <div class="modal-footer"> </div>
</div>
  
</div>