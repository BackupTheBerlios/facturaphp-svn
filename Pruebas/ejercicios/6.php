<?php
calcular(1,2,1,'+');
calcular(1,2,1,'-');
function calcular($a,$b,$c,$signo)
{
	if ($signo=='+')
	{
		$resultado=(-$b+sqrt($b*$b - 4*$a*$c))/2*$a;
		echo "X1=";
	}
	if ($signo=='-')
	{
		$resultado=(-$b-sqrt($b*$b - 4*$a*$c))/2*$a;
		echo "X2= ";
	}
	echo $resultado;
};

?>