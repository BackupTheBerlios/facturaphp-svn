<?php /* Smarty version 2.6.3, created on 2004-12-14 17:20:31
         compiled from menu_corp.tpl */ ?>
		<table width="90%" class="cajaMenu" cellpadding="3" cellspacing="0">
			<tr>
			  <td class="cabeceraMenu" colspan="2">.:Men&uacute; principal:.</td>
			 <!-- <td colspan="2"><img src="pics/menuPrincipal.gif"></td>-->
			</tr>
			
			<tr class="textoMenu">
			<td width="10px">&nbsp;</td>
			<td>
			<?php 
				$href ='- <a href="index.php?module=user_corps&method=select&id='.$_SESSION['ident_corp'].'" class="enlaceMenu">';

				print $href."Inicio";
				
			 ?>
			
			</a><br></td></tr>
			
			<?php 
				$module = new modules();
				$num = $module->get_list_public_modules();
				$i=0;
				while($i!=$num)
				{
				 ?>
				
					<tr class="textoMenu">
					<td width="10px">&nbsp;</td>
					<td>
				<?php 
				
					$href ='- <a href ="index.php?module='.$module->public_modules[$i][0].'" class="enlaceMenu">';
				
				
					print $href;
					 print $module->public_modules[$i][2]; ?>
					</a><br></td></tr>
				
				<?php 
					
					$i++;
					
				}
				 ?>
			
			
			<tr class="textoMenu">
			<td width="10px">&nbsp;</td>
			<td>
				- <a href="index.php?module=contact" class="enlaceMenu">Contactos
			</a><br></td></tr>
			
			
			<?php 
				
				if(isset($_SESSION['ident_corp']))
				{
					if($_SESSION['super'] == true)
					{
						$modules = new modules();
						$i=0;
						while($i!=$modules->num)
						{
					
							if(($modules->modules_list[$i]['public']==0)&&($modules->modules_list[$i]['name'] != "error")&&($modules->modules_list[$i]['name'] != "services")&&($modules->modules_list[$i]['name'] != "holydays")&&($modules->modules_list[$i]['name'] != "emps"))
							{
							 ?>
						
								<tr class="textoMenu">
								<td width="10px">&nbsp;</td>
								<td>
							<?php 
								$href ='- <a href ="index.php?module='.$modules->modules_list[$i]['name'].'" class="enlaceMenu">';
			
								print $href;
								print $modules->modules_list[$i]['name_web'];
								
							 ?>
								</a><br></td></tr>
							<?php 
							}
							
							$i++;
							
						}
					}
					else
					if($_SESSION['admin'] == true)
					{
						$modules = new modules();
						$i=0;
						while($i!=$modules->num)
						{
					
							if(($modules->modules_list[$i]['public']==0)&&($modules->modules_list[$i]['name'] != "error")&&($modules->modules_list[$i]['name'] != "services"))
							{
							 ?>
						
								<tr class="textoMenu">
								<td width="10px">&nbsp;</td>
								<td>
							<?php 
								$href ='- <a href ="index.php?module='.$modules->modules_list[$i]['name'].'" class="enlaceMenu">';
			
								print $href;
								print $modules->modules_list[$i]['name_web'];
								
							 ?>
								</a><br></td></tr>
							<?php 
							}
							
							$i++;
							
						}
					}
				}
			 ?>
			
			
					
			
		</table>
		<br>
		