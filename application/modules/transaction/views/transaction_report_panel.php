<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Transaction Report </h4>
</div>
<div class="modal-body">
 
 <!-- form add -->
<div class="x_panel" >
<div class="x_title">
  
  <div class="clearfix"></div> 
</div>
<div class="x_content">

<form id="" data-parsley-validate class="form-horizontal form-label-left" method="POST" 
action="<?php echo $form_action_report; ?>" enctype="multipart/form-data">
     
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> SKPD </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <?php $js = "class='form-control' id='cdppa_report'"; 
           echo form_dropdown('cdppa', $dppa, isset($default['dppa']) ? $default['dppa'] : '', $js); ?>
        </div>
    </div>
        
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Tahun </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
        <input id="tyear" maxlength="4" class="form-control col-md-7 col-xs-12" type="number" name="tyear" value="<?php echo date('Y'); ?>" required placeholder="Tahun Periode">
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Jenis </label>
        <div class="col-md-3 col-sm-3 col-xs-12">     
			<select name="ctype" class="form-control">
              <option value="0"> Summary </option>
              <option value="1"> Pivottable </option>
            </select>
        </div>
    </div>
    
      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary">Post</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
      </div>
  </form> 
  <div id="err"></div>
</div>
</div>
<!-- form add -->

</div>
    <div class="modal-footer">
      
    </div>
  </div>
  
</div>