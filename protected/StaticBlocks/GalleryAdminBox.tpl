<div class="box box-warning">

<div class="small-box bg-yellow">
			  
		<div class="inner" class="overflow:hidden;">
            <div class="col-md-8">
		           <h3>Galeria</h3>
                  <p>W celu zmiany kolejności wyświetlania zdjęc wystarczy przeciągnąć odpowiedne zdjęcie, <br/>a następnie zapisać ustawienia.</p>	
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
		<com:TButton Text="Zapisz kolejność" OnCommand="SourceTemplateControl.PositionPhoto" CssClass="btn btn-block btn-danger"/>
	</div>  

<div class="box-body no-padding">

 <div class="example-modal">
            <div class="modal modal-primary">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edycja pliku</h4>
                  </div>
                  <div class="modal-body">
                   
					<div class="col-md-4">
						<img src="" alt="" id="prevModalSrc" style="margin-bottom:10px;"/>
						
						<div class="form-group">
						  <div class="checkbox">
							<label>
								<com:TCheckBox
									ID="MasterSrc"
								    Text="Oznacz jako główne"
								/>
							</label>
						  </div>
						</div>
						<div id="PhotoID">
						<com:TTextBox ID="IDSrc" Text="" CssClass="hidden" />
						</div>
					</div>

					<div class="col-md-8">
					
						<div class="form-group">
							<label>Opis</label>
							<com:TTextBox ID="DescriptionSrc" CssClass="form-control" />
						</div>
						
						
						<div class="form-group">
							<label>Link</label>
							<com:TTextBox ID="UrlSrc" CssClass="form-control" />
						</div>
					
					</div>
                    
                  </div>
                  <div class="modal-footer">
                    <com:TButton Text="Zapisz" ValidationGroup="req" OnClick="SourceTemplateControl.EditModal" CssClass="btn btn-outline"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          


	  <ul class="users-list clearfix photoList" id="sortable">
	  
	  <com:TRepeater ID="Files" AllowPaging="false">
		<prop:ItemTemplate>
		<li <%= $this->Data->IsParent == 1 ? 'style="border : 1px solid red;"' : '' %> >
		<img id="<%# $this->Data->ID %>" desc="<%# $this->Data->Description %>" master="<%# $this->Data->IsParent %>" link="<%# $this->Data->Url %>" src="UserFiles/<%=$this->SourceTemplateControl->pathName[0]%>/<%= $this->getRequest()->itemAt("id") %>/thumb/<%= $this->Data->Name %>" alt="zdjęcie" />
		<br/> 
		<span class="users-list-date" style="cursor:pointer;padding: 10px 25%;">
		<com:TButton  CommandName="<%# $this->Data->ID %>" CommandParameter="<%# $this->Data->Name %>" OnCommand="SourceTemplateControl.fileDelete" Text="Usuń" CssClass="btn btn-block btn-danger btn-xs"/></span>
	
		<com:TTextBox  Text="<%= $this->Data->ID %>" CssClass="hidden" />
		</li>	
		</prop:ItemTemplate>
		
		<prop:EmptyTemplate>
		
		<div class="alert alert-dismissable">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h4><i class="icon fa fa-info"></i> Galeria jest pusta!</h4>
			 <p>W celu wgrania nowego zdjęcia kliknij przycisk Dodaj</p>
		</div>
		
		</prop:EmptyTemplate>
	</com:TRepeater>
	  
	  </ul>
	  
	  
	  
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
			  
			jQuery( "#sortable" ).sortable();
			jQuery( "#sortable" ).disableSelection();
		  });

			jQuery("#sortable li").click( 
				function(event){ 
					jQuery("#prevModalSrc").attr('src', jQuery(this).children('img').attr('src'));
					jQuery("#PhotoID").children('input').val(jQuery(this).children('img').attr('id'));
					jQuery("#ctl0_content_ctl3_DescriptionSrc").val(jQuery(this).children('img').attr('desc'));
					jQuery("#ctl0_content_ctl3_UrlSrc").val(jQuery(this).children('img').attr('link'));
					
					if(jQuery(this).children('img').attr('master') == 1){
						jQuery("#ctl0_content_ctl3_MasterSrc").prop( "checked", true);
					}else{
						jQuery("#ctl0_content_ctl3_MasterSrc").prop( "checked", false);
					}
					
					
					jQuery(".example-modal").show(500);

				}
			);
			
			jQuery(".example-modal .close").click( 
				function(event){jQuery('.example-modal').hide();}
			);
			
	  
	  </script>
	  
	</div>
</div>