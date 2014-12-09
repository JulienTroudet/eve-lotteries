<p>
	<strong>Hello <?php echo $username; ?>
</p>

<p>
	To reinitialise your password please click on this link : 
</p>
<p>
	<?php echo $this->Html->link('Get a new Password', $this->Html->url($linkRecovery, true));?>
</p>

<p>
	If you didn't ask for a new password, please ignore this email.
</p>