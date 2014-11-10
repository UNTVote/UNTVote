<h3><?=$candidate->first_name?> <?=$candidate->last_name?></h3>
<h3>Colleges: </h3>
<?php foreach($colleges as $college)
{
	echo htmlspecialchars($college->description, ENT_QUOTES, 'UTF-8'); 
	echo '<br>';
}
?>
