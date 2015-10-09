<!DOCTYPE html>
<html lang="pl">
<com:THead Title="<%= $this->title %>">

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device_display, initial-scale=1.0" />
	<meta name="keywords" content="<%= $this->keywords %>" />
	<meta name="description" content="<%= $this->description %>" />

	<script src="<%= $this->Page->Theme->BaseUrl %>/js/jquery-1.11.0.js"></script>
	<link rel="stylesheet"
		href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<link href="<%= $this->Page->Theme->BaseUrl %>/css/bootstrap.min.css"
		rel="stylesheet">
	<script src="<%= $this->Page->Theme->BaseUrl %>/js/bootstrap.min.js"
		type="text/javascript"></script>
		
		<link href="<%= $this->Page->Theme->BaseUrl %>/css/font-awesome.min.css"
		rel="stylesheet">	
		
</com:THead>
<body>
	<com:TForm>
<div id="carousel-example-generic" class="carousel slide carousel-fade " data-ride="carousel"  style="height:<%= in_array($this->getPage()->getPagePath() , array("Home"))  ? '900px' : '313px'%>">

  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="UserFiles/Slider/bg.jpg" alt="...">
      <div class="carousel-caption">
	    <h3>123</h3>
	    <p>dsadadas.</p>
	  </div>
    </div>
  </div>
</div>


<header style="margin-bottom:<%= in_array($this->getPage()->getPagePath() , array("Home"))  ? '665px' : '100px'%>">
			<a href="<%= $this->Service->constructUrl ('Home') %>">
				<img class="img-responsive center-block"
					src="<%= $this->Page->Theme->BaseUrl%>/images/logo.png" alt="Logo" id="logo"
					 />
				</a>	
					<com:NavigationBox/>
</header>


	





		<div class="container">
		
			<div class="row">
				<com:TContentPlaceHolder id="content" />
			</div>
			
	

		
<div class="row ">
<com:TRepeater ID="Footer"  AllowPaging="true" PageSize="3" >
		<prop:ItemTemplate>
<div class="col-md-4 ">
<h2><%= $this->Data->Name %></h2>
<%= $this->Data->ShortDescription %>
<a target="_self" class="btn btn-primary btn-normal btn-inline " title="Czytaj więcej" href="<%=$this->Service->constructUrl('Pages', array('id' => $this->Data->ID)) %>">Czytaj więcej</a> </div>
		</prop:ItemTemplate>
</com:TRepeater>
</div>

</div>

	<footer>
	<div class="container">
	<div class="row">
	<div class="col-md-4 col-xs-12 ">
		<img src="<%= $this->Page->Theme->BaseUrl%>/images/logo.png"><br/>
		&copy; <%= $this->StaticPhrase['Copyright'] != '' ? $this->StaticPhrase['Copyright'] : '' %>
	</div>
<div class="col-md-4 col-xs-12 pull-right">
				<a href="<%= $this->StaticPhrase['Facebook'] != '' ? $this->StaticPhrase['Facebook'] : '#' %>"><i class="fa fa-facebook"></i></a>
				<a href="<%= $this->StaticPhrase['Twitter'] != '' ? $this->StaticPhrase['Twitter'] : '#' %>"><i class="fa fa-twitter"></i></a>
				<a href="<%= $this->StaticPhrase['YouTube'] != '' ? $this->StaticPhrase['YouTube'] : '#' %>"><i class="fa fa-youtube"></i></a>
</div>

		<com:Footer />
		</div>
		
			
		
		

	
		
		
		
		
		
		</div>
</footer>		

		

	</com:TForm>
	<script
		src="<%= $this->Page->Theme->BaseUrl %>/cookies/divante.cookies.min.js"
		type="text/javascript"></script>
	<script
		src="<%= $this->Page->Theme->BaseUrl %>/cookies/jquery.cookie.min.js"
		type="text/javascript"></script>

	<link rel="stylesheet"
		href="<%= $this->Page->Theme->BaseUrl %>/fancybox/source/jquery.fancybox.css?v=2.1.5"
		type="text/css" media="screen" />
	<script type="text/javascript"
		src="<%= $this->Page->Theme->BaseUrl %>/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

	<script>
		window.jQuery.cookie
				|| document
						.write('<script src="<%= $this->Page->Theme->BaseUrl %>/jquery.cookie.min.js"><\/script>')
	</script>


	<script type="text/javascript">
		jQuery.divanteCookies.render({
			privacyPolicy : true,
			cookiesPageURL : "<%=$this->Service->constructUrl('Cookies') %>"
		});
		jQuery(".fancybox").fancybox();
		jQuery(function() {
			jQuery("#openFB").css("left", "-210px");
			jQuery("#openFB").hover(function() {
				jQuery("#openFB").animate({
					left : "0px"
				}, 1000);
				jQuery(this).addClass("closeFB");
			}, function() {
				jQuery("#openFB").animate({
					left : "-210px"
				}, 1000);
				jQuery(this).removeClass("closeFB");
			});
		})
	</script>


</body>
</html>