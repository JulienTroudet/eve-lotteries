<div id="wrapper">
	<?php  echo $this->element('AdminMenu', array());?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="superLotteries form">
				<?php echo $this->Form->create('SuperLottery'); ?>
				<fieldset>
					<legend><?php echo __('Admin Edit Super Lottery'); ?></legend>
					<?php
					echo $this->Form->input('id');
					echo $this->Form->input('eve_item_id');
					echo $this->Form->input('number_items');
					echo $this->Form->input('name');
					echo $this->Form->input('creator_user_id');
					echo $this->Form->input('nb_tickets');
					echo $this->Form->input('ticket_value');
					echo $this->Form->input('lottery_status_id');
					?>
				</fieldset>
				<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>