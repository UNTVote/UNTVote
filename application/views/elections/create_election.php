<!-- HTML File to create an election -->

<!-- print the vaidation errors, if any -->
<?=validation_errors(); ?>

<?=form_open('elections/create'); ?>
	<label for="electionName">Election Name: </label>
	<input type="input" name="electionName"><br>

	<label for="electionDescription">Election Description: </label>
	<input type="text" name="electionDescription" style="width: 300; height: 100;"><br>

	<label for="electionStart">Start Date: </label>
	<input type="date" name="electionStart" value="<?=date('Y-m-d')?>"><br>

	<label for="electionEnd">End Date: </label>
	<input type="date" name="electionEnd" min="<?= date('Y-m-d');?>"><br>

	<label for="electionCollege">College: </label>
	<select name="electionCollege">
		<!-- every college that we have -->
		<?php foreach($colleges as $college):?>
			<option value="<?=$college['id'];?>">
				<?= htmlspecialchars($college['description'], ENT_QUOTES, 'UTF-8');?>
			</option>
		<?php endforeach?>
	</select>

	<label for="electionCandidates">Candidates: </label>
	<select multiple name="electionCandidates[]">
		<!-- every college that we have -->
		<?php foreach($candidates as $candidate):?>
			<option value="<?=$candidate['id']?>">
				<?= htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name'], ENT_QUOTES, 'UTF-8');?>
			</option>
		<?php endforeach?>
	</select>

	<input type="submit" name="submit" value="Create Election">
</form>