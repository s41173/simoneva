<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		*{
			font-family: arial;
			font-size: 9px;
			/*padding: 0;*/
			margin: 0;
		}
		.hd1{
			/*background: #333;*/
		}

		@media print{
			thead tr:not(:last-child) th:nth-child(1),
			thead tr:not(:last-child) th:nth-child(2),
			thead tr:not(:last-child) th:nth-child(3),
			thead tr:not(:last-child) th:nth-child(4),
			thead tr:not(:last-child) th:nth-child(5),
			thead tr:not(:last-child) th:nth-child(6),
			thead tr:not(:last-child) th:nth-child(7),
			thead tr:not(:last-child) th:nth-child(8),
			thead tr:not(:last-child) th:nth-child(9),
			thead tr:not(:last-child) th:nth-child(10)
			{
				background: #ddd !important;
				-webkit-print-color-adjust: exact; 
			}
			thead tr:last-child th{
				background: #f4f4f4 !important;
			 	-webkit-print-color-adjust: exact; 
			}
		}
		td{
			border:1px solid #ccc;
		}
		thead th{
			border:1px solid #ccc;	
		}
		table{
			border:1px solid #ccc;		
		}
		
		h1{
			text-align: center;
			font:bold 12px arial;
			margin-bottom: 20px;
		}
		h1 span{
			display: block;
			letter-spacing: 20px;
			font:bold 13px arial;
		}
		tbody tr td:nth-child(8),
		tbody tr td:nth-child(14),
		tbody tr td:nth-child(12),
		tbody tr td:nth-child(4),
		tbody tr td:nth-child(7),
		tbody tr td:nth-child(15),
		tbody tr td:nth-child(6),
		tbody tr td:nth-child(16)
		{
			text-align: center;
		}
        
        tbody tr td:nth-child(3){ text-align: left;}
        tbody tr td:nth-child(5),tbody tr td:nth-child(9),tbody tr td:nth-child(10),tbody tr td:nth-child(12),
        tbody tr td:nth-child(13){ text-align: right;}
        
        .belanja{ background-color: #ffff99;}
        .jenis-belanja{ background-color: #b2ffb2;}
        .kategori-belanja{ background-color: #ffc6c6;}
        .top-rekening{ background-color: #f791f7;}
        .program{ background-color: #ff7a7a;}
        .kegiatan{ background-color: #c9c9ff;}
        
	</style>
</head>
<body>

	<h1><span>LAPORAN</span>PERKEMBANGAN PELAKSANAAN PENGADAAN APBD KOTA PEMATANGSIANTAR
<br>
BELANJA BARANG / JASA DAN BELANJA MODAL TAHUN ANGGARAN <?php echo $year; ?>
<br>
SKPD : <?php echo $dppa; ?>
<br>
BULAN : <?php echo strtoupper(get_month($month)).'  '.$year; ?> </h1>

	<table style="width: 100%" border='0' cellpadding="5" cellspacing="0">
		<thead>
			<tr class="hd1">
				<th rowspan="4">NO</th>
				<th rowspan="4">KODE REKENING</th>
				<th rowspan="4">PROGRAM DAN KEGIATAN</th>
				<th rowspan="4">SUMBER DANA</th>
				<th rowspan="4">PAGU DALAM DPA (Rp)</th>
				<th rowspan="4">PROSES PENGADAAN</th>
				<th rowspan="4">PERUSAHAAN PELAKSANA / DIREKTUR</th>

				<th colspan="2">KONTRAK SPK</th>
				<th rowspan="4">SISA PAGU DALAM DPA (Rp)</th>
				<th colspan="4">PERKEMBANGAN KEMAJUAN</th>
			</tr>

			<tr> 
				<th rowspan="3">No. / Tgl. Kontrak SPK</th>
				<th rowspan="3">Nilai (Rp.)</th>
				<th colspan="2">Realisasi</th>
				<th colspan='2' rowspan="2">Sisa</th>
			</tr>
			<tr> 
				<th rowspan="2">FISIK (%)</th>
				<th rowspan="2">KEUANGAN (%)</th>
			 
			</tr>
			<tr> 
				<th>Rp</th>
				<th>%</th>
				 
			</tr>
 
		</thead>
        
		
		<tbody>
            
<!--belanja langsung-->
<tr class="jenis-belanja">
    <td></td>
    <td align="right"> <nobr> <?php echo $code_dppa; ?> 00 00 5 2</nobr></td>
    <td> BELANJA LANGSUNG </td> 
    <td> </td> <!-- sumber -->
    <td> <?php echo idr_format($pagu_2) ?> </td> <!-- pagu dpa -->
    <td> </td> <!-- proses pengadaan -->
    <td> </td> <!-- vendor / contact person -->
	<td> </td> <!-- contract no / contract date -->
    <td> <?php echo idr_format($transaction_amount_2); ?> </td> <!-- nilai kontrak -->
    <td> <?php echo idr_format($pagu_2-$transaction_amount_2); ?> </td> <!-- Sisa Dana -->
    <td>100</td>
    <td> <?php echo idr_format($now_progress_2); ?> </td> <!-- Progress Bulan Ini -->
    <td> <?php echo idr_format($rest_balance_2); ?> </td>
    <td> <?php echo @floatval($rest_balance_2/$pagu_2*100); ?> </td>
</tr>  
<!--belanja langsung-->
            
<?php
    
    function get_balance($dppa,$year,$category)
    {
        $bl = new Balance_lib();
        return $bl->get_balance_based_child_program($dppa,$year,$category);
    }
            
    function get_trans($dppa,$month,$year,$category,$type=0)
    {
        $tr = new Transaction_lib();
        return $tr->get_total_monthly($dppa,$category,'null',$month,$year,$type);
    }
            
    function get_kode_belanja($category,$dppa,$month,$year)
    {
        $bl = new Balance_lib();
        $acc = new Account_lib();
        $tr = new Transaction_lib();
        $results = $bl->get_category_account_based_acategory($category,$dppa,$year)->result();
        
        if ($results)
        {
          foreach($results as $res)
          {
              
            if ($res->category == '523'){
                $pagux = $bl->get_balance_based_program_category_account($res->category,$category,$dppa,$year);
                $sp2dx = $tr->get_total_based_program_category_acc($res->category,$category,$dppa,$month,$year,0);
                $progressx = $tr->get_total_based_program_category_acc($res->category,$category,$dppa,$month,$year,1);
                $restx = $tr->get_total_based_program_category_acc($res->category,$category,$dppa,$month,$year,3);  
           
//            $pagux = $bl->get_balance_based_program_category_account($res->category,$category,$dppa,$year);
//            $sp2dx = $tr->get_total_based_program_category_acc($res->category,$category,$dppa,$month,$year,0);
//            $progressx = $tr->get_total_based_program_category_acc($res->category,$category,$dppa,$month,$year,1);
//            $restx = $tr->get_total_based_program_category_acc($res->category,$category,$dppa,$month,$year,3);  
              
            ?>
              
             <tr class="kategori-belanja">
				<td></td>
				<td align="right"> <nobr> <?php echo $res->category; ?> </nobr></td> <!-- kode rekening -->
				<td> <?php echo ucfirst($acc->get_belanja_type($res->category)); ?> </td> 
				<td>  </td>  <!-- sumber dana -->
				<td> <?php echo idr_format($pagux); ?> </td> <!-- pagu -->
				<td>  </td> <!-- proses pengadaan -->
				<td> </td> <!-- vendor / contact person -->
				<td> </td> <!-- contract no / contract date -->
				<td> <?php echo idr_format($sp2dx); ?> </td> <!-- nilai kontrak -->
				<td> <?php echo idr_format($pagux-$sp2dx); ?> </td> <!-- sisa kontrak (pagu - nilai kontrak) -->
				<td> 100 </td>
				<td> <?php echo idr_format($progressx); ?> </td> <!-- realisasi pembayaran -->
				<td> <?php echo idr_format($restx); ?> </td> <!-- sisa dana -->
				<td> <?php echo @floatval($restx/$pagux*100); ?> </td>		 
            </tr>    
                
            <?php get_top_procurement($res->category,$category,$dppa,$month,$year);
                
              }
          }
        }
    }
            
    function get_top_procurement($acategory,$category,$dppa,$month,$year)
    {
        $bl = new Balance_lib();
        $acc = new Account_lib();
        $pr = new Procurement_lib();
        
        $results = $pr->get_account_based_category_belanja($acategory,$category,$dppa,$month,$year)->result();
        
        if ($results)
        {
          foreach($results as $res)
          {   
            ?>
              
             <tr class="top-rekening">
				<td></td>
				<td align="right"> <nobr> <?php echo $res->code; ?> </nobr></td> <!-- kode rekening -->
				<td> <?php echo $res->name; ?> </td> 
				<td> </td>  <!-- sumber dana -->
				<td> </td> <!-- pagu -->
				<td> </td> <!-- proses pengadaan -->
				<td> </td> <!-- vendor / contact person -->
				<td> </td> <!-- contract no / contract date -->
				<td> </td> <!-- nilai kontrak -->
				<td> </td> <!-- sisa kontrak (pagu - nilai kontrak) -->
				<td> </td>
				<td> </td> <!-- realisasi pembayaran -->
				<td> </td> <!-- sisa dana -->
				<td> </td>		 
            </tr>    
                
            <?php get_procurement_list($acategory,$category,$dppa,$month,$year);
          }
        }
    }
            
    function get_procurement_list($acategory,$category,$dppa,$month,$year)
    {
       $bl = new Balance_lib();
       $acc = new Account_lib();
       $pr = new Procurement_lib();
       $tr = new Transaction_lib();
        
       $results = $pr->get_procurement_list($acategory,$category,$dppa,$month,$year)->result();   
       
       if ($results)
       {
          foreach($results as $res)
          {
            $pagux = $bl->get_balance_based_program_account($category,$res->account_id,$dppa,$year);
            $sp2dx = $res->budget;
            $progressx = $res->amount;
            $restx = $sp2dx-$progressx;  
              
            ?>
              
             <tr>
				<td></td>
				<td align="right"> <nobr> </nobr></td> <!-- kode rekening -->
				<td> <?php echo ucfirst($res->title); ?> </td> 
				<td>  </td>  <!-- sumber dana -->
				<td> <?php echo idr_format($pagux); ?> </td> <!-- pagu -->
				<td>  </td> <!-- proses pengadaan -->
				<td> <?php echo $res->vendor.' / '.$res->contact; ?> </td> <!-- vendor / contact person -->
<td> <?php echo $res->contract_no.' / '.tglin($res->contract_date); ?> </td> <!-- contract no / contract date -->
				<td> <?php echo idr_format($sp2dx); ?> </td> <!-- nilai kontrak -->
				<td> <?php echo idr_format($pagux-$sp2dx); ?> </td> <!-- sisa kontrak (pagu - nilai kontrak) -->
				<td> 100 </td>
				<td> <?php echo idr_format($progressx); ?> </td> <!-- realisasi pembayaran -->
				<td> <?php echo idr_format($restx); ?> </td> <!-- sisa dana -->
				<td> <?php echo @floatval($restx/$pagux*100); ?> </td>		 
            </tr>    
                
            <?php
          }
       }
        
    }
            
    
            
    if ($events)
    {
        foreach ($events as $res)
        {
            $pagux = get_balance($dppa_id,$year,$res->id);
            $sp2dx = get_trans($dppa_id,$month,$year,$res->id,0);
            $progressx = get_trans($dppa_id,$month,$year,$res->id,1);
            $restx = get_trans($dppa_id,$month,$year,$res->id,3);
            
            ?>
            
            <tr class="kegiatan">
				<td></td>
				<td align="right"> <nobr> <?php echo $res->code ?> </nobr></td> <!-- kode rekening -->
				<td> <?php echo ucfirst($res->name); ?> </td> 
				<td>  </td>  <!-- sumber dana -->
				<td> <?php echo idr_format($pagux); ?> </td> <!-- pagu -->
				<td>  </td> <!-- proses pengadaan -->
				<td> </td> <!-- vendor / contact person -->
				<td> </td> <!-- contract no / contract date -->
				<td> <?php echo idr_format($sp2dx); ?> </td> <!-- nilai kontrak -->
				<td> <?php echo idr_format($pagux-$sp2dx); ?> </td> <!-- sisa kontrak (pagu - nilai kontrak) -->
				<td> 100 </td>
				<td> <?php echo idr_format($progressx); ?> </td> <!-- realisasi pembayaran -->
				<td> <?php echo idr_format($restx); ?> </td> <!-- sisa dana -->
				<td> <?php echo @floatval($restx/$pagux*100); ?> </td>		 
            </tr>
            
            <?php  get_kode_belanja($res->id,$dppa_id,$month,$year);
        }
    }
    
?>
            
            
		</tbody>
	</table>


	<style>
		.xx{
			margin-top: 20px;
		}
		.xx,
		.xx td{
			border: 0 !important;
		}
	</style>

<!--
	<table width="100%" class="xx">
		<tr>
			<td colspan="2" align="center"><b><br> PEMATANG SIANTAR,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php //echo strtoupper(get_month($month)).'  '.$year; ?> <br>MENGETAHUI :</b><br>&nbsp;<br><br></td>
			</tr><tr>
			<td valign="top" width="50%" align="center">
				 
				Kepala Bagian Administrasi Pembangunan Kasubbag Evaluasi dan Pelaporan <br>	
				Sekretariat Daerah Kota Pematangsiantar Sekretariat Daerah Kota Pematangsiantar<br><br><br><br><br><br><br>

				<?php //echo $bendahara; ?> <br>
				NIP : <?php //echo $bendahara_nip; ?>

			
 

			</td>
			<td valign="top" width="50%" align="center">
				
				Kasubbag Evaluasi dan Pelaporan<br>
				Sekretariat Daerah Kota Pematangsiantar<br><br><br><br><br><br><br>


				<?php //echo $kadis; ?> <br/>
				NIP : <?php //echo $kadis_nip; ?>
			</td>
		</tr>
	</table>
-->

</body>
</html>