<meta charset="UTF-8"/>
<?php

    $filename = "nqr-individual.xls";

    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
   	header("Content-Disposition: attachment; filename=".$filename);

    foreach($dataSolicitudes as $row)
{
	echo $row['resultadoRPT'];
}
?> 
