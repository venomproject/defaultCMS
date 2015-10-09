	<div class="col-md-8 col-xs-12 ">
		<div class="row">
			
				<com:TRepeater ID="FooterMenu" AllowPaging="false"
					OnItemDataBound="dataBindMasterCategory">
					<prop:ItemTemplate>
					<div class="col-md-3 col-xs-6">
						<h4><%= $this->Data->MenuName == NULL ? $this->Data->Name : $this->Data->MenuName %></h4>
						<ul>
							<com:TRepeater ID="ChildrenList" AllowPaging="false">
								<prop:ItemTemplate>
									<li><a href="<%= $this->Service->constructUrl('Pages', array('id' => $this->Data->ID)) %>"> <%=
											$this->Data->MenuName == NULL ? $this->Data->Name :
											$this->Data->MenuName %> </a></li>
								</prop:ItemTemplate>
							</com:TRepeater>
						</ul>
					</div>
					</prop:ItemTemplate>
				</com:TRepeater>

		</div>
	</div>
