<div class="lotteries form">
<?php echo $this->Form->create('Lottery'); ?>
	<fieldset>
		<legend><?php echo __('Edit Lottery'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('eve_item_id');
		echo $this->Form->input('name');
		echo $this->Form->input('creator_user_id');
		echo $this->Form->input('nb_tickets');
		echo $this->Form->input('lottery_status_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Lottery.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Lottery.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Lotteries'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Eve Items'), array('controller' => 'eve_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Item'), array('controller' => 'eve_items', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Lottery Statuses'), array('controller' => 'lottery_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lottery Status'), array('controller' => 'lottery_statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
	</ul>
</div>
