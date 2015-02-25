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
					echo $this->Form->input('amount', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'type' => "number",
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('user_id', array(
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'readonly' => true,
						'type' => 'text',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));

						?>
						<div class="form-group required">
							<label for="UserName">Search User</label>
							<input class="form-control" type="text" id="UserName" required="required">
						</div>
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
			$(function() {
				var availableusers = [
					<?php foreach ($listUsers as $key => $user) {
						echo '{value:"'.$key.'", label:"'.$user.'"},'."\n";
					}?>
				];
				$( "#UserName" ).autocomplete({
					source: availableusers
				});

				$( "#UserName" ).on( "autocompleteselect", function( event, ui ) {
					event.preventDefault();
					console.log(ui);

					$( "#UserName" ).val(ui.item.label+" : "+ui.item.value);
					$( "#TransactionUserId" ).val(ui.item.value);
				} );
			});
		</script>