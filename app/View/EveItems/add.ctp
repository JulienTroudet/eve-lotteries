<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
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
					echo $this->Form->input('nb_tickets_default', array(
						'options' => array(8,16),
						));
						?>
					</fieldset>
					<?php echo $this->Form->end(__('Submit')); ?>
				</div>
			</div>
		</div>
	</div>
