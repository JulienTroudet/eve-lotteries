<div id="wrapper">
	<?php  echo $this->element('ModeratorMenu', array());?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="superLotteries form">
				<?php echo $this->Form->create('SuperLottery'); ?>
				<fieldset>
					<legend><?php echo __('Admin Add Super Lottery'); ?></legend>
					<div class="form-group required">
						<label for="SuperLotteryEveItemId">Eve Item</label>
						<select name="data[SuperLottery][eve_item_id]" class="form-control" id="SuperLotteryEveItemId" required="required">
						<option></option>
						<?php foreach ($eveItems as $key => $eveItem): ?>
							<option value="<?php echo $eveItem['EveItem']['id'] ?>" data-price="<?php echo $eveItem['EveItem']['eve_value'] ?>"><?php echo $eveItem['EveItem']['name'].' : '.number_format($eveItem['EveItem']['eve_value'], 0).' ISK' ?></option>
						<?php endforeach;?>
						</select>
					</div>
					<?php

					echo $this->Form->input('number_items', array(
						'default' => 1,
						'step' => '1',
						'max' => '100000000',
						'min' => '1',
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
					
					echo $this->Form->input('nb_tickets', array(
						'options' => array('25' => 25, '50' => 50, '75' => 75, '100' => 100, '150' => 150, '200' => 200, '250' => 250, '300' => 300, '400' => 400, '500' => 500, ),
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('ticket_value', array(
						'label' => 'Ticket value in points',
						'div' => array(
							'class' => 'form-group'
							),
						'readOnly' =>true,
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));

					echo $this->Form->input('lottery_value', array(
						'div' => array(
							'class' => 'form-group'
							),
						'disabled' =>true,
						'class' => 'form-control',
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
		<script> 
		$(document).ready(function(){
			$('#SuperLotteryEveItemId, #SuperLotteryNbTickets, #SuperLotteryNumberItems').on('input', function(){
				console.log('activation');

				var lotteryValue = $('#SuperLotteryEveItemId option:selected').data('price') * $('#SuperLotteryNumberItems').val();
				lotteryValue = lotteryValue*1.2;

				var itemNumber = $('#SuperLotteryNbTickets').val();

				$('#SuperLotteryTicketValue').val(Math.ceil((lotteryValue/1000000)/itemNumber));
				$('#SuperLotteryLotteryValue').val(number_format(lotteryValue, 0,'.',','));
			});
		})

		</script>