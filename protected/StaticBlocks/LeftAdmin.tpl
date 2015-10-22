      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
		  <li class="header">NAWIGACJA</li>
		  
		  
		  
		  
		  <li class="treeview"><a href="<%=$this->Service->constructUrl("Home")%>"><i class="fa fa-dashboard"></i><span>Home</span></a></li>
          <li class="treeview active <%= in_array($this->getPage()->getPagePath() , array("Pages.Index","Pages.Data","Pages.Add"))  ? 'active' : ''%>">
              <a href="<%=$this->Service->constructUrl("Pages.Data") %>">
                <i class="fa fa-edit"></i> <span>Treść</span>
              </a>
               <ul class="treeview-menu">
				<com:TRepeater ID="PagesParent" AllowPaging="false" OnItemDataBound="dataBindMasterCategory">
				<prop:ItemTemplate>
				
				<li class="<%= in_array($this->Data->ID, $this->SourceTemplateControl->activeLi) ? 'act' : '' %>"
				><a href="<%=$this->Service->constructUrl("Pages.Index", array('id' => $this->Data->ID)) %>"><i class="fa fa-circle-o"></i><%= $this->Data->Name %></a>
				
				
				
				
					<com:TRepeater ID="ChildrenList" AllowPaging="false" >
									<prop:HeaderTemplate>
									<ul style="display: none;">
									</prop:HeaderTemplate>
										<prop:ItemTemplate>
											<li>
												<a href="<%= $this->Service->constructUrl('Pages.Index', array('id' => $this->Data->ID)) %>">
													<%= $this->Data->MenuName == NULL ? $this->Data->Name : $this->Data->MenuName %> 
												</a>
											</li>
										</prop:ItemTemplate>
									<prop:FooterTemplate>
									</ul>
									</prop:FooterTemplate>
									</com:TRepeater>
				
				
				
				</li>
				</prop:ItemTemplate>
				</com:TRepeater>              
				</ul>
          </li> 
			
		
		<li class="header">Moduły</li>
		

<li class="treeview"><a href="<%=$this->Service->constructUrl("Settings.Index")%>"><i class="fa fa-gears"></i><span>Ustawienia</span></a></li>


<li class="treeview"><a href="<%=$this->Service->constructUrl("Newsletter.Data")%>"><i class="fa fa-comments-o"></i><span>Newsletter</span></a></li>

<li class="treeview"><a href="<%=$this->Service->constructUrl("Slider.Data")%>"><i class="fa fa-picture-o"></i> <span>Slider</span></a></li>

<li class="treeview"><a href="<%=$this->Service->constructUrl("Bg.Index")%>"><i class="fa fa-picture-o"></i> <span>Tło</span></a></li>

<!-- 
		    <li class="treeview"><a href="<%=$this->Service->constructUrl("Language.Index", array('id' => $this->ActLang))%>"><i class="fa fa-flag-checkered"></i><span>Języki</span></a></li>
		  <li class="treeview"><a href="<%=$this->Service->constructUrl("Translation.Index", array('id' => $this->ActLang))%>"><i class="fa fa-flag-checkered"></i><span>Tłumaczenia</span></a></li>
		  
		  <li class="treeview"><a href="<%=$this->Service->constructUrl("Contact.Index")%>"><i class="fa fa-info"></i> <span>Kontakt</span></a></li>
		   <li class="treeview"><a href="<%=$this->Service->constructUrl("Order")%>"><i class="fa fa-shopping-cart"></i> <span>Zamówienia</span></a></li>
		  <li class="treeview"><a href="<%=$this->Service->constructUrl("Banner.Index")%>"><i class="fa fa-photo"></i> <span>Slider</span></a></li>
		  <li class="treeview"><a href="<%=$this->Service->constructUrl("Reklama.Wspolpraca")%>"><i class="fa fa-photo"></i> <span>Wspołpraca</span></a></li>
		  <li class="treeview"><a href="<%=$this->Service->constructUrl("Reklama.Patronat")%>"><i class="fa fa-photo"></i> <span>Patronat</span></a></li>
		  <li class="treeview"><a href="#"><i class="fa fa-comments-o"></i> <span>Social Media</span></a></li>
		  <li class="treeview"><a href="#"><i class="fa fa-picture-o"></i> <span>Slider</span></a></li>
		  <li class="treeview"><a href="#"><i class="fa fa-plug"></i> <span>Wtyczki</span></a></li>
          <li class="header">LABELS</li>
          <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
          <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
          <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
          -->
            
          </ul>
        </section>
      </aside>