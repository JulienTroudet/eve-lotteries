<div class="eveItems form">
<?php echo $this->Form->create('EveItem'); ?>
	<fieldset>
		<legend><?php echo __('Add Eve Item'); ?></legend>
	<?php
		echo $this->Form->input('eve_id', array('type' => 'string'));
		echo $this->Form->input('name');
		echo $this->Form->input('eve_category_id');
		echo $this->Form->input('eve_value');
		echo $this->Form->input('status');
		echo $this->Form->input('nb_tickets_default');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Eve Items'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Eve Categories'), array('controller' => 'eve_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Category'), array('controller' => 'eve_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Lotteries'), array('controller' => 'lotteries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lottery'), array('controller' => 'lotteries', 'action' => 'add')); ?> </li>
	</ul>
</div>
