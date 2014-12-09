<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="articles form">
				<?php echo $this->Form->create('Article'); ?>
				<fieldset>
					<legend><?php echo __('Edit Article'); ?></legend>
					<?php
					echo $this->Form->input('id');
					echo $this->Form->input('title');
					echo $this->Form->input('body');
					?>
				</fieldset>
				<?php echo $this->Form->end(__('Submit')); ?>
			</div>
			
		</div>
	</div>
</div>
