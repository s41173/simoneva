<script type="text/javascript" src="<?php echo base_url().'js-old/' ?>canvasjs.min.js"></script>
<script src="<?php echo base_url(); ?>js/moduljs/dashboard.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>

<script type="text/javascript">
    
var url  = "<?php echo $graph;?>";
var url2 = "<?php echo $graph2;?>";
    
</script>

<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel" >
<div class="x_title">
  <h2>WEB-ADMIN - 1.0.3 - <?php echo $name; ?> System </h2>

<div class="clearfix"></div>

    <div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
    <p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
    
    <div class="alert alert-success alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <span style="color:#fff !important;">IP Adress : <strong> <?php echo $this->input->ip_address(); ?> </strong> 
      - <?php echo $user_agent; ?> | Last Login : <?php echo $this->session->userdata('waktu'); ?> : 
        <?php echo get_month($month).' - '.$year; ?>
      </span> 
    </div>
    
    
    </div>
    
    <div class="x_content">
    
        <style>
          .ixcon{
            display: inline-block;
            margin: 20px;
            text-align: center;
            border:1px solid #eee;
            width: 100px;
            height: 100px;
            margin-bottom: 0;
            margin-right: 0px;
            padding-top: 15px;transition: all .5s;
            margin-left: 0;
          }
          .ixcon img{
            display: block;
        
            margin: 0 auto;margin-bottom: 5px;
          }
          .ixcon:hover{
            border:1px solid #40C1A6;
            transition: all 1s;
          }
          .ixcon:hover a{
            color: #40C1A6;
            text-decoration: none;
          }
        </style>
        
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/dppa/';?>">
                <img alt="Article Manager" src="<?php echo base_url().'images/city.png';?>">
                <p> SKPD </p>
                </a>
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/acategory/';?>">
                <img alt="setting" src="<?php echo base_url().'images/service.png';?>">
                <p> Kegiatan </p>
              </a>
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/account/';?>">
                <img alt="setting" src="<?php echo base_url().'images/pcost.png';?>">
                <p> Rekening </p>
              </a>
        
            </div>
        
            <div class="ixcon">
                <a href="<?php echo base_url().'index.php/balance/';?>">
                <img alt="setting" src="<?php echo base_url().'images/money.png';?>">
                <p> Anggaran </p>
              </a>
        
            </div>
           
           <div class="ixcon">
                <a href="<?php echo base_url().'index.php/transaction/';?>">
                <img alt="setting" src="<?php echo base_url().'images/neworder.png';?>">
                <p> Tranksaksi </p>
              </a>
        
            </div>
        
           <div class="ixcon">
                <a href="<?php echo base_url().'index.php/procurement/';?>">
                <img alt="setting" src="<?php echo base_url().'images/coststatement.png';?>">
                <p> Pengadaan </p>
              </a>
        
           </div>
       

        <!-- searching form -->
<h2 style="margin-top:35px; text-align:center;"> Progress Realisasi <?php echo $dppa; ?> </h2>        
           
           <form id="searchform" class="form-inline" method="post" style="margin-left:100px;">
               
 <div class="form-group">
   <?php $js = "class='form-control' id='cdppa_search' tabindex='-1' style='min-width:150px;' "; 
   echo form_dropdown('cdppa', $combo_dppa, isset($default['dppa']) ? $default['dppa'] : '', $js); ?>
 </div>   
               
               
  <div class="form-group">
   <?php $js = "class='form-control' id='cmonth_search' tabindex='-1' style='min-width:150px;' "; 
   echo form_dropdown('cmonth', $combo_month, isset($default['month']) ? $default['month'] : '', $js); ?>
  </div>               
              
  <div class="form-group">
         
   <input id="tyear_search" maxlength="4" class="form-control col-md-2 col-xs-12" type="number" name="tyear" 
          value="<?php echo date('Y'); ?>" required style="width:80px;" placeholder="Tahun Periode">
  </div>

  <div class="form-group"> <button type="submit" class="btn btn-primary button_inline"> Filter </button> 
  <a class="btn btn-danger button_inline" href="<?php echo site_url('main'); ?>"> Reset </a>
  </div>
          </form> <br>

  <div class="clearfix"></div> 
  <div id="chartContainer" style="height: 300px; width: 100%; margin-top:10px;"> </div>
           <!-- searching form -->     
        
    <!-- searching2 form -->
<h2 style="margin-top:35px; text-align:center;"> Total Belanja <?php echo $dppa; ?> </h2>        
           
           <form id="searchform" class="form-inline" method="post" style="margin-left:100px;">
               
 <div class="form-group">
   <?php $js = "class='form-control' id='cdppa_search' tabindex='-1' style='min-width:150px;' "; 
   echo form_dropdown('cdppa2', $combo_dppa, isset($default['dppa']) ? $default['dppa'] : '', $js); ?>
 </div>               
              
  <div class="form-group">
         
   <input id="tyear_search" maxlength="4" class="form-control col-md-2 col-xs-12" type="number" name="tyear2" 
          value="<?php echo date('Y'); ?>" required style="width:80px;" placeholder="Tahun Periode">
  </div>

  <div class="form-group"> <button type="submit" class="btn btn-primary button_inline"> Filter </button> 
  <a class="btn btn-danger button_inline" href="<?php echo site_url('main'); ?>"> Reset </a>
  </div>
          </form> <br>

  <div class="clearfix"></div> 
  <div id="chartContainer2" style="height: 350px; width: 100%; margin-top:10px;"> </div>
           <!-- searching2 form -->      
    
    </div> 

<!-- end content -->

</div>
</div>
