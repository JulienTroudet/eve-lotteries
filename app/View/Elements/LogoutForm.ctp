<div class="navbar-form navbar-right">

	<?php echo $this->Html->link(
		'Account', 
		array('controller' => 'users', 'action' => 'account', 'admin'=>false, 'plugin' => false),
		array('class' => 'btn btn-primary')
		); ?>

	<?php echo $this->Html->link(
		'Logout', 
		array('controller' => 'users', 'action' => 'logout', 'admin'=>false, 'plugin' => false),
		array('class' => 'btn btn-danger')
		);?>	


</div>