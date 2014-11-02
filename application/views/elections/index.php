<!-- displays all the elections -->
<hr>
<strong>Active Elections: </strong>
<?php foreach($activeElections as $activeElection): ?>
<ul>
	<br><li><strong>Election Name</strong>: <?php echo $activeElection['election_name'] ?></li>
	<br><li><strong>Election Description</strong>: <?php echo $activeElection['election_description'] ?></li>
	<br><li><strong>Number of Votes: </strong> <?php echo $activeElection['total_votes'] ?></li>
	<br><li><a href = "<?=site_url('elections/' . $activeElection['slug'])?>">View Election</a></p><br></li>
</ul>
<?php endforeach ?>
