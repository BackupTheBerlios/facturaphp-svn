		<table width="90%" class="cajaMenu" cellpadding="3" cellspacing="0">
			<tr>
			  <td class="cabeceraMenu" colspan="2">.:Men&uacute; principal:.</td>
			 <!-- <td colspan="2"><img src="pics/menuPrincipal.gif"></td>-->
			</tr>
			
			<tr class="textoMenu">
			<td width="10px">&nbsp;</td>
			<td>
			{php}
				$href ='- <a href="index.php?module=user_corps&method=select&id='.$_SESSION['ident_corp'].'" class="enlaceMenu">';

				print $href."Inicio";
				
			{/php}
			
			</a><br></td></tr>
			
			{php}
				$module = new modules();
				$num = $module->get_list_public_modules();
				$i=0;
				while($i!=$num)
				{
				{/php}
				
					<tr class="textoMenu">
					<td width="10px">&nbsp;</td>
					<td>
				{php}
				
					$href ='- <a href ="index.php?module='.$module->public_modules[$i][0].'" class="enlaceMenu">';
				
				
					print $href;
					 print $module->public_modules[$i][2];{/php}
					</a><br></td></tr>
				
				{php}
					
					$i++;
					
				}
				{/php}
			
			
			<tr class="textoMenu">
			<td width="10px">&nbsp;</td>
			<td>
				- <a href="index.php?module=contact" class="enlaceMenu">Contactos
			</a><br></td></tr>
			
			
			{php}
				
				
					if($_SESSION['super'] == true)
					{
						$modules = new modules();
						$i=0;
						while($i!=$modules->num)
						{
					
							if(($modules->modules_list[$i]['public']==0)&&($modules->modules_list[$i]['parent'] == 0)&&($modules->modules_list[$i]['name'] != "error")&&($modules->modules_list[$i]['name'] != "services")&&($modules->modules_list[$i]['name'] != "holydays")&&($modules->modules_list[$i]['name'] != "emps"))
							{
								
							{/php}
						
								<tr class="textoMenu">
								<td width="10px">&nbsp;</td>
								<td>
							{php}
								$href ='- <a href ="index.php?module='.$modules->modules_list[$i]['name'].'" class="enlaceMenu">';
			
								print $href;
								print $modules->modules_list[$i]['name_web'];
								
							{/php}
								</a><br></td></tr>
							{php}
								$j=0;
								while($j!=$modules->num)
								{
									if(($modules->modules_list[$j]['public']==0)&&($modules->modules_list[$j]['parent'] == $modules->modules_list[$i]['id_module']))
									{
										{/php}
										<tr class="textoMenu">
										<td width="10px">&nbsp;</td>
										<td>
										&nbsp;&nbsp;&nbsp;
										{php}
											$href = '- <a href ="index.php?module='.$modules->modules_list[$j]['name'].'" class="enlaceMenu">';
											print $href;
											print $modules->modules_list[$j]['name_web'];		
										{/php}
										</a><br></td></tr>
										{php}
									}//if
									$j++;
								}//while
							}//if
							$i++;
						}//while
					}
					else
					if($_SESSION['admin'] == true)
					{
						$modules = new modules();
						$i=0;
						while($i!=$modules->num)
						{
					
							if(($modules->modules_list[$i]['public']==0)&&($modules->modules_list[$i]['parent'] == 0)&&($modules->modules_list[$i]['name'] != "error")&&($modules->modules_list[$i]['name'] != "services")&&($modules->modules_list[$i]['name'] != "holydays")&&($modules->modules_list[$i]['name'] != "emps")&&($modules->modules_list[$i]['name'] != "modules"))
							{
								
							{/php}
						
								<tr class="textoMenu">
								<td width="10px">&nbsp;</td>
								<td>
							{php}
								$href ='- <a href ="index.php?module='.$modules->modules_list[$i]['name'].'" class="enlaceMenu">';
			
								print $href;
								print $modules->modules_list[$i]['name_web'];
								
							{/php}
								</a><br></td></tr>
							{php}
								
							}
							
							$i++;
							
						}
					}
				
				else //usuario no admin ni super
				{
					$user= new users(); 
					$id_user = $user->get_id($_SESSION['user']);
					$user->validate_per_user($id_user);
					
					$i=0;
					while($i!=$user->num_modules)
					{
				
						if(($user->per_modules[$i]->per == 1)&&($user->per_modules[$i]->parent == 0)&&($user->per_modules[$i]->publico==0)&&($user->per_modules[$i]->module_name!='error')&&($user->per_modules[$i]->module_name!='holydays'))
						{
						{/php}
					
							<tr class="textoMenu">
							<td width="10px">&nbsp;</td>
							<td>
						{php}
							$href ='- <a href ="index.php?module='.$user->per_modules[$i]->module_name.'" class="enlaceMenu">';
		
							print $href;
						 	print $user->per_modules[$i]->web_name;
						 	
						{/php}
							</a><br></td></tr>
						{php}
						}
						
						$i++;
						
					}
				}
				
			{/php}
			
			
					
			
		</table>
		<br>
		
		
		