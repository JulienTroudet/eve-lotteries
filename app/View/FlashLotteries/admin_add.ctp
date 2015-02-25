<?php echo $this->Html->css('bootstrap-datetimepicker.min'); ?>
<?php echo $this->Html->script('moment');?>
<?php echo $this->Html->script('bootstrap-datetimepicker.min');?>
<div id="wrapper">
	<?php  echo $this->element('ManagerMenu', array());?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="flashLotteries form">
				<?php echo $this->Form->create('FlashLottery'); ?>
				<fieldset>
					<legend><?php echo __('Admin Add Super Lottery'); ?></legend>
					<div class="form-group required">
						<label for="FlashLotteryEveItemId">Eve Item</label>
						<select name="data[FlashLottery][eve_item_id]" class="form-control" id="FlashLotteryEveItemId" required="required">
							<option></option>
							<?php foreach ($eveItems as $key => $eveItem): ?>
							<option value="<?php echo $eveItem['EveItem']['id'] ?>" data-price="<?php echo $eveItem['EveItem']['eve_value'] ?>"><?php echo $eveItem['EveItem']['name'].' : '.number_format($eveItem['EveItem']['eve_value'], 0).' ISK' ?></option>
							<?php endforeach;?>
						</select>
					</div>
					<?php
					echo $this->Form->input('number_items', array(
						'label' => 'Number of items',
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
					echo $this->Form->input('nb_tickets', array(
						'label' => 'Number of tickets',
						'options' => array('20' => 20, '30' => 30, '60' => 60, '120' => 120 ),
						'div' => array(
							'class' => 'form-group'
							),
						'class' => 'form-control',
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					echo $this->Form->input('start_date', array(
						'type'=>"hidden",
						'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
						));
					?>
					<label for="start_date_formated">Start Date</label>
					<div class="input-group date required" id="start_date_formated_div">
						<input class="form-control" type="text" id="start_date_formated" required="required">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
					</div>
					<?php
					echo $this->Form->input('expiration_date', array(
					'type'=>"hidden",
					'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
					));
					?>
					<div class="form-group">
						<label for="duration">Duration</label>
						<select class="form-control" id="duration">
							<option value="10">10 minutes</option>
							<option value="30">30 minutes</option>
							<option value="60">1 hour</option>
							<option value="120">2 hours</option>
						</select>
					</div>
					<?php
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
	function uptateHiddenDates(){
		mStartDate = $('#start_date_formated_div').data("DateTimePicker").date();
		mEndDate = $('#start_date_formated_div').data("DateTimePicker").date();
		nbMinutes = $('#duration').val();
		mEndDate = mEndDate.add(nbMinutes, 'minutes');
		$('#FlashLotteryStartDate').val(mStartDate.format());
		$('#FlashLotteryExpirationDate').val(mEndDate.format());
	}
	$(document).ready(function(){
		$('#start_date_formated_div').datetimepicker({
			format:'DD/MM/YYYY HH:mm',
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down",
				previous: 'fa fa-arrow-left',
				next: 'fa fa-arrow-right',
			},
			sideBySide:true,
			widgetPositioning:{
				horizontal: 'left',
				vertical: 'auto'
			},
			minDate:moment(),
			defaultDate:moment(),
		});
		$("#start_date_formated_div").on("dp.change",function (e) {
			uptateHiddenDates();
		});
		$("#duration").on("change",function (e) {
			uptateHiddenDates();
		});
		$('#FlashLotteryEveItemId, #FlashLotteryNumberItems').on('input change', function(){
			var lotteryValue = $('#FlashLotteryEveItemId option:selected').data('price') * $('#FlashLotteryNumberItems').val();
			$('#FlashLotteryLotteryValue').val(number_format(lotteryValue, 0,'.',','));
		});
		uptateHiddenDates();
	})
</script>