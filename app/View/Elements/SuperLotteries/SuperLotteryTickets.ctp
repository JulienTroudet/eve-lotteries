<div class="row super-lott">
			<div class="col-md-10 col-sm-12 col-md-offset-1 well well-sm <?php if($superLottery['SuperLottery']['status']=='ongoing'){echo 'well-ongoing';}else{echo 'well-finished';}?>">
				<div class="row">
					<div class="col-md-2">
					<img src="<?php echo $superLottery['EveItem']['EveCategory']['url_start'].$superLottery['EveItem']['eve_id'].$superLottery['EveItem']['EveCategory']['url_big_end']; ?>" alt="<?php echo $superLottery['EveItem']['name']; ?>">
					</div>

					<div class="col-md-7">
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
									<?php if(isset($userGlobal['id'])):?>
										<p>You have bought <?php if(isset($superLottery['SuperLotteryTicket'][$userGlobal['id']])){echo number_format($superLottery['SuperLotteryTicket'][$userGlobal['id']]['nb_tickets'], 0);} else{echo '0';} ?> out of <?php echo number_format($superLottery['SuperLottery']['nb_ticket_bought'], 0); ?> tickets.</p>
									<?php endif; ?>
								<p><?php echo CakeTime::niceShort(h($superLottery['SuperLottery']['start_date'])); ?> - <?php echo CakeTime::niceShort(h($superLottery['SuperLottery']['expiration_date'])); ?></p>

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
<div id="players-list" class="row">
		

		<?php foreach ($superLottery['SuperLotteryTicket'] as $key => $ticket): ?>
			<div class="col-md-3 col-sm-4">
				<div class="media well well-sm super-buyer <?php if($ticket['User']['id'] == $superLottery['Winner']['id']){echo 'super-winner';}?>">
					<span class="pull-left">
						<img src="https://image.eveonline.com/Character/<?php echo $ticket['User']['id']; ?>_64.jpg"> 
					</span>
					<p><strong><?php echo $ticket['User']['eve_name']; ?></strong></p>
					<p><?php echo $ticket['nb_tickets']; ?> tickets bought.</p>
					<p><?php echo number_format($ticket['nb_tickets']/$superLottery['SuperLottery']['nb_ticket_bought']*100, 1); ?>% chances of winning.</p>
				</div>
			</div>
		<?php endforeach ?>
	</div>


<div class="row">
	<div class="col-md-3 pull-right">
		<?php echo $this->Html->link('See all Super lotteries', array('controller' => 'super_lotteries', 'action' => 'index'), array('class' => 'btn btn-lg btn-block btn-primary') ); ?>
	</div>
</div>