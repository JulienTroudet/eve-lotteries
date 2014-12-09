<div class="eveCategories form">
<?php echo $this->Form->create('EveCategory'); ?>
	<fieldset>
		<legend><?php echo __('Add Eve Category'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Eve Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Eve Items'), array('controller' => 'eve_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Item'), array('controller' => 'eve_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
