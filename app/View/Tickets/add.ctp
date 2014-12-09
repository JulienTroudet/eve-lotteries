<div class="tickets form">
<?php echo $this->Form->create('Ticket'); ?>

	<div>
		<p>With the current Lottery</p>
		<p>Each ticket will cost : <?php echo(number_format ($ticket_value)); ?></p>
		<p>The Item value on Eve is : <?php echo(number_format ($lottery['EveItem']['eve_value'])); ?></p>
		<p>The lottery total value is : <?php echo(number_format ($ticket_value*$lottery['Lottery']['nb_tickets'])); ?></p>
		<p>The net gain will be : <?php echo(number_format (($ticket_value*$lottery['Lottery']['nb_tickets'])-($lottery['EveItem']['eve_value']))); ?></p>
	</div>
	<fieldset>
		<legend><?php echo __('Confirm Ticket Price'); ?></legend>
	<?php
	echo $this->Form->input('value', array( 'type' => 'number', 'step' => '0.01',  'default' => $ticket_value) );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Confirm')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tickets'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Lotteries'), array('controller' => 'lotteries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lottery'), array('controller' => 'lotteries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
