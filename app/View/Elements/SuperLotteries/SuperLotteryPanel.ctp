<?php if(isset($superLottery['SuperLottery'])):?>
	<div class="row super-lot">
		<div class="col-md-10 col-sm-12 col-md-offset-1 well well-sm <?php if($superLottery['SuperLottery']['status']=='ongoing'){echo 'well-ongoing';}else{echo 'well-finished';}?>">
			<div class="row">
				<div class="col-md-1">
					<img src="https://image.eveonline.com/Render/<?php echo $superLottery['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $superLottery['EveItem']['name']; ?>">
				</div>

				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<h3><?php echo $this->Html->link(
								$superLottery['SuperLottery']['name'], 
								array('controller' => 'super_lotteries', 'action' => 'index', 'admin'=>false, 'plugin' => false)
								);?>
							</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5">
							
							<p>Prize : <strong><?php echo $superLottery['EveItem']['name']; ?> X <?php echo $superLottery['SuperLottery']['number_items']; ?></strong></p>
							<h5>Ticket value : <?php echo number_format($superLottery['SuperLottery']['ticket_value'], 0); ?> <span class="badge">Points</span></h5>
						</div>

						<div class="col-md-7">

							<?php if(isset($userGlobal['id'])):?>
								<h5>You have bought : <?php if(isset($superLottery['SuperLotteryTicket'][$userGlobal['id']])){echo number_format($superLottery['SuperLotteryTicket'][$userGlobal['id']]['nb_tickets'], 0);} else{echo '0';} ?> tickets for this super lottery</h5>
							<?php endif; ?>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="<?php echo $superLottery['SuperLottery']['nb_tickets']; ?>" style="width: <?php echo $superLottery['percentage']; ?>%;">
									<?php echo $superLottery['SuperLottery']['nb_ticket_bought']; ?>/<?php echo $superLottery['SuperLottery']['nb_tickets']; ?> Tickets bought
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="col-md-3">
					<?php if($superLottery['SuperLottery']['status']=='ongoing'): ?>
						<div class="form">
							<?php echo $this->Form->create('SuperLotteryTicket', array('url' => array('controller' => 'SuperLotteryTickets', 'action' => 'buy'))); ?>
							<div class="btn-group btn-group-vertical">
								<?php
								echo $this->Form->input('super_lottery_id', array(
									'default' => $superLottery['SuperLottery']['id'],
									'label' => false,
									'type' => 'number',
									'hidden' => 'true',
									'div' => false,
									));
									?>
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
								<?php else: ?>
									<div class="media" >
										<span class="pull-right">
											<img src="https://image.eveonline.com/Character/<?php echo $superLottery['Winner']['id']; ?>_64.jpg" /> 
										</span>
										<span>
											<p>Winner :</p>
											<p class="pull-right"><strong><?php echo $superLottery['Winner']['eve_name']; ?></strong></p>
										</span>
									</div>
								<?php endif; ?>
							</div>

						</div>
					</div>
				</div>
			<?php endif; ?>