<!-- displays all the elections -->
<strong>Candiate Approvals: </strong>

<?php foreach($candidateNotifications as $notification):?>
	<br><strong>User</strong>: <?=$notification['first_name'] . ' ' . $notification['last_name']?>
	<br><strong>Type:</strong> <?=$notification['type']?>
	<br><a href="<?=site_url('notifications/AcceptCandidateNotification/' . $notification['id'])?>">Accept</a> | 
		<a href="<?=site_url('notifications/RejectRequest/' . $notification['id'])?>">Reject</a>
<?php endforeach?>
<hr>
<strong>Election Approvals </strong>
<?php foreach($electionNotifications as $notification):?>
	<br><strong>User</strong>: <?=$notification['first_name'] . ' ' . $notification['last_name']?>
	<br><strong>Type:</strong> <?=$notification['election_name']?>
	<br><a href="<?=site_url('notifications/AcceptElectionNotification/' . $notification['id'])?>">Accept</a> | 
		<a href="<?=site_url('notifications/RejectRequest/' . $notification['id'])?>">Reject</a>
<?php endforeach?>