<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Transaction - Update </h4>
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
        <label class="control-label col-md-3 col-sm-3 col-xs-6"> Periode </label>
        <div class="col-md-5 col-sm-5 col-xs-12">
        <input type="text" class="form-control" name="tmonth" id="tmonth" readonly title="Month" style="width:125px; float:left;" />
        <input type="hidden" id="cmonth_update" name="cmonth">
        <input type="number" class="form-control" readonly name="tyear" id="tyear_update" title="Year" style="width:75px;" />
        </div>
   </div>    
        
      <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Kategori Rekening </label>
        <div class="col-md-8 col-sm-8 col-xs-12">
 <input type="text" class="form-control" name="tcategory" id="tcategory" readonly title="Kategori" />
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Rekening </label>
        <div class="col-md-8 col-sm-8 col-xs-12">
        <input type="text" id="taccount" class="form-control" readonly>
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Anggaran </label>
        <div class="col-md-4 col-sm-4 col-xs-12">
			<input type="number" class="form-control" name="tbudget" id="tbudget_update" title="Budget" readonly />
        </div>
      </div>
        
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Jumlah Saldo Bulan Lalu </label>
        <div class="col-md-4 col-sm-4 col-xs-12">
<input type="number" class="form-control" name="topening" id="topening_update" readonly title="Opening" />
        </div>
      </div>    
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Jumlah SP2D </label>
        <div class="col-md-4 col-sm-4 col-xs-12">
			<input type="number" class="form-control" name="tamount" id="tamount_update" title="Amount" />
        </div>
      </div>
     
      <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Progress Keuangan  </label>
          <div class="col-md-4 col-sm-4 col-xs-12">
            <input id="tprogress_update" class="form-control col-md-7 col-xs-12" type="number" name="tprogress" required placeholder="Jumlah Nominal Kemajuan Bulan Ini" onkeyup="calculate_rest_balance('update')">
          </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Jumlah Saldo Akhir Bulan </label>
        <div class="col-md-4 col-sm-4 col-xs-12">
<input type="number" class="form-control" name="trest" id="trest_update" readonly title="Opening" />
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