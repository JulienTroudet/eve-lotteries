<p>
	<strong>Hello <?php echo $username; ?>
</p>

<p>
	To activate your account please click on this link : 
</p>
<p>
	<?php echo $this->Html->link('Activate my account', $this->Html->url($linkActivation, true));?>
</p>