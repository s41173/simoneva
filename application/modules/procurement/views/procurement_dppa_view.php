
 <!-- Datatables CSS -->
<link href="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/icheck/flat/green.css" rel="stylesheet" type="text/css">

<!-- Date time picker -->
 <script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 
 <!-- Include Date Range Picker -->
<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<script src="<?php echo base_url(); ?>js/moduljs/procurement.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<script type="text/javascript">

	var sites_add  = "<?php echo site_url('procurement/add_process/');?>";
	var sites_edit = "<?php echo site_url('procurement/update_process/');?>";
	var sites_del  = "<?php echo site_url('procurement/delete/');?>";
	var sites_get  = "<?php echo site_url('procurement/update/');?>";
	var sites_ajax  = "<?php echo site_url('procurement/');?>";
	var source = "<?php echo $source;?>";
    var type = 'dppa';
    
    $(document).ready(function (e) {
        
      $('#tcontract_date,#ds2').daterangepicker({
         locale: {format: 'YYYY/MM/DD'},
		 singleDatePicker: true,
         showDropdowns: true
      });
    });
	
</script>

<style type="text/css">
    #tyear{ width: 80px; float: left;}
    #cmonth{ float: left; margin-right: 10px;}
</style>


          <div class="row"> 
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" >
              
              <!-- xtitle -->
              <div class="x_title">
              
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                </ul>
                
                <div class="clearfix"></div>
              </div>
              <!-- xtitle -->
                
                <div class="x_content">
                    
<!-- Smart Wizard -->
<div id="wizard" class="form_wizard wizard_horizontal">
  <ul class="wizard_steps">
    <li>
      <a href="#step-1">
        <span class="step_no">1</span>
        <span class="step_descr">
          <small> Primary Details </small>
        </span>
      </a>
    </li>
  </ul>
    
  <div id="step-1">
    <!-- form -->
    <form class="form-horizontal form-label-left" id="ajaxformdata" method="post" action="<?php echo $form_action; ?>">
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-6"> Periode </label>
        <div class="col-md-5 col-sm-5 col-xs-12">
			<?php $js = "class='form-control' id='cmonth' tabindex='-1' style='width:150px;' "; 
	        echo form_dropdown('cmonth', $month, isset($default['month']) ? $default['month'] : '', $js); ?>
            <input type="number" class="form-control" name="tyear" id="tyear" title="Year" maxlength="4" value="<?php echo date('Y'); ?>" />
        </div>
      </div>    
        
      <div class="form-group">
        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Program Kegiatan </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <?php $js = "class='select2_single form-control' id='ccategory_account' tabindex='-1' style='width:70%;' "; 
	      echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : '', $js); ?>
       </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Rekening </label>
        <div class="col-md-6 col-sm-6 col-xs-12 select_box"> </div>
      </div>
            
      <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Jumlah SP2D </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
			<input type="number" class="form-control" name="tamount" id="tamount" readonly title="Amount" />
        </div>
      </div>
     
      <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Progress Keuangan  </label>
          <div class="col-md-3 col-sm-3 col-xs-12">
<input id="tprogress" class="form-control col-md-7 col-xs-12" type="number" name="tprogress" required readonly>
          </div>
      </div>
      
      <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Pelaksana </label>
          <div class="col-md-3 col-sm-3 col-xs-12">
<input id="tvendor" class="form-control col-md-7 col-xs-12" type="text" name="tvendor" required placeholder="Pelaksana">
<input id="tcontact" class="form-control col-md-7 col-xs-12" type="text" name="tcontact" required placeholder="Contact Person">
          </div>
      </div>
      
      <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Kontrak SPK </label>
          <div class="col-md-3 col-sm-3 col-xs-12">
<input id="tcontract" class="form-control col-md-7 col-xs-12" type="text" name="tcontract" required placeholder="No Kontrak">
<input id="tcontract_date" class="form-control col-md-7 col-xs-12" type="text" name="tcontract_date" required 
placeholder="Tanggal Kontrak">
          </div>
      </div>
        
      <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12"> Nilai  </label>
          <div class="col-md-3 col-sm-3 col-xs-12">
<input id="tnilai" class="form-control col-md-7 col-xs-12" type="number" name="tnilai" required>
          </div>
      </div>
      
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary" id="button">Save</button>
          <button type="button" class="btn btn-success" onClick="resets();" id="breset">Reset</button>
        </div>
      </div>
      
	</form>
    <!-- end div layer 1 -->
  </div>
  
</div>
<!-- End SmartWizard Content -->             
                  
          <form class="form-inline" id="cekallform" method="post" action="<?php echo ! empty($form_action_del) ? $form_action_del : ''; ?>">
                  
                  <div class="table-responsive">
                  <!-- table -->
                  <?php echo ! empty($table) ? $table : ''; ?>
                  <!-- table -->
                  </div>
                  
                  <!-- Check All Function -->
                  <div class="form-group" id="chkbox">
                    Check All : 
                    <button type="submit" id="cekallbutton" class="btn btn-danger btn-xs">
                       <span class="glyphicon glyphicon-trash"></span>
                    </button>
                  </div>
                  <!-- Check All Function -->    
          </form>       
             </div>

              <!-- Trigger the modal with a button --> 
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">   </button>-->
<a class="btn btn-primary" href="<?php echo site_url('transaction/closing'); ?>"> Generate Begin Saldo </a>
               <!-- links -->
	           <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?>
               <!-- links -->
                             
            </div>
          </div>
      
    
      <!-- Modal - Add Form -->
      <div class="modal fade" id="myModal" role="dialog">
         <?php //$this->load->view('balance_priority_form'); ?>      
      </div>
      <!-- Modal - Add Form -->
              
      <!-- Modal - Add Form -->
      <div class="modal fade" id="myModal4" role="dialog">
         <?php //$this->load->view('balance_form'); ?>      
      </div>
      <!-- Modal - Add Form -->
      
      <!-- Modal Edit Form -->
      <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	     <?php //$this->load->view('transaction_update'); ?> 
      </div>
      <!-- Modal Edit Form -->
      
      <!-- Modal - Report Form -->
      <div class="modal fade" id="myModal3" role="dialog">
         <?php /*$this->load->view('category_report');*/ ?>    
      </div>
      <!-- Modal - Report Form -->
      
       <script src="<?php echo base_url(); ?>js/icheck/icheck.min.js"></script>
      
       <!-- Datatables JS -->
        <script src="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/jszip.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/pdfmake.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/vfs_fonts.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.scroller.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.tableTools.js"></script>
              
 <!-- jQuery Smart Wizard -->
    <script src="<?php echo base_url(); ?>js/wizard/jquery.smartWizard.js"></script>
        
        <!-- jQuery Smart Wizard -->
    <script>
      $(document).ready(function() {
        $('#wizard').smartWizard();

        $('#wizard_verticle').smartWizard({
          transitionEffect: 'slide'
        });

/*        $('.buttonNext').addClass('btn btn-success');
        $('.buttonPrevious').addClass('btn btn-primary');
        $('.buttonFinish').addClass('btn btn-default');*/
      });
    </script>
    <!-- /jQuery Smart Wizard -->
        