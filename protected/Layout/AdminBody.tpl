<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<com:THead Title="Panel administracyjny">
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta name="robots" content="none" />
	<com:TMetaTag HttpEquiv="Content-Type" Content="text/html; charset=utf-8" />
	
	<link href="<%= $this->Page->Theme->BaseUrl%>/font/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<%= $this->Page->Theme->BaseUrl%>/font/ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" />
	
	<link href="<%= $this->Page->Theme->BaseUrl%>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<%= $this->Page->Theme->BaseUrl%>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<%= $this->Page->Theme->BaseUrl%>/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
	<link href="<%= $this->Page->Theme->BaseUrl%>/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  
  
	 <script src="<%= $this->Page->Theme->BaseUrl%>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	 <script src="<%= $this->Page->Theme->BaseUrl%>/plugins/jQueryUI/jquery-ui-1.10.3.min.js"></script>
    <script src="<%= $this->Page->Theme->BaseUrl%>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</com:THead>

<body class="skin-blue sidebar-mini">
<com:TForm>
 <div class="wrapper" id="bodyContent">
<com:TPanel Visible="<%= !$this->User->IsGuest %>">
<com:HeaderAdmin/>
			<com:LeftAdmin/>

</com:TPanel>
			


<com:TContentPlaceHolder ID="content" />

<com:TPanel Visible="<%= !$this->User->IsGuest %>">
 <footer class="main-footer">
        <div class="pull-right hidden-xs">
          Panel CMS
        </div>
        <strong>Copyright &copy; 2015 </strong> All rights reserved.
      </footer>
</com:TPanel>      
</com:TForm>


    <script src="<%= $this->Page->Theme->BaseUrl%>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<%= $this->Page->Theme->BaseUrl%>/dist/js/app.min.js" type="text/javascript"></script>
	    
    <script type="text/javascript">
    //<![CDATA[
	function openKCFinder(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
            file: 'lib/KCFinder/browse.php?opener=tinymce&type=' + type,
            title: 'KCFinder',
            width: 700,
            height: 500,
            resizable: "yes",
            inline: true,
            close_previous: "no",
            popup_css: false
        }, {
        window: win,
        input: field_name
        });
        return false;
        }       
    //]]>
    </script>    
    
</body>
</html>