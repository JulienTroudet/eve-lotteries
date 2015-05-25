<?php if(isset($superLottery['SuperLottery'])):?>
	<div class="row super-lot">
		<div class="col-md-10 col-sm-12 col-md-offset-1 well well-sm <?php if($superLottery['SuperLottery']['status']=='ongoing'){echo 'well-ongoing';}else{echo 'well-finished';}?>">
			<div class="row">
				<div class="col-md-1">
					<img src="<?php echo $superLottery['EveItem']['EveCategory']['url_start'].$superLottery['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $superLottery['EveItem']['name']; ?>">
				</div>

				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12 col-super-panel">
							<h3><?php echo $this->Html->link(
								$superLottery['SuperLottery']['name'].' <strong class="super-countdown"></strong>', 
								array('controller' => 'super_lotteries', 'action' => 'view', 'admin'=>false, 'plugin' => false, $superLottery['SuperLottery']['id']),
								array('escape' => false)
								);?>
							</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 col-super-panel">
							
							<p>Prize : <strong><?php echo $superLottery['EveItem']['name']; ?> X <?php echo $superLottery['SuperLottery']['number_items']; ?></strong></p>
						</div>

						<div class="col-md-7 col-super-panel">

							<p>
								<?php if(isset($userGlobal['id'])):?>
									<h5>You have bought <?php if(isset($superLottery['SuperLotteryTicket'][$userGlobal['id']])){echo number_format($superLottery['SuperLotteryTicket'][$userGlobal['id']]['nb_tickets'], 0);} else{echo '0';} ?> out of <?php echo number_format($superLottery['SuperLottery']['nb_ticket_bought'], 0); ?> tickets.</h5>
								<?php endif; ?>
							</p>
							<p>
							<?php echo CakeTime::niceShort($superLottery['SuperLottery']['start_date']); ?> - <?php echo CakeTime::niceShort($superLottery['SuperLottery']['expiration_date']); ?>
							</p>							
						</div>

					</div>
				</div>
				<div class="col-md-3">
					<?php if($superLottery['SuperLottery']['status']=='ongoing'): ?>
						<div>
							<h3>Buy Tickets:</h3>
							<div class="row row-super-lot">
								<div class="col-md-3 col-sm-3 col-xs-3 col-btn-super-lot" data-toggle="tooltip" data-placement="left" title="1 ticket for 1 points">
									<button class="btn btn-primary buy-super-ticket" data-id-super="<?php echo $superLottery['SuperLottery']['id']; ?>" data-nb-ticket="1">
										1
									</button>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-3 col-btn-super-lot" data-toggle="tooltip" data-placement="left" title="5 tickets for 5 points">
									<button class="btn btn-primary buy-super-ticket" data-id-super="<?php echo $superLottery['SuperLottery']['id']; ?>" data-nb-ticket="5">
										5
									</button>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-3 col-btn-super-lot" data-toggle="tooltip" data-placement="left" title="10 tickets for 10 points">
									<button class="btn btn-primary buy-super-ticket" data-id-super="<?php echo $superLottery['SuperLottery']['id']; ?>" data-nb-ticket="10">
										10
									</button>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-3 col-btn-super-lot" data-toggle="tooltip" data-placement="left" title="20 tickets for 20 points">
									<button class="btn btn-primary buy-super-ticket" data-id-super="<?php echo $superLottery['SuperLottery']['id']; ?>" data-nb-ticket="20">
										20
									</button>
								</div>
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
	<?php if(isset($timestamp_super_lotteries)) :?>
		<input type="hidden" id="timestamp-super-lotteries" value="<?php echo $timestamp_super_lotteries; ?>"/>
	<?php endif; ?>
<?php endif; ?>