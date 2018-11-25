<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="<?php echo base_url().'images/fav_icon.png';?>" >
<title> <?php echo isset($title) ? $title : ''; ?>  </title>
<style media="all">
	table{ font-family:"Tahoma", Times, serif; font-size:11px;}
	h4{ font-family:"Tahoma", Times, serif; font-size:14px; font-weight:600;}
	.clear{clear:both;}
	table th{ background-color:#EFEFEF; padding:4px 0px 4px 0px; border-top:1px solid #000000; border-bottom:1px solid #000000;}
    p{ font-family:"Tahoma", Times, serif; font-size:12px; margin:0; padding:0;}
	legend{font-family:"Tahoma", Times, serif; font-size:13px; margin:0; padding:0; font-weight:600;}
	.tablesum{ font-size:13px;}
	.strongs{ font-weight:normal; font-size:12px; border-top:1px dotted #000000; }
	.poder{ border-bottom:0px solid #000000; color:#0000FF;}
</style>

<link rel="stylesheet" href="<?php echo base_url().'js-old/jxgrid/' ?>css/jqx.base.css" type="text/css" />
    
	<script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxbuttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxcheckbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxscrollbar.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxlistbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxmenu.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.columnsresize.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.columnsreorder.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.aggregates.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxdata.export.js"></script>
	<script type="text/javascript" src="<?php echo base_url().'js-old/jxgrid/' ?>js/jqxgrid.export.js"></script>
	
    <script type="text/javascript">
	
        $(document).ready(function () {
          
			var rows = $("#table tbody tr");
                // select columns.
                var columns = $("#table thead th");
                var data = [];
                for (var i = 0; i < rows.length; i++) {
                    var row = rows[i];
                    var datarow = {};
                    for (var j = 0; j < columns.length; j++) {
                        // get column's title.
                        var columnName = $.trim($(columns[j]).text());
                        // select cell.
                        var cell = $(row).find('td:eq(' + j + ')');
                        datarow[columnName] = $.trim(cell.text());
                    }
                    data[data.length] = datarow;
                }
                var source = {
                    localdata: data,
                    datatype: "array",
                    datafields:
                    [
                        { name: "No", type: "string" },
						{ name: "SKPD", type: "string" },
                        { name: "Pagu Belanja Tidak Langsung", type: "number" },
						{ name: "Pagu Belanja Langsung", type: "number" },
						{ name: "Jumlah Pagu", type: "number" },
                        { name: "Belanja Tidak Langsung", type: "number" },
                        { name: "%(BTL)", type: "string" },
                        { name: "Belanja Langsung", type: "number" },
                        { name: "%(BL)", type: "string" },
                        { name: "Jumlah Belanja", type: "number" },
                        { name: "%", type: "string" },
                        { name: "Sisa Pagu", type: "number" },
                        { name: "%(RS)", type: "string" }
                    ]
                };
			
            var dataAdapter = new $.jqx.dataAdapter(source);
            $("#jqxgrid").jqxGrid(
            {
                width: '100%',
				source: dataAdapter,
				sortable: true,
				filterable: true,
				pageable: true,
				altrows: true,
				enabletooltips: true,
				filtermode: 'excel',
				autoheight: true,
				columnsresize: true,
				columnsreorder: true,
				showstatusbar: true,
				statusbarheight: 30,
				showaggregates: true,
				autoshowfiltericon: false,
                columns: [
                  { text: 'No', dataField: 'No', width: 50 },
				  { text: 'SKPD', dataField: 'SKPD', width : 220 },
{ text: 'Pagu Belanja Tidak Langsung', dataField: 'Pagu Belanja Tidak Langsung', width : 220, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
{ text: 'Pagu Belanja Langsung', dataField: 'Pagu Belanja Langsung', width : 200, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
{ text: 'Jumlah Pagu', dataField: 'Jumlah Pagu', width : 150, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
{ text: 'Belanja Tidak Langsung', dataField: 'Belanja Tidak Langsung', width : 190, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
{ text: '%(BTL)', dataField: '%(BTL)', width : 70 },
{ text: 'Belanja Langsung', dataField: 'Belanja Langsung', width : 180, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
{ text: '%(BL)', dataField: '%(BL)', width : 70 },
{ text: 'Jumlah Belanja', dataField: 'Jumlah Belanja', width : 180, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
{ text: '%', dataField: '%', width : 60 },
{ text: 'Sisa Pagu', dataField: 'Sisa Pagu', width : 190, cellsalign: 'right', cellsformat: 'number', aggregates: ['sum'] },
{ text: '%(RS)', dataField: '%(RS)', width : 70 }
                ]
            });
			
			$('#jqxgrid').jqxGrid({ pagesizeoptions: ['100', '500', '1000', '2000', '3000', '5000']}); 
			
			$("#bexport").click(function() {
				
				var type = $("#crtype").val();	
				if (type == 0){ $("#jqxgrid").jqxGrid('exportdata', 'html', 'Recapitulation-Summary'); }
				else if (type == 1){ $("#jqxgrid").jqxGrid('exportdata', 'xls', 'Recapitulation-Summary'); }
				else if (type == 2){ $("#jqxgrid").jqxGrid('exportdata', 'pdf', 'Recapitulation-Summary'); }
				else if (type == 3){ $("#jqxgrid").jqxGrid('exportdata', 'csv', 'Recapitulation-Summary'); }
			});
			
			$('#jqxgrid').on('celldoubleclick', function (event) {
     	  		var col = args.datafield;
				var value = args.value;
				var res;
			
				if (col == 'Code')
				{ 			
				   res = value.split("CD-00");
				   openwindow(res[1]);
				}
 			});
			
			function openwindow(val)
			{
				var site = "<?php echo site_url('ap_payment/print_invoice/');?>";
				window.open(site+"/"+val, "", "width=800, height=600"); 
				//alert(site+"/"+val);
			}
			
			$("#table").hide();
			
		// end jquery	
        });
    </script>
</head>

<body>

<div style="width:100%; border:0px solid blue; font-family:Arial, Helvetica, sans-serif; font-size:12px;">
	
	<div style="border:0px solid red; float:left;">
		<table border="0">
            <tr> <td> Tahun </td> <td> : </td> <td> <?php echo $year; ?> </td> </tr>
			<tr> <td> Run Date </td> <td> : </td> <td> <?php echo $rundate; ?> </td> </tr>
			<tr> <td> Log </td> <td> : </td> <td> <?php echo $log; ?> </td> </tr>
		</table>
	</div>

	<center>
	   <div style="border:0px solid green; width:530px;">	
	       <h4> <?php echo isset($company) ? $company : ''; ?> <br> Rekapitulasi : Belanja Tidak Langsung Dan Belanja Langsung Dokumen Pelaksanaan Anggaran Pendapatan Dan Belanja Daerah (APBD) T.A. <?php echo $year; ?> <br>
           Keadaan : <?php echo get_month($month).' '.$year; ?> </h4>
	   </div>
	</center>
	
	<div class="clear"></div>
	
	<div style="width:100%; border:0px solid brown; margin-top:20px; border-bottom:1px dotted #000000; ">
	
    <div id='jqxWidget'>
        <div style='margin-top: 10px;' id="jqxgrid"> </div>
        
        <table style="float:right; margin:5px;">
        <tr>
        <td> <input type="button" id="bexport" value="Export"> - </td>
        <td> 
        <select id="crtype"> <option value="0"> HTML </option> <option value="1"> XLS </option>  <option value="2"> PDF </option> 
        <option value="3"> CSV </option> 
        </select>
        </td>
        </tr>
        </table>
        
    </div>
        

<!--        protected $field = array('id', 'parent_id', 'category', 'code', 'name', 'description', 'publish', 'created', 'updated', 'deleted');-->
    

		<table id="table" border="0" width="100%">
		   <thead>
           <tr>
 	       <th> No </th> <th> SKPD </th> <th> Pagu Belanja Tidak Langsung </th> <th> Pagu Belanja Langsung </th> 
           <th> Jumlah Pagu </th> <th> Belanja Tidak Langsung </th> <th>%(BTL)</th> <th> Belanja Langsung </th> <th>%(BL)</th>
           <th> Jumlah Belanja </th> <th>%</th> <th> Sisa Pagu </th> <th> %(RS) </th>
		   </tr>
           </thead>
		  
          <tbody> 
		  <?php 
              
              function pagu($skpd,$year,$type=1)
              {
                 $bl = new Balance_lib();
                 return $bl->get_belanja($skpd,$year,$type);
              }
              
              function belanja($skpd,$month,$year,$type=1)
              {
                 $bl = new Transaction_lib();
                 $res = $bl->get_total_monthly_based_belanja($skpd,'null','null',$month,$year,0,$type);
                 if (!$res){ return 0; }else { return $res; }
              }
			  		  
		      $i=1; 
			  if ($skpd)
			  {
				foreach ($skpd as $res)
				{	
                   $budget1 = pagu($res->id,$year,1);
                   $budget2 = pagu($res->id,$year,2);
                   $totbudget = $budget1+$budget2;
                   $belanja1 = belanja($res->id,$month,$year,1);
                   $belanja2 = belanja($res->id,$month,$year,2);
                   $totbelanja = $belanja1+$belanja2;
                   $rest = $totbudget-$totbelanja;
                    
				   echo " 
				   <tr> 
				       <td class=\"strongs\">".$i."</td> 
					   <td class=\"strongs\">".strtoupper($res->name)."</td>
                       <td class=\"strongs\">".$budget1." </td>
                       <td class=\"strongs\">".$budget2." </td>
                       <td class=\"strongs\">".$totbudget." </td>
                       <td class=\"strongs\">".$belanja1." </td>
                       <td class=\"strongs\"> ".@floatval($belanja1/$budget1*100)." </td>
                       <td class=\"strongs\">".$belanja2." </td>
                       <td class=\"strongs\"> ".@intval($belanja2/$budget2*100)." </td>
                       <td class=\"strongs\">".$totbelanja." </td>
                       <td class=\"strongs\"> ".@intval($totbelanja/$totbudget*100)." </td>
                       <td class=\"strongs\">".$rest." </td>
                       <td class=\"strongs\"> ".@intval($rest/$totbudget*100)." </td>
				   </tr>";
				   $i++;
				}
			 }  
		  ?>
		</tbody>   
		</table>
        
        </div>
        
        
	</div>
	
</div>

</body>
</html>