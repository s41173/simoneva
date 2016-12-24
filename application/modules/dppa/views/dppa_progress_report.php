<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="shortcut icon" href="<?php echo base_url().'images/fav_icon.png';?>" >
    <title> <?php echo isset($title) ? $title : ''; ?>  </title>
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
    
    <?php
      
       function statusx($skpd,$month,$year)
       {
          $tr = new Transaction_lib();
          $res = $tr->cek_monthly($skpd,$month,$year);
          if ($res == true){ return '&#10003;'; }else { return ''; }
       }
       
       if ($skpd)
       {
           $i=1;
           foreach ($skpd as $res)
           {
               echo "
               <tr>
               <td> ".$i." </td>
               <td> ".strtoupper($res->name)." </td>
               <td> ".statusx($res->id,1,$year)." </td>
               <td> ".statusx($res->id,2,$year)." </td>
               <td> ".statusx($res->id,3,$year)." </td>
               <td> ".statusx($res->id,4,$year)." </td>
               <td> ".statusx($res->id,5,$year)." </td>
               <td> ".statusx($res->id,6,$year)." </td>
               <td> ".statusx($res->id,7,$year)." </td>
               <td> ".statusx($res->id,8,$year)." </td>
               <td> ".statusx($res->id,9,$year)." </td>
               <td> ".statusx($res->id,10,$year)." </td>
               <td> ".statusx($res->id,11,$year)." </td>
               <td> ".statusx($res->id,12,$year)." </td>
               <td> </td>
               </tr>
               ";
               $i++;
           }
       }
    
    ?>
    
</table>
<br><br>
<b><br>
KEPALA BAGIAN ADMINISTRASI PEMBANGUNAN<br><br><br><br><br>
POLTAK MANURUNG, SE<br>
NIP : 9999 999999
	</b>
</body>
</html>