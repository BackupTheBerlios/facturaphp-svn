{php}

		/*
		EL DISEÑO DE ESTA FUNCION OBLIGA A QUE LA VARIABLE DE JAVASCRIPT QUE VAYA A ALBERGAR SU CONTENIDO
		DEBA TENER LA CADENA DE CARACTERES ENTRE COMILLAS DOBLES
		*/
		function tabla_paginacion($var,$curr_page,$num_pages){
				$num = 1;
				$pagina='<br><table align=\\"center\\"><tr><td class=\\"cabeceraCampoFormulario\\" colspan=\\"3\\">Ir a la página:</td></tr><tr class=\\"NumerosBuscar\\">';
				if($num==$num_pages)//SI SOLO HAY UN REGISTRO
					$pagina = $pagina.'<td>&nbsp</td><td><b>1</b></td><td>&nbsp</td>';					
				else{
						if ($curr_page==1)//SI ES EL PRIMERO
							$pagina=$pagina.'<td>&nbsp</td><td>';							
						else
							$pagina=$pagina.'<td><a href=\\"#\\" onClick=\\"Ocultar(\'\',\''.$var.'_'. ($curr_page - 1) .'\')\\">Anterior</a></td><td>';							
						while ($num <= $num_pages){//VAMOS RECORRIENDO LAS PAGINAS
							if($num==$curr_page)
								$pagina=$pagina.'<b>'.$num.'</b>&nbsp;';
							else
								$pagina=$pagina.'<a href=\\"#\\" onClick=\\"Ocultar(\'\',\''.$var.'_'.$num.'\')\\">'.$num.'</a>&nbsp;';
							$num++;
						}									
						if($curr_page==$num_pages)//SI ES EL ULTIMO
							$pagina=$pagina.'</td><td>&nbsp</td>';							
						else
							$pagina=$pagina.'</td><td><a href=\\"#\\" onClick=\\"Ocultar(\'\','.$var.'_'. ($curr_page + 1) .')\\">Siguiente</a></td>';
				}
				$pagina=$pagina.'</tr></table>';
				return $pagina;
			}
{/php}