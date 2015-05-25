<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

<div id="wrapper">
	<?php 
		echo $this->element('ManagerMenu', array());
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="articles form">
				<?php echo $this->Form->create('Transaction'); ?>
				<fieldset>
					<legend><?php echo __('Add Transaction'); ?></legend>
					<?php
					echo $this->Form->input('walletLine', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'type' => "text",
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					

						?>
						
					</fieldset>
					<?php 
					$optionsFormLogin = array(
						'label' => 'Submit',
						'div' => false,
						'class' => 'btn btn-block btn-primary'
						);
						echo $this->Form->end($optionsFormLogin); ?>
					</div>
				</div>
			</div>
		</div>


		<script type="text/javascript">
		</script>