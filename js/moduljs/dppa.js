$(document).ready(function (e) {
	
	$('#datatable-buttons').dataTable({
	 dom: 'T<"clear">lfrtip',
		tableTools: {"sSwfPath": site}
	 });
	
    // function general
    load_data();
	
	// reset form
	$("#breset,#bclose").click(function(){
	   resets();
	});
	
	// fungsi jquery update
	$(document).on('click','.text-primary',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_get +"/"+ del_id;
		$(".error").fadeOut();
		
		$("#myModal2").modal('show');
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				
				res = result.split("|");
				resets();
				$("#tid_update").val(res[0]);
				$("#tcode_update").val(res[1]);
				$("#tname_update").val(res[2]);
				$("#tbendahara_update").val(res[3]);
				$("#tbendahara_nip_update").val(res[4]);
				$("#tkadis_update").val(res[5]);
				$("#tkadis_nip_update").val(res[6]);
				$('#cparent_update').val(res[7]).change();
				$("#catimg_update").attr("src",res[8]);
			}
		})
		return false;	
	});
	
	// publish status
	$(document).on('click','.primary_status',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_primary +"/"+ del_id;
		$(".error").fadeOut();
		
		// $("#myModal2").modal('show');
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				
				res = result.split("|");
				if (res[0] == "true")
				{   
			        error_mess(1,res[1],0);
					load_data();
				}
				else if (res[0] == 'warning'){ error_mess(2,res[1],0); }
				else{ error_mess(3,res[1],0); }
			}
		})
		return false;	
	});
	
	// fungsi dppa category
	$(document).on('click','.text-dppa',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_dppa +"/"+ del_id;
		
		window.location.href = url;
		
	});
	
	// fungsi dppa money
	$(document).on('click','.text-money',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_balance +"/"+ del_id;
		
		window.location.href = url;
		
	});
	
	// fungsi dppa money
	$(document).on('click','.text-transaction',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_transaction +"/"+ del_id;
		
		window.location.href = url;
		
	});
	
		// fungsi dppa money
	$(document).on('click','.text-procurement',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_procurement +"/"+ del_id;
		
		window.location.href = url;
		
	});
	
		
// document ready end	
});

    function resets()
    {
	  $(document).ready(function (e) {
		  
		 $("#tname,#uploadImage").val("");
		 $("#catimg,#catimg_update").attr("src","");
	  });
    }

// fungsi load data
	function load_data()
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();
			var stts = 'btn btn-danger';

		    $.ajax({
				type : 'GET',
				url: source,
				//force to handle it as text
				contentType: "application/json",
				dataType: "json",
				success: function(s) 
				{
					 console.log(s);
						oTable.fnClearTable();
						$(".chkselect").remove();
							
		$("#chkbox").append('<input type="checkbox" name="newsletter" value="accept1" onclick="cekall('+s.length+')" id="chkselect" class="chkselect">');
							
							for(var i = 0; i < s.length; i++) {
							if (s[i][7] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }	
							 oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][1],
										s[i][2],
										s[i][3],
										s[i][5],
										s[i][6],
'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Primary Status"> <i class="fa fa-wrench"> </i> </a> '+
'<a href="" class="btn btn-primary btn-xs text-dppa" id="' +s[i][0]+ '" title="Category Status"> <i class="fa fa-cogs"> </i> </a>'+
'<a href="" class="btn btn-warning btn-xs text-money" id="' +s[i][0]+ '" title="Balance Status"> <i class="fa fa-money"> </i> </a> '+
'<a href="" class="btn btn-info btn-xs text-transaction" id="' +s[i][0]+ '" title="Transaction Status"> <i class="fa fa-calculator"> </i> </a> '+
'<a href="" class="btn btn-danger btn-xs text-procurement" id="' +s[i][0]+ '" title="Procurement Status"> <i class="fa fa-shopping-cart"> </i> </a> '+
'<a href="" class="text-primary" id="' +s[i][0]+ '" title=""> <i class="fa fas-2x fa-edit"> </i> </a> <a href="#" class="text-danger" id="'+s[i][0]+'" title="delete"> <i class="fa fas-2x fa-trash"> </i> </a>'
											   ]);										
											} // End For
											
											
				},
				error: function(e){
				   console.log(e.responseText);	
				   oTable.fnClearTable(); 
				}
				
			});  // end document ready	
			
        });
	}
	// batas fungsi load data