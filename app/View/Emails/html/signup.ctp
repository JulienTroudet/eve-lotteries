<p>
	<strong>Hello <?php echo $user['eve_name']; ?>
</p>
<p>
	Welcome to EVE-Lotteries ! 
	To activate your account please click on this link : 
</p>
<p>
	<?php echo $this->Html->link('Activate my account', $this->Html->url($linkActivation, true));?>
</p>
<p>
	See you soon at EVE-Lotteries.com !
</p>