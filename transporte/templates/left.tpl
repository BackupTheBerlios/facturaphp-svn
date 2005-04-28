


<tr>
	  <td width="150px" valign="top">
		{include file=users.tpl}
		
		{php}
			if(!isset($_SESSION['user']))
			{//Usuario sin logear
				{/php}
					{include file=menu.tpl}
				{php}
			}
			else
			{
				{/php}
					{include file=menu_user.tpl}
				{php}
			}
		{/php}
				
		{include file=sessions.tpl}
	  </td>
	  
	  