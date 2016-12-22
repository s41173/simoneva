<!DOCTYPE html>
<html>
    <!--
  * Please see the included README.md file for license terms and conditions.
  -->

    <head>
        <link rel="shortcut icon" href="<?php echo base_url().'images/fav_icon.png';?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>mcss/united/css/united.min.css" class="uib-framework-theme">
        <meta charset="UTF-8">
        <title> SISMONEVA - Login </title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">

        <!--
  * The "meta viewport" tag (below) helps your app size appropriately to a device's ideal viewport.
  * Note that Windows device viewports work better when initialized using the @viewport CSS rule.
  * For a quick overview of "meta viewport" and @viewport, see this article:
  *   http://webdesign.tutsplus.com/tutorials/htmlcss-tutorials/quick-tip-dont-forget-the-viewport-meta-tag
  * To see how it works, try your app on a real device with and without a "meta viewport" tag.
  * Additional useful references include:
  *   http://www.quirksmode.org/mobile/viewports.html
  *   http://www.quirksmode.org/mobile/metaviewport/devices.html
  *   https://developer.apple.com/library/safari/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html
-->

        <!-- <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1"> -->
        <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1, user-scalable=no">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes, minimum-scale=1, maximum-scale=2"> -->

        <style>
            /* following three (cascaded) are equivalent to above three meta viewport statements */
            /* see http://www.quirksmode.org/blog/archives/2014/05/html5_dev_conf.html */
            /* see http://dev.w3.org/csswg/css-device-adapt/ */
                @-ms-viewport { width: 100vw ; min-zoom: 100% ; zoom: 100% ; }          @viewport { width: 100vw ; min-zoom: 100% zoom: 100% ; }
                @-ms-viewport { user-zoom: fixed ; min-zoom: 100% ; }                   @viewport { user-zoom: fixed ; min-zoom: 100% ; }
                /*@-ms-viewport { user-zoom: zoom ; min-zoom: 100% ; max-zoom: 200% ; }   @viewport { user-zoom: zoom ; min-zoom: 100% ; max-zoom: 200% ; }*/
        </style>

        <link rel="stylesheet" href="<?php echo base_url(); ?>mcss/css/app.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>mcss/css/index_main.less.css" class="main-less">
        
       <script type="text/javascript" src="<?php echo base_url().'js/jquery.min.js'; ?>"></script>
    
       <!-- sweet alert js -->
       <script type="text/javascript" src="<?php echo base_url().'js/sweetalert/sweetalert.min.js'; ?>"></script>
       <style type="text/css">@import url("<?php echo base_url() . 'js/sweetalert/sweetalert.css'; ?>");</style>
        
        <script type="text/javascript">

$(document).ready(function (e) {
	
	
	
	$('#user,#pass').keypress(function (e) {
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
        $('#loginbutton').click(); 
	  }
	});   
	
	$('#loginbutton').click(function() 
	{
		var user = $("#user").val();
		var pass = $("#pass").val();
		
		if (user != "" && pass != "")
		{
			var nilai = '{ "user":"'+user+'", "pass": "'+pass+'"}';
				
			$.ajax({
				type: 'POST',
                url: '<?php echo site_url('login/login_process'); ?>',
				data : nilai,
			    contentType: "application/json",
                dataType: 'json',
				success: function(data) 
			    {
					if (data.Success == true){ window.location = "<?php echo site_url('main'); ?>"; }
					else{ swal(data.Info, "", "error"); }
				}
			}) 
			return false;
            swal('Error Login...!', "", "error");
			
		}
		else{ swal("Invalid Username Or Password..!!", "", "error"); }
		
	});


// document ready end	
});

</script>
        
    </head>

    <body>
        <!-- IMPORTANT: Do not include a weinre script tag as part of your release builds! -->
        <!-- Place your remote debugging (weinre) script URL from the Test tab here, if it does not work above -->
        <!-- <script src="http://debug-software.intel.com/target/target-script-min.js#insertabiglongfunkynumberfromthexdkstesttab"></script> -->
        <div class="upage" id="mainpage">

            <div class="upage-outer">
                <div class="uib-header header-bg container-group inner-element uib_w_1" data-uib="layout/header" data-ver="0">
                    <h2>SISMONEVA</h2>
                    <div class="widget-container wrapping-col single-centered"></div>
                    <div class="widget-container content-area horiz-area wrapping-col left"></div>
                    <div class="widget-container content-area horiz-area wrapping-col right"></div>
                </div>
                <div class="upage-content ac0 content-area vertical-col left" id="page_98_18">
                    <div class="widget uib_w_3 scale-image d-margins" data-uib="media/img" data-ver="0">
                        <figure class="figure-align">
                            <img src="<?php echo base_url(); ?>images/property/logo.jpg">

                            <figcaption data-position="bottom"></figcaption>
                        </figure>
                    </div>
                    <div class="table-thing widget uib_w_4 d-margins" data-uib="twitter%20bootstrap/input" data-ver="1">
                        <label class="narrow-control"></label>
                        <input class="wide-control form-control default" type="text" placeholder="Username" id="user" name="tusername">
                    </div>
                    <div class="table-thing widget uib_w_5 d-margins" data-uib="twitter%20bootstrap/input" data-ver="1">
                        <label class="narrow-control"></label>
                        <input class="wide-control form-control default" type="password" placeholder="Password" id="pass" name="tpassword">
                    </div>
<button class="btn widget uib_w_6 d-margins btn-success" id="loginbutton" data-uib="twitter%20bootstrap/button" data-ver="1">LOGIN</button>
                    <div class="tarea widget uib_w_7" data-uib="media/text" data-ver="0" name="uib_w_7">
                        <div class="widget-container left-receptacle"></div>
                        <div class="widget-container right-receptacle"></div>
                        <div class="text-container"></div>
                    </div>
                </div>
                <div class="uib-footer uib-footer-fixed footer-bg container-group inner-element uib_w_2" data-uib="layout/footer" data-ver="0">
                    <h2></h2>
                    <div class="widget-container wrapping-col single-centered"></div>
                    <div class="widget-container content-area horiz-area wrapping-col left"></div>
                    <div class="widget-container content-area horiz-area wrapping-col right"></div>
                </div>
            </div>
        </div>
    </body>

</html>