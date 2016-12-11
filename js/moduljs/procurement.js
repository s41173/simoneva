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
				
				// $field = array($transaction->id, 
				                  // $transaction->type, $transaction->account_id, $transaction->category_id, $transaction->dppa_id, 
                       // $transaction->amount, $transaction->month, $transaction->opening, $transaction->progress_amount,
                       // $transaction->rest, $transaction->year);
					   
				res = result.split("|");
				resets();
				$("#tid_update").val(res[0]);
				$('#tmonth').val(res[6]);
				$('#tyear_update').val(res[10]);
				$('#tcategory').val(res[3]);
				$('#taccount').val(res[2]);
				$('#tbudget_update').val(res[11]);
				$('#topening_update').val(res[7]);
				$("#tamount_update").val(res[5]);
				$("#tprogress_update").val(res[8]);
				$("#trest_update").val(res[9]);
				$('#cmonth_update').val(res[12]);
			}
		})
		return false;	
	});
	
	// fungsi ajax combo
	$(document).on('change','#ccategory_account,#ccategory_account_update',function(e)
	{	
		e.preventDefault();
		var value = $(this).val();
		var year = $('#tyear').val();
		var url = sites_ajax+'/ajaxcombo/'+value+'/'+year;
		
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				$(".select_box").html(result);
			}
		})
		return false;	
	});
	
	// fungsi caccount get budget
	$(document).on('change','#caccount_balance',function(e)
	{	
		e.preventDefault();
		var acc = $(this).val();
		var month = $('#cmonth').val();
		var year = $('#tyear').val();
		var cat = $('#ccategory_account').val();
		var url = sites_ajax+'/get_sp2d/'+cat+'/'+acc+'/'+month+'/'+year;
		
		// batas
		$.ajax({
			type: 'POST',
			url: url,
    	    cache: false,
			headers: { "cache-control": "no-cache" },
			success: function(result) {
				res = result.split("|");
				$("#tamount").val(res[0]);
				$("#tprogress").val(res[1]);
				
			}
		})
		return false;	
	});
	
	
	// search form
	$('#searchform').submit(function() {
		
		var category = $("#ccategory_search").val();
		var month = $("#cmonth_search").val();
		var year = $("#tyear_search").val();
		var dppa = $("#cdppa_search").val();
		var param = ['searching',dppa,category,month,year];
		
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
// '<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][4],
										s[i][3],
										s[i][2],
										s[i][5],
										s[i][8],
										s[i][6]+' - '+s[i][7],
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
		  
		 $("#tamount,#tprogress,#tvendor,#tcontact,#tcontract,#tcontract_date,#tnilai").val("");
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
							 if (s[i][3] == 'Top'){ atr = ""; }else{ atr = ""; }
							 oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][4],
										s[i][3],
										s[i][2],
										s[i][5],
										s[i][8],
										s[i][6]+' - '+s[i][7],
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
// '<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][4],
										s[i][3],
										s[i][2],
										s[i][5],
										s[i][8],
										s[i][6]+' - '+s[i][7],
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