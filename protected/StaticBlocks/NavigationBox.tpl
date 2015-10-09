<nav class="navbar">
	
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#navbar"
				aria-expanded="false" aria-controls="navbar">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand visible-xs" href="#">Nawigacja</a>
		</div>
		
		
		<div id="navbar" class="navbar-collapse collapse">
			
		<div class="container">
			<ul class="nav navbar-nav">
			
	<li> <a href="<%= $this->Service->constructUrl('Home') %>" >
      Home
    </a>
    		
<com:TRepeater ID="LeftMenu" AllowPaging="false" OnItemDataBound="dataBindMasterCategory">
	<prop:ItemTemplate>
	<li> <a href="<%= $this->Service->constructUrl('Pages', array('id' => $this->Data->ID)) %>" >
      <%= $this->Data->MenuName == NULL ? $this->Data->Name : $this->Data->MenuName %>
    </a>
	
					<com:TRepeater ID="ChildrenList" AllowPaging="false" OnItemDataBound="SourceTemplateControl.dataBindUnderCategory">
					<prop:HeaderTemplate>
<ul class="dropdown-menu">
									</prop:HeaderTemplate>
						<prop:ItemTemplate>
							<li>
								<a href="<%= $this->Service->constructUrl('Pages', array('id' => $this->Data->ID)) %>"> 
									<%= $this->Data->MenuName == NULL ? $this->Data->Name : $this->Data->MenuName %> 
								</a>
									
									<com:TRepeater ID="PhotoList" AllowPaging="false" >
									<prop:HeaderTemplate>
									<ul>
									</prop:HeaderTemplate>
										<prop:ItemTemplate>
											<li>
												<a href="<%= $this->Service->constructUrl('Pages', array('id' => $this->Data->ID)) %>">
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
						<prop:FooterTemplate>
									</ul>
									</prop:FooterTemplate>
					</com:TRepeater>
				
							
						</li>

	</prop:ItemTemplate>
</com:TRepeater>
			</ul>
		</div>
		</div>
</nav>