<div class="lotteries form">
	<?php echo $this->Form->create('Lottery'); ?>
	<div>
		<h1><?php echo $eveItem['EveItem']['name']?></h1>
		<img src="https://image.eveonline.com/Render/<?php echo $eveItem['EveItem']['eve_id']?>_128.png">
		<h2><?php echo $eveItem['EveCategory']['name']?></h2>
		<h2>Eve Value : <?php echo $eveItem['EveItem']['eve_value']?></h2>
	</div>
	<fieldset>
		<legend><?php echo __('Add Lottery'); ?></legend>
		<?php
		echo $this->Form->input('name');
		echo $this->Form->input('nb_tickets', array('default' => $eveItem['EveItem']['nb_tickets_default']));
		echo $this->Form->input('lottery_value', array( 'type' => 'number', 'step' => '0.01',  'div' => 'required', 'default' => $eveItem['EveItem']['eve_value']) );
		echo $this->Form->input('lottery_status_id');
		?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Lotteries'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Eve Items'), array('controller' => 'eve_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Item'), array('controller' => 'eve_items', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
