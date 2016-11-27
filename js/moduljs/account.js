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
		var url = sites_get +"/"+ del_id+"/update";
		$(".error").fadeOut();
		
		$("#myModal2").modal('show');
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				
				// $field = array('id', 'parent_id', 'category', 'code', 'name', 'description', 'publish', 'created', 'updated', 'deleted');
				
				res = result.split("|");
				vals = res[7].split('-');
				console.log(res[0]);
				
				$("#tprefix_update").val(vals[0]);
				$("#tcode_update").val(vals[1]);
				
				// $('#cparent_update').val(res[1]).change();
				$('#ccategory_update').val(res[2]).change();
				$("#tname_update").val(res[4]);
				$("#tdesc_update").val(res[5]);
				
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
	
	// code generator
	$(document).on('change','#ccategory,#ccategory_update',function(e)
	{	
		$("#tprefix,#tprefix_update").val($(this).val());
	});
	
	// code generator by parent
	$(document).on('change','#cparent,#cparent_update',function(e)
	{			
		e.preventDefault();
		var element = $(this);
		var del_id = $(this).val();
		var url = sites_get +"/"+ del_id;
		
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				
				res = result.split("|");
				val = res[7].split("-");
				$("#tprefix").val(val[0]);
				$("#tprefix_update").val(val[0]);
				$("#tcode").val(val[1]);
				$("#tcode_update").val(val[1]);
				$('#ccategory').val(res[2]).change();
				$('#ccategory_update').val(res[2]).change();
			}
		})
		return false;	
		
		
		
	});
		
// document ready end	
});

    function resets()
    {
	  $(document).ready(function (e) {
		 $("#cparent,#ccategory,#tcode,#tname,#tdesc").val("");
	  });
    }

// fungsi load data
	function load_data()
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();

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
							if (s[i][6] == 1){ stts = 'btn btn-success'; }else { stts = 'btn btn-danger'; }	
							 oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][2],
										s[i][1],
										s[i][3],
										s[i][4],
'<a href="" class="'+stts+' btn-xs primary_status" id="' +s[i][0]+ '" title="Primary Status"> <i class="fa fa-wrench"> </i> </a> <a href="" class="text-primary" id="' +s[i][0]+ '" title=""> <i class="fa fas-2x fa-edit"> </i> </a> <a href="#" class="text-danger" id="'+s[i][0]+'" title="delete"> <i class="fa fas-2x fa-trash"> </i> </a>'
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