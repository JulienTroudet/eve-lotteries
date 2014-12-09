<div class="navbar-form navbar-right">

	<?php echo $this->Html->link(
		'Logout', 
		array('controller' => 'users', 'action' => 'logout'),
		array('class' => 'btn btn-danger'),
		"Are you sure you wish to log out?"
		); ?>

		

	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->Html->link(
			'Admin Panel', 
			array('controller' => 'lotteries', 'action' => 'adminIndex'),
			array('class' => 'btn btn-primary')
			);
	}
	?>
</div>