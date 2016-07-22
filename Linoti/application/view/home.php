<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Lin Application</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="imagetoolbar" content="yes">
<meta name="language" content="Indonesia">
<meta name="revisit-after" content="7">
<meta name="webcrawlers" content="all">
<meta name="rating" content="general">
<meta name="spiders" content="all">

<script type="text/javascript" src="<?php echo base_url();?>asset/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/js/clock.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery.equalheights.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/layout.css">
<link href="<?php echo base_url();?>asset/css/fonts/stylesheet.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/themes/sunny/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/themes/icon.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/css/smoothness/jquery-ui-1.7.2.custom.css">



<!--datepicker-->
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/ui.datepicker-id.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/ui.datepicker.js"></script>

<!--Polling-->
<script type="text/javascript" src="<?php echo base_url();?>asset/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>asset/js/exporting.js"></script>

<!-- notifikasi -->
<script type="text/javascript" src="<?php echo base_url();?>asset/js/notifikasi.js"></script>

 <!-- chatjs requirements -->
	<!--<script src="../ChakraNaga/asset/js/jquery.min.js"></script>-->
	<!--<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.autosize.js"></script>-->
	<!--<link rel="stylesheet" href="Styles/styles.css"/>-->

	<!-- chatjs files-->
	<!--
	<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.chatjs.utils.js"></script>
	<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.chatjs.adapter.servertypes.js"></script>
	<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.chatjs.adapter.js"></script>
	<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.chatjs.adapter.demo.js"></script>
	<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.chatjs.window.js"></script>
	<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.chatjs.messageboard.js"></script>
	<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.chatjs.userlist.js"></script>
	<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.chatjs.pmwindow.js"></script>
	<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.chatjs.friendswindow.js"></script>
	<script src="<?php echo base_url();?>asset/ChatJs/js/jquery.chatjs.controller.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>asset/ChatJs/css/jquery.chatjs.css"/> -->

<script type="text/javascript">
  $(document).ready(function() {
		var temp = 1;
		var height = $(window).height();
		var width = $(window).width();
		var content_height = height - 145;
		
		$.ajax({
        url: "<?php echo site_url(); ?>/ref_json/window_size",
        type: 'post',
        data: { 'width' : width, 'height' : height, 'recordSize' : 'true' },
				dataType:'json',
        success: function(response) {
           // $("body").html(response);
					 //$("#tt").tabs('resize');
					// $("#tt").tabs({heightStyle: "fill"});
					//$("#tt").resize(function(){
					//	$("#tt").equalHeights();
					//});
        }
    }); 
		
		$("#ttin").equalHeights(content_height,content_height);
		//alert(content_height);
		/*
		if (content_height>0){
			$("#tt").tabs('height',content_height);
		} */
		
		$(window).resize(function(){
			var height = $(window).height();
			var width = $(window).width();
			var content_height = height - 145;
			
			$("#ttin").equalHeights(content_height,content_height);
			
		}); 
		
    $('#menuaccordion').each(function() {
      var li = $(this);
      var a = $('a', li);
			var url = '<?php echo current_url(); ?>';
			
			if (temp==1){
			//alert(li.accordion('getSelected').toSource());
			//alert(url);
			}
      if(a.href==url) {
				
        li.addClass('active');
      }
			temp++;
    });
		
		//var pp = $('#menuaccordion').accordion('getSelected');
		//alert(pp.panel('options').title);
		var myheader = '<?php echo $myheader; ?>';
		//alert(myheader);
		$('#menuaccordion').accordion('select',myheader);
	
	
  });
</script>


<script type="text/javascript">
$(function() {
	$("#dataTable tr:even").addClass("stripe1");
	$("#dataTable tr:odd").addClass("stripe2");
	$("#dataTable tr").hover(
		function() {
			$(this).toggleClass("highlight");
		},
		function() {
			$(this).toggleClass("highlight");
		}
	);

});
</script>
<!--
<script type="text/javascript">
        $(function () {
            $.chat({
                // your user information
                userId: 1,
                // id of the room. The friends list is based on the room Id
                roomId: 1,
                // text displayed when the other user is typing
                typingText: ' is typing...',
                // title for the rooms window
                roomsTitleText: 'Rooms',
                // title for the 'available rooms' rab
                availableRoomsText: 'Available rooms',
                // text displayed when there's no other users in the room
                emptyRoomText: "There's no one around here. You can still open a session in another browser and chat with yourself :)",
                // the adapter you are using
                chatJsContentPath: '/ChatJs/',
                adapter: new DemoAdapter()
            });
        });
    </script>-->

<style type="text/css">
 
h1, h2 {
    display: inline-block;
}
<!--
html {
	overflow: -moz-scrollbars-vertical;
  overflow: scroll;
} -->
<!--
.wrapper {
    min-width: 1200px;
    max-width: 700px;
    margin: 0 auto;
}

#overlay {
    position: fixed;
    top: 0;
    width: 100%;
    height: 100%;
}

#overlay .wrapper {
    height: 100%;
} -->
<!--
body, html { 
    overflow-x: hidden; 
    overflow-y: auto;
}-->

</style>
</head>
<body onLoad="goforit()">
<!--<div id="overlay"><div class="wrapper">--><div class="header" style="height:30px;background:white;padding:2px;margin:0;">	
		<!--<div style="float:left; padding:0px; margin:0px;">
        <img src='<?php echo base_url('asset/images/chakranaga.jpg');?>' style="padding:0; margin:0;" width="285" height="71">
        </div>-->
        <div class="judul" style="float:left; line-height:3px; margin-top:0px; padding:2px 5px;">
        <h1><?php echo $instansi;?></h1>&nbsp;&nbsp;&nbsp;
      <b><?php echo $usaha;?></b>&nbsp;&nbsp;&nbsp;
      <?php echo $alamat_instansi;?>
      </div> 
		<div style="float:right; line-height:3px; text-align:center; margin-top:25px; padding:2px 5px;"> 
        <!--<h1><?php echo $nama_program;?></h1> -->
				<b>Copyright &copy; <?php echo $instansi;?> 2014 - <?php echo date('Y'); ?></b>
        </div>
	</div>	
	<div class="panel-header" fit="true" style="height:21px;padding-top:1px;text-align:left;">
		<div style="float:left;">
			<!--<a style="color:#fff;" href="<?php echo base_url();?>index.php/home" class="easyui-linkbutton" data-options="plain:true" iconCls="icon-home">Home</a>-->
      <a style="color:#fff;" href="<?php echo base_url();?>index.php/login/logout" class="easyui-linkbutton" data-options="plain:true" iconCls="icon-logout">Logout</a>
		</div>
		<div style="float:right; padding-top:5px;">
			<?php echo $this->app_model->CariNamaPengguna();?> &rarr;
            <span id="clock"></span>		
		</div>
	</div>
	<!-- awal kiri -->
    <div id="kiri" style="float:left;" >
    	<div id="Profil" class="easyui-panel" title="Menu"><!--
        <a href="<?php echo base_url();?>index.php/foto" title="Edit Foto">
        <img style="float:left;padding:2px;" src="<?php echo base_url();?>asset/foto_profil/<?php echo $this->app_model->CariFotoPengguna();?>" width="50" height="50" align="middle" />
        </a>
        <p style="line-height:15px;">
        <b><?php echo $this->app_model->CariNamaPengguna();?></b><br />
        <a href="<?php echo base_url();?>index.php/profil">Edit Profile</a>
        </p> -->
        </div>	
        <div class="easyui-accordion" style="float:left;width:170px;" id="menuaccordion" data-options="collapsible:false">
        	<?php
        		echo $this->load->view('menu_root_my');
			?>
				</div>
				
		</div><!--</div></div>-->
		<?php
				$mymenu = isset($mymenu) ? $mymenu : '';
			//	if ($mymenu!='Research'){ ?>
    <!--<div class="wrapper">--><!--<div id="tt" class="easyui-tabs">
        <div title="<?php //echo $judul;?>" style="padding:10px;">
		<?php// echo $content;?>	
        </div>
    </div>--><!--</div>-->
		<?php //} else { ?>
		<!--<div class="wrapper">--><div id="tt" class="easyui-tabs">
        <div id="ttin" title="<?php echo $judul;?>" style="padding:10px;">
		<?php echo $content;?>	
        </div>
    </div><!--</div>-->
		<?php //} ?>
<script type="text/javascript">
<!--
 
 var viewportwidth;
 var viewportheight;
  
 // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
  
 if (typeof window.innerWidth != 'undefined')
 {
      viewportwidth = window.innerWidth,
      viewportheight = window.innerHeight
 }
  
// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
 
 else if (typeof document.documentElement != 'undefined'
     && typeof document.documentElement.clientWidth !=
     'undefined' && document.documentElement.clientWidth != 0)
 {
       viewportwidth = document.documentElement.clientWidth,
       viewportheight = document.documentElement.clientHeight
 }
  
 // older versions of IE
  
 else
 {
       viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
       viewportheight = document.getElementsByTagName('body')[0].clientHeight
 }
//document.write('<p>Your viewport width is '+viewportwidth+'x'+viewportheight+'</p>');
//-->
</script>
<!--<div class="panel-header" fit="true" style="height:20px;text-align:center;">	    
Copyright &copy; <?php echo $instansi;?> 2014 - <?php echo date('Y'); ?>
</div>-->
</body>
</html>
