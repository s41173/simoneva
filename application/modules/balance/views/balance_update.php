<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Rekening - Update </h4>
        </div>
        
 <div class="modal-body"> 
 
 <!-- error div -->
 <div class="alert alert-success success"> </div>
 <div class="alert alert-warning warning"> </div>
 <div class="alert alert-error error"> </div>

 <!-- form edit -->
 <form id="edit_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
 action="<?php echo $form_action_update; ?>" enctype="multipart/form-data">
     
   <div class="form-group">
    <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Sumber Anggaran </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="csource" class="form-control" id="csources_update">
            <option value="DAU"> DAU </option>
            <option value="DAK"> DAK </option>
        </select>    
        <input type="hidden" id="htype" name="type" value="priority">
      </div>
    </div> 
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Jumlah </label>
      <div class="col-md-5 col-sm-5 col-xs-12">
        <input id="tamount_update" class="form-control col-md-7 col-xs-12" type="text" name="tamount" required placeholder="Jumlah Nominal">
      </div>
    </div>
    
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Tahun Periode </label>
      <div class="col-md-2 col-sm-2 col-xs-12">
        <input id="tyear_update" maxlength="4" class="form-control col-md-7 col-xs-12" type="number" name="tyear" value="<?php echo date('Y'); ?>" required readonly placeholder="Tahun Periode">
      </div>
    </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
      </div>
  </form> 
  <!-- form edit -->
  
  </div>
 </div>
</div>