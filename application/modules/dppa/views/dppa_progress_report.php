<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>

<style>
	*{
		margin: 0;
		text-align:center;
		font:normal 10px arial;
	}
	th{
		background: #ccc;
		font-weight: bold;
	}
	tr:nth-child(3) th{
		background: #eee !important;
		-webkit-print-color-adjust: exact; 
	}
	table,td,th{
		border: 1px solid #aaa !important;
		-webkit-print-color-adjust: exact; 
	}
	h1{
		font:bold 12px arial;
	}
	.xx td,
	.xx,
	.xx th{
		border:0 !important;
	}
	.logo{
		/*width: 40px;*/
		height: 60px;
	}
	b{
		font-weight: bold !important;
	}
</style>
<table class="xx" width="100%" border='1'>
	<tr>
		<td align="right" width="25%"><a href=""><img class="logo" src="<?php echo $logo; ?>" alt=""></a></td>
		<td width="50%">
			<h1>DAFTAR SKPD YANG MENGIRIMKAN DAN BELUM MENGIRIMKAN<br> LAPORAN PERKEMBANGAN KEGIATAN BELANJA LANGSUNG DAN BELANJA TIDAK LANGSUNG<br>
			APBD KOTA PEMATANGSIANTAR TAHUN ANGGARAN <?php echo $year; ?> </h1>
		</td>
		<td width="25%"></td>
	</tr>
</table>
<br><br>

<table border='1'  cellspacing="0" cellpadding="5" width="100%">
	<tr>
		<th rowspan="2">NO</th>
		<th rowspan="2">SKPD</th>
		<th colspan="12">DAFTAR LAPORAN TA <?php echo $year; ?> </th>
		<th rowspan="2">KETERANGAN</th>
	</tr>
	<tr>
		<th>JAN</th>
		<th>FEB</th>
		<th>MAR</th>
		<th>APR</th>
		<th>MEI</th>
		<th>JUN</th>
		<th>JUL</th>
		<th>AGU</th>
		<th>SEP</th>
		<th>OKT</th>
		<th>NOV</th>
		<th>DES</th>
	</tr>
	<tr>
	<script>
		for(var i=1; i<=15; i++){
			document.write('<th>'+i+'</th>');
		}
	</script>
 
	</tr>
	<tr>
		<td align="center">1</td>
		<td>DINAS PENDIDIKAN</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>&#10003;</td>
		<td>format tidak sesuai</td>
	</tr>
</table>
<br><br>
<b><br>
KEPALA BAGIAN ADMINISTRASI PEMBANGUNAN<br><br><br><br><br>
POLTAK MANURUNG, SE<br>
NIP : 9999 999999
	</b>
</body>
</html>