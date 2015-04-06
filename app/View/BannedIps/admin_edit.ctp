<div class="bannedIps form">
<?php echo $this->Form->create('BannedIp'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Banned Ip'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('ip');
		echo $this->Form->input('nb_connection');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('BannedIp.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('BannedIp.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Banned Ips'), array('action' => 'index')); ?></li>
	</ul>
</div>
