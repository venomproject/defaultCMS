<div class="box box-warning">
				
<div class="small-box bg-yellow">
			  
		<div class="inner" class="overflow:hidden;">
            <div class="col-md-8">
		           <h3>Wgraj plik</h3>
                  <p>Wgraj plik a następnie zapisz ustawienia.</p>	
			</div>
						
            <div class="col-md-4">

<span class="btn btn-success fileinput-button">
    <i class="glyphicon glyphicon-plus"></i>
    <span>Wgraj plik</span>
    <input id="fileupload" type="file" name="files[]" multiple data-url="/themes/Admin/jQuery-File-Upload/server/php/" >
</span>

<div id="progress" class="progress" style="margin-top:20px;">
        <div class="progress-bar progress-bar-success"></div>
</div>
			</div>

		</div>
	</div>  
</div>

 <link rel="stylesheet" href="<%= $this->Page->Theme->BaseUrl%>/jQuery-File-Upload/css/jquery.fileupload.css">
  <script src="<%= $this->Page->Theme->BaseUrl%>/jQuery-File-Upload/js/jquery.fileupload.js"></script>
  <script type="text/javascript">
	  jQuery(function() {
		  jQuery('#fileupload').fileupload({
		        dataType: 'json',
		        progressall: function (e, data) {
		            var progress = parseInt(data.loaded / data.total * 100, 10);
		            jQuery('#progress .progress-bar').css(
		                'width',
		                progress + '%'
		            );
		        }
		    });
	  });
  </script>