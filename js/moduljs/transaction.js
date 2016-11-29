$(document).ready(function (e) {
	
	$('#datatable-buttons').dataTable({
	 dom: 'T<"clear">lfrtip',
		tableTools: {"sSwfPath": site}
	 });
	
    // function general
    load_data(type);
	
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
				
				// protected $field = array('id', 'type', 'account_id', 'category_id', 'dppa_id', 'priority', 'source', 'amount', 'year', 'created', 'updated', 'deleted');
				res = result.split("|");
				resets();
				$("#tid_update").val(res[0]);
				$('#csources_update').val(res[6]).change();
				$("#tamount_update").val(res[7]);
				$("#tyear_update").val(res[9]);
			}
		})
		return false;	
	});
	
	// search form
	$('#searchform').submit(function() {
		
		var category = $("#ccategory_search").val();
		var type = $("#ctype_search").val();
		var year = $("#tyear_search").val();
		var dppa = $("#cdppa_search").val();
		var param = ['searching',dppa,category,type,year];
		
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data) {
				
				if (!param[1]){ param[1] = 'null'; }
				if (!param[2]){ param[2] = 'null'; }
				if (!param[3]){ param[3] = 'null'; }
				if (!param[4]){ param[4] = 'null'; }
				load_data_search(param);
			}
		})
		return false;
		swal('Error Load Data...!', "", "error");
		
	});

		
// document ready end	
});

	function load_data_search(search=null)
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();
			
		    $.ajax({
				type : 'GET',
				url: source+"/"+search[0]+"/"+search[1]+"/"+search[2]+"/"+search[3]+"/"+search[4],
				//force to handle it as text
				contentType: "application/json",
				dataType: "json",
				success: function(s) 
				{   
				       console.log(s);
					  
						oTable.fnClearTable();
						$(".chkselect").remove()
	
		$("#chkbox").append('<input type="checkbox" name="newsletter" value="accept1" onclick="cekall('+s.length+')" id="chkselect" class="chkselect">');
							
							for(var i = 0; i < s.length; i++) {
						  oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][4],
										s[i][3],
										s[i][2],
										s[i][6],
										s[i][7],
										s[i][8]
										    ]);										
											} // End For 
											
				},
				error: function(e){
				   oTable.fnClearTable();  
				   //console.log(e.responseText);	
				}
				
			});  // end document ready	
			
        });
	}

    function resets()
    {
	  $(document).ready(function (e) {
		  
		 $("#tname,#tcode,#cparent,#cparent,#torder,#ctype,#tdesc").val("");
		 $("#csources_update,#tamount_update").val("");
	  });
    }
	
// fungsi load data
	function load_data(type='dppa')
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();
			var atr = "";
			
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
						
if (type=='dppa')						
{

			$("#chkbox").append('<input type="checkbox" name="newsletter" value="accept1" onclick="cekall('+s.length+')" id="chkselect" class="chkselect">');							
							for(var i = 0; i < s.length; i++) {
							 if (s[i][3] == 'Top'){ atr = "fa fas-2x fa-edit"; }else{ atr = ""; }
							 oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][4],
										s[i][3],
										s[i][2],
										s[i][6],
										s[i][7],
										s[i][8],
'<a href="" class="text-primary" id="' +s[i][0]+ '" title=""> <i class="'+atr+'"> </i> </a>'+
'<a href="#" class="text-danger" id="'+s[i][0]+'" title="delete"> <i class="fa fas-2x fa-trash"> </i> </a>'
											   ]);										
											} // End For
	
}
else{
			$("#chkbox").append('<input type="checkbox" name="newsletter" value="accept1" onclick="cekall('+s.length+')" id="chkselect" class="chkselect">');							
							for(var i = 0; i < s.length; i++) {
							 if (s[i][3] == 'Top'){ atr = "fa fas-2x fa-edit"; }else{ atr = ""; }
							 oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][4],
										s[i][3],
										s[i][2],
										s[i][6],
										s[i][7],
										s[i][8]
											   ]);										
											} // End For
}

											
											
				},
				error: function(e){
				   console.log(e.responseText);	
				   oTable.fnClearTable(); 
				}
				
			});  // end document ready	
			
        });
	}
	// batas fungsi load data