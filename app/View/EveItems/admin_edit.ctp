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
				<img src="https://image.eveonline.com/Render/<?php echo $eveItem['EveItem']['eve_id']?>_64.png">
				<fieldset>
					<legend><?php echo __('Edit Eve Item'); ?></legend>
					<?php
					echo $this->Form->input('id');
					echo $this->Form->input('eve_id', array(
						'type' => 'string',
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('name', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('eve_category_id', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('eve_value', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('status', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('nb_tickets_default', array(
						'options' => array('8' => 8, '16' => 16),
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