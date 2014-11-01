<!-- displays all the elections -->
<strong>Election Archive:</strong>
<ul>
<?php foreach($elections as $election): ?>
	<br><li><strong>Election Name</strong>: <?php echo $election['election_name'] ?> </li>
	<br><li><strong>Election Description</strong>: <?php echo $election['election_description'] ?></li>
	<br><li><strong>Number of Votes: </strong> <?php echo $election['total_votes'] ?></li>
	<br><li><strong>Status: </strong> <?php echo $election['status'] ?></li>
</ul>
<a href = "<?php echo $election['slug'] ?> ">View Election</a><br>
<?php endforeach ?>
<hr>
<strong>Active Elections: </strong>
<ul>
<?php foreach($activeElections as $activeElection): ?>
	<br><li><strong>Election Name</strong>: <?php echo $activeElection['election_name'] ?></li>
	<br><li><strong>Election Description</strong>: <?php echo $activeElection['election_description'] ?></li>
	<br><li><strong>Number of Votes: </strong> <?php echo $activeElection['total_votes'] ?></li>
</ul>
<a href = "<?php echo $activeElection['slug'] ?> ">View Election</a></p><br>
<?php endforeach ?>
