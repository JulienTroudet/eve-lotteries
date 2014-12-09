<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="lotteries form">
				<?php echo $this->Form->create('Lottery'); ?>
				<fieldset>
					<legend><?php echo __('Edit Lottery'); ?></legend>
					<?php
					echo $this->Form->input('id');
					echo $this->Form->input('eve_item_id');
					echo $this->Form->input('name');
					echo $this->Form->input('nb_tickets', array(
						'default' => $eveItem['EveItem']['nb_tickets_default'],
						'options' => array('8','16'),
						));
					echo $this->Form->input('lottery_status_id');
					?>
				</fieldset>
				<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
