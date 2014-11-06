<!-- displays all the elections -->
<?php
$candidateLink = (!$this->ion_auth->in_group('candidates')) ? '<a href="' . site_url('notifications/SendCandidateNotification/') . '">Request to be a Candidate</a>' : ' ';
?>
<?=$candidateLink?>
<hr>
<strong>Active Elections: </strong>
<?php foreach($activeElections as $activeElection): ?>
<ul>
	<br><li><strong>Election Name</strong>: <?php echo $activeElection['election_name'] ?></li>
	<br><li><strong>Election Description</strong>: <?php echo $activeElection['election_description'] ?></li>
	<br><li><strong>Number of Votes: </strong> <?php echo $activeElection['total_votes'] ?></li>
	<?php if($this->election_model->IsUserRegistered($activeElection['id']))
	{
		$linkText = '<a href="' . site_url('elections/' . $activeElection['slug']) . '">View Election</a>';
	}
	else if($this->notification_model->IsElectionNotificationSent($activeElection['id']))
	{
		$linkText = '<a href="#" disabled>Request Sent</a>';
	}
	else
	{
		$linkText = '<a href="' . site_url('notifications/SendElectionNotification/' . $activeElection['id']) . '">Request Vote</a>';
	}
	?>
	<br><?=$linkText?>
</ul>
<?php endforeach ?>
