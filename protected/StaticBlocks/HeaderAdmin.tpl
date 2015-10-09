<header class="main-header">
        <a href="<%=$this->Service->constructUrl("Home") %>" class="logo">
          <span class="logo-lg"><b>Venom</b>CMS</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
			  <com:TRepeater ID="LanguageList" EnableViewState="false">
				<prop:ItemTemplate>
				<li><a href="#">
					<com:TImageButton
				    ImageUrl="<%= 'UserFiles/Language/'.$this->Data->cat_id %>/<%= $this->Data->Photo %>"
				    onCommand="SourceTemplateControl.changeLanguage"
				    CommandParameter="<%# $this->Data->cat_id %>" />
				</a></li>
				</prop:ItemTemplate>
				</com:TRepeater>  
			  <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i></a>
                 <ul class="dropdown-menu">
                  <li class="header">Ustawienia konta</li>
                  <li><a href="<%=$this->Service->constructUrl("ChangePassword", array('hash' => '63fde930ce28b3a87f68e7c470c0b0babfcb14f5')) %>">Zmiana hasła</a></li>
                  <li>
                    <ul class="menu">
                      <li>
						<a href="#">
							<com:TButton OnClick="logout" Visible="<%= !$this->User->IsGuest %>" Text="Wyloguj" CssClass="btn btn-block btn-danger "/>
						</a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>