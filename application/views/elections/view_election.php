<?php
echo '<h2>' . $election['election_name'] . '</h2>';
echo '<h5>' . $election['election_description'] . '</h5>';
echo '<h3> Candidates:</h3>';
foreach($candidates as $candidate)
{
	echo 'First Name: ' . $candidate['first_name'];
	echo '<br>Last Name: ' . $candidate['last_name'];
	echo '<p>';
}