<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
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
		</div>
	</div>
</div>