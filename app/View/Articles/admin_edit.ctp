<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('ModeratorMenu', array());
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
					echo $this->Form->input('title', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('body', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					?>
				</fieldset>
				<?php 
				$optionsFormLogin = array(
						'label' => 'Edit',
						'div' => false,
						'class' => 'btn btn-block btn-primary'
						);
						echo $this->Form->end($optionsFormLogin); ?>
			</div>
			
		</div>
	</div>
</div>
