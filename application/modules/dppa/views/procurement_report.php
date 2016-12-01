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
		tbody tr td:nth-child(3),
		tbody tr td:nth-child(4),
		tbody tr td:nth-child(7),
		tbody tr td:nth-child(15),
		tbody tr td:nth-child(5),
		tbody tr td:nth-child(6),
		tbody tr td:nth-child(16),
		tbody tr td:nth-child(10){
			text-align: center;
		}
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
			<tr>
				<td></td>
				<td align="right"> <nobr>			1 02 1 02 02 00 00 5</nobr></td>
				<td>Belanja</td> 
				<td>DAU</td> 
				<td>32.627.856.188</td>
				<td>1.467.139.774</td>
				<td> PT. Coba Coba 2 </td>
				<td>100</td>
				<td>4</td>
				<td>0</td>
				<td>74</td>
				<td>4. 000. 000</td>
				<td>1.467.139.774</td>
				<td>4</td>		 
			</tr>
				<tr>
				<td></td>
				<td align="right"> <nobr>			1 02 1 02 02 00 00 5</nobr></td>
				<td>Belanja</td> 
				<td>DAU</td> 
				<td>32.627.856.188</td>
				<td>1.467.139.774</td>
				<td> PT. Coba Coba </td>
				<td>100</td>
				<td>4</td>
				<td>0</td>
				<td>74</td>
				<td>4. 000. 000</td>
				<td>1.467.139.774</td>
				<td>4</td>
		 
			</tr>
			 
		</tbody>
	</table>


	<style>
		.xx{
			margin-top: 20px;
		}
		.xx,
		.xx td{
			border: 0 !important;
			font
		}
	</style>

	<table width="100%" class="xx">
		<tr>
			<td colspan="2" align="center"><b><br> PEMATANG SIANTAR,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo strtoupper(get_month($month)).'  '.$year; ?> <br>MENGETAHUI :</b><br>&nbsp;<br><br></td>
			</tr><tr>
			<td valign="top" width="50%" align="center">
				 
				Kepala Bagian Administrasi Pembangunan Kasubbag Evaluasi dan Pelaporan <br>	
				Sekretariat Daerah Kota Pematangsiantar Sekretariat Daerah Kota Pematangsiantar<br><br><br><br><br><br><br>

				<?php echo $bendahara; ?> <br>
				NIP : <?php echo $bendahara_nip; ?>

			
 

			</td>
			<td valign="top" width="50%" align="center">
				
				Kasubbag Evaluasi dan Pelaporan<br>
				Sekretariat Daerah Kota Pematangsiantar<br><br><br><br><br><br><br>


				<?php echo $kadis; ?> <br/>
				NIP : <?php echo $kadis_nip; ?>
			</td>
		</tr>
	</table>

</body>
</html>