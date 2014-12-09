<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="articles form">
				<?php echo $this->Form->create('Award'); ?>
				<fieldset>
					<legend><?php echo __('Edit Award'); ?></legend>
					<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('description', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('group', array(
						'options' => array(
							'ticket' => 'ticket', 
							'items' => 'item',
							'win' => 'win',
							'special' => 'special',
							'deposit' => 'deposit',
							'presence' => 'presence',
							),
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('order', array(
						'step' => '1',
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('request', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('award_credits', array(
						'step' => '1000000',
						'max' => '100000000',
						'min' => '1000000',
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('status', array(
						'options' => array('Active' => 'active', 'Inactive' => 'inactive'),
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