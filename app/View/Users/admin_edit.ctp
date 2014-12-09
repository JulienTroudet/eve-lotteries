<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="users form">
				<?php echo $this->Form->create('User'); ?>
				<fieldset>
					<legend><?php echo __('Edit User'); ?></legend>
					<?php
					echo $this->Form->input('id');
					
					echo $this->Form->input('group_id', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('tokens', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('wallet', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('eve_name', array(
						'type' => 'string',
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'disabled' => true,
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('id', array(
						'type' => 'string',
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'disabled' => true,
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
			<div class="actions">
				<h3><?php echo __('Actions'); ?></h3>
				<ul>

					<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', 'admin' => true, $this->Form->value('User.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>