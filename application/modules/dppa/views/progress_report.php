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
		tbody tr td:nth-child(9),
		tbody tr td:nth-child(14),
		tbody tr td:nth-child(12),
		tbody tr td:nth-child(4),
		tbody tr td:nth-child(16)
		{
			text-align: center;
		}
        
        tbody tr td:nth-child(3){ text-align: left;}
        tbody tr td:nth-child(5),tbody tr td:nth-child(6),tbody tr td:nth-child(7){ text-align: right;}
        tbody tr td:nth-child(10),tbody tr td:nth-child(11),tbody tr td:nth-child(13),tbody tr td:nth-child(15)
        { text-align: right;}
        
        .belanja{ background-color: #ffff99;}
        .jenis-belanja{ background-color: #b2ffb2;}
        .kategori-belanja{ background-color: #ffc6c6;}
        .top-rekening{ background-color: #f791f7;}
        .program{ background-color: #ff7a7a;}
        .kegiatan{ background-color: #c9c9ff;}
        
	</style>
</head>
<body>

	<h1><span>LAPORAN</span>PERKEMBANGAN PELAKSANAAN PROGRAM DAN KEGIATAN APBD KOTA PEMATANGSIANTAR
<br>
BELANJA TIDAK LANGSUNG DAN BELANJA LANGSUNG TAHUN ANGGARAN <?php echo $year; ?>
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
				<th rowspan="4">JUMLAH SP2D</th>
				<th rowspan="4">SISA DANA (DPA) Rp</th>
				<th colspan="7">PERKEMBANGAN KEMAJUAN</th>
				<th rowspan="4">SISA DANA YG BELUM / TIDAK DIREALISASI</th>
				<th rowspan="4">%</th>
			</tr>
			<tr> 
				<th colspan="2">FISIK</th>
				<th colspan="5">KEUANGAN</th>
			</tr>
			<tr> 
				<th rowspan="2">RENC (%)</th>
				<th rowspan="2">REAL (%)</th>
				<th rowspan="2">SD BULAN LALU (Rp)</th>
				<th colspan="2">BULAN INI</th>
				<th colspan="2">S/D BULAN INI</th>
			</tr>
			<tr> 
				<th>Rp</th>
				<th>%</th>
				<th>Rp</th>
				<th>%</th>
			</tr>
			<tr>
				<th>1</th>
				<th>2</th>
				<th>3</th>
				<th>4</th>
				<th>5,00</th>
				<th>6</th>
				<th>7=5-6</th>
				<th>8</th>
				<th>9</th>
				<th>10</th>
				<th>11</th>
				<th>12</th>
				<th>13</th>
				<th>14</th>
				<th>15=6-3</th>
				<th>16</th>
			</tr>
		</thead>
		<tbody>
    
 <tr class="belanja">
    <td></td>
    <td align="right"> <nobr> <?php echo $code_dppa; ?> 00 00 5</nobr></td>
    <td> BELANJA </td> 
    <td> <?php echo $source; ?> </td> <!-- sumber -->
    <td> <?php echo idr_format($pagu) ?> </td> <!-- pagu dpa -->
    <td> <?php echo idr_format($transaction_amount); ?> </td> <!-- jumlah SP2D -->
    <td> <?php echo idr_format($pagu-$transaction_amount); ?> </td> <!-- Sisa Dana DPA -->
    <td>100</td>
    <td> <?php echo number_format(@floatval($transaction_amount/$pagu*100),1); ?> </td>
    <td> <?php echo idr_format($previous_progress); ?> </td> <!-- Opening Saldo -->
    <td> <?php echo idr_format($now_progress); ?> </td> <!-- Progress Bulan Ini -->
    <td> <?php echo number_format(@floatval($now_progress/$pagu*100),1); ?> </td>
    <td> <?php echo idr_format($total_progress); ?> </td>
    <td> <?php echo number_format(@floatval($total_progress/$pagu*100),1); ?> </td>
    <td> <?php echo idr_format($rest_balance); ?> </td>
    <td> <?php echo number_format(@floatval($rest_balance/$pagu*100),1); ?> </td>
</tr>   

<!--belanja tidak langsung-->

 <tr class="jenis-belanja">
    <td></td>
    <td align="right"> <nobr> <?php echo $code_dppa; ?> 00 00 5 1</nobr></td>
    <td>  BELANJA TIDAK LANGSUNG </td> 
    <td> </td> <!-- sumber -->
    <td> <?php echo idr_format($pagu_1) ?> </td> <!-- pagu dpa -->
    <td> <?php echo idr_format($transaction_amount_1); ?> </td> <!-- jumlah SP2D -->
    <td> <?php echo idr_format($pagu_1-$transaction_amount_1); ?> </td> <!-- Sisa Dana DPA -->
    <td>100</td>
    <td> <?php echo number_format(@floatval($transaction_amount_1/$pagu_1*100),1); ?> </td>
    <td> <?php echo idr_format($previous_progress_1); ?> </td> <!-- Opening Saldo -->
    <td> <?php echo idr_format($now_progress_1); ?> </td> <!-- Progress Bulan Ini -->
    <td> <?php echo number_format(@floatval($now_progress_1/$pagu_1*100),1); ?> </td>
    <td> <?php echo idr_format($total_progress_1); ?> </td>
    <td> <?php echo number_format(@floatval($total_progress_1/$pagu_1*100),1); ?> </td>
    <td> <?php echo idr_format($rest_balance_1); ?> </td>
    <td> <?php echo number_format(@floatval($rest_balance_1/$pagu_1*100),1); ?> </td>
</tr>            
            
<?php
    
    // general load class
    $acc = new Account_lib();
    $bl = new Balance_lib();       
    $tr = new Transaction_lib();
    $rpt = new Report_lib();
            
     
    // fungsi mendapatkan belanja pegawai ex: 511  belanja :1     
    if ($account_category_1)
    {
        foreach ($account_category_1 as $res)
        {
           $pagu = $bl->get_account_category_balance($dppa_id,$year,$res->category);
           $sp2d = $tr->get_total_monthly_category_balance($dppa_id,$res->category,$month,$year,0);
           $prev = $tr->get_total_monthly_category_previous_balance($dppa_id,$res->category,$month,$year);      
           $prog = $tr->get_total_monthly_category_balance($dppa_id,$res->category,$month,$year,1);
            
 echo $rpt->table($res->category, $acc->get_belanja_type($res->category), $pagu,$sp2d,$prev,$prog,'kategori-belanja');
          $rpt->get_trans_parent_acc($res->category,$dppa_id,$month,$year);
        }
    }

?>
 
<!--belanja langsung-->

 <tr class="jenis-belanja">
    <td></td>
    <td align="right"> <nobr> <?php echo $code_dppa; ?> 00 00 5 2</nobr></td>
    <td> BELANJA LANGSUNG </td> 
    <td> </td> <!-- sumber -->
    <td> <?php echo idr_format($pagu_2) ?> </td> <!-- pagu dpa -->
    <td> <?php echo idr_format($transaction_amount_2); ?> </td> <!-- jumlah SP2D -->
    <td> <?php echo idr_format($pagu_2-$transaction_amount_2); ?> </td> <!-- Sisa Dana DPA -->
    <td>100</td>
    <td> <?php echo number_format(@floatval($transaction_amount_2/$pagu_2*100),1); ?> </td>
    <td> <?php echo idr_format($previous_progress_2); ?> </td> <!-- Opening Saldo -->
    <td> <?php echo idr_format($now_progress_2); ?> </td> <!-- Progress Bulan Ini -->
    <td> <?php echo number_format(@floatval($now_progress_2/$pagu_2*100),1); ?> </td>
    <td> <?php echo idr_format($total_progress_2); ?> </td>
    <td> <?php echo number_format(@floatval($total_progress_2/$pagu_2*100),1); ?> </td>
    <td> <?php echo idr_format($rest_balance_2); ?> </td>
    <td> <?php echo number_format(@floatval($rest_balance_2/$pagu_2*100),1); ?> </td>
</tr>  
            
<?php
            
    // fungsi mendapatkan program belanja langsung 
    if ($program)
    {
        foreach ($program as $res)
        {
           $pagu = $bl->get_balance_based_top_program($dppa_id,$year,$res->id);
           $sp2d = $tr->get_total_monthly_based_program($dppa_id,$res->id,'null',$month,$year,0);
           $prev = $tr->get_total_monthly_based_program($dppa_id,$res->id,'null',$month,$year,2);
           $prog = $tr->get_total_monthly_based_program($dppa_id,$res->id,'null',$month,$year,1);
            
           echo $rpt->table($res->code, ucfirst($res->name), $pagu,$sp2d,$prev,$prog,'program');
           $rpt->get_trans_based_jenis_kegiatan($dppa_id,$res->id,$month,$year);
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
            <?php //echo strtoupper(get_month($month)).'  '.$year; ?>
            <br>MENGETAHUI :</b><br>&nbsp;<br><br></td>
			</tr><tr>
			<td valign="top" width="50%" align="center">
				 
				Kepala Bagian Administrasi Pembangunan Kasubbag Evaluasi dan Pelaporan <br>	
				Sekretariat Daerah Kota Pematangsiantar Sekretariat Daerah Kota Pematangsiantar<br><br><br><br><br><br><br>

			</td>
			<td valign="top" width="50%" align="center">
				
				Kasubbag Evaluasi dan Pelaporan<br>
				Sekretariat Daerah Kota Pematangsiantar<br><br><br><br><br><br><br>
			</td>
		</tr>
	</table>
-->

</body>
</html>