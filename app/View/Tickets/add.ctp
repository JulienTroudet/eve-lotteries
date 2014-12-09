<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
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
		</div>
	</div>
</div>
