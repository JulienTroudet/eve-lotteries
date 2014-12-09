<div class="row super-lot">
	<div class="col-md-10 col-sm-12 col-md-offset-1 well well-sm">
		<div class="row">
			<div class="col-md-1">
				<!-- <?php print_r($superLottery); ?>-->				
				<img src="https://image.eveonline.com/Render/<?php echo $superLottery['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $superLottery['EveItem']['name']; ?>">
			</div>
			<div class="col-md-3">
				<h3><?php echo $superLottery['SuperLottery']['name']; ?></h3>
				<p>Prize : <strong><?php echo $superLottery['EveItem']['name']; ?> X <?php echo $superLottery['SuperLottery']['number_items']; ?></strong></p>
			</div>

			<div class="col-md-5">
				<h5>Ticket value : <?php echo number_format($superLottery['SuperLottery']['ticket_value'], 0); ?> <span class="badge">Points</span></h5>
				<h5>You have bought : <?php echo number_format($superLottery['SuperLottery']['ticket_value'], 0); ?> tickets for this super lottery</h5>
				<div class="progress">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="<?php echo $superLottery['SuperLottery']['nb_tickets']; ?>" style="width: 10%;">
						0/<?php echo $superLottery['SuperLottery']['nb_tickets']; ?> Tickets bought
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="articles form">
					<?php echo $this->Form->create('SuperLotteryTicket', array('url' => array('controller' => 'SuperLotteryTicket', 'action' => 'buy'))); ?>
						<div class="btn-group btn-group-vertical">
							<?php
							echo $this->Form->input('nb_tickets_buy', array(
								'label' => false,
								'type' => 'number',
								'min' => '1',
								'step' => '1',
								'placeholder' => 'Number of tickets',
								'div' => false,
								'class' => 'form-control',
								'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
								));
								?>
								<?php 
								$optionsForm = array(
									'label' => 'Buy Tickets',
									'div' => false,
									'class' => 'btn btn-block btn-primary'
									);
									echo $this->Form->end($optionsForm); ?>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>