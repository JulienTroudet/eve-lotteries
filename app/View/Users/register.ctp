<div class="users form">
	<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Account Registration :'); ?></legend>
		<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password', array('type' => 'password'));
		echo $this->Form->input('password_confirm', array('type' => 'password'));
		echo $this->Form->input('mail');
		echo $this->Form->input('eve_id', array('type' => 'string'));
		?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit')); ?>
</div>
