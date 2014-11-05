<!-- displays all the elections -->
<hr>
<strong>Number Notifications: </strong> <?=$numberNotifications?>
<?php foreach($notifications as $notification): ?>
<ul>
	<br><li><strong>Notification Sender</strong>: <?php echo $notification['first_name'] . ' ' . $notification['last_name'] ?></li>
	<br><li><strong>Notification Type</strong>: <?php echo $notification['type'] ?></li>
	<br><li><strong>Election</strong>: <?php echo $notification['election_name'] ?></li>
</ul>
<?php endforeach ?>