<strong><?=$election['election_name']?></strong>
<strong><br><?=$election['election_description']?></strong>
<br>Who would you like to vote for?
<strong><br>Candidates: </strong>
<form name="vote" action="<?=base_url($election['slug'])?>" method="post">
	<?php foreach($candidates as $candidate): ?>
		<br><?=$candidate['first_name']?> <?=$candidate['last_name']?>
		<input type="radio" name="candidates[]" value="<?=$candidate['candidate_id'];?>">
	<?php endforeach ?>
	<br><input type="submit" value="Submit Vote">
</form>