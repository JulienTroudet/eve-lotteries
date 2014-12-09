<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="users form">
				<?php echo $this->Form->create('User'); ?>
				<fieldset>
					<legend><?php echo __('Edit User'); ?></legend>
					<?php
					echo $this->Form->input('id');
					echo $this->Form->input('username');
					echo $this->Form->password('pwd');
					echo $this->Form->input('mail');
					echo $this->Form->input('group_id');
					echo $this->Form->input('wallet');
					echo $this->Form->input('eve_id', array('type' => 'string'));
					?>
				</fieldset>
				<?php echo $this->Form->end(__('Submit')); ?>
			</div>
			<div class="actions">
				<h3><?php echo __('Actions'); ?></h3>
				<ul>

					<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>