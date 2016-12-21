$(document).ready(function (e) {
	
	
	    
	$.getJSON(url, function (result) {

		var chart = new CanvasJS.Chart("chartContainer", {
			theme: "theme1",//theme1
			axisY:{title: "", },
  		    animationEnabled: true, 
			data: [
				{
					type: "bar",
					dataPoints: result
				}
			]
		});

		chart.render();
	});
	
	// chart 2
	
	$.getJSON(url2, function (result) {

		var chart = new CanvasJS.Chart("chartContainer2", {
			theme: "theme1",//theme1
			axisY:{title: "", },
  		    animationEnabled: true, 
			data: [
				{
					type: "column",
					dataPoints: result
				}
			]
		});

		chart.render();
	});
		
// document ready end	
});
	