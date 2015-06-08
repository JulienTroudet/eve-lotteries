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
		</div>
	</div>
</div>
