<?php if(isset($superLottery['SuperLottery'])):?>
	<div class="row super-lot">
		<div class="col-md-10 col-sm-12 col-md-offset-1 well well-sm <?php if($superLottery['SuperLottery']['status']=='unclaimed'){echo 'well-unclaimed';}else if($superLottery['SuperLottery']['status']=='claimed'){echo 'well-claimed';}else{echo 'well-finished';}?>">
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
								<h5>You have win this super lottery with <?php if(isset($superLottery['SuperLotteryTicket'][$userGlobal['id']])){echo number_format($superLottery['SuperLotteryTicket'][$userGlobal['id']]['nb_tickets'], 0);} else{echo '0';} ?> tickets.</h5>
							<?php endif; ?>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="<?php echo $superLottery['SuperLottery']['nb_tickets']; ?>" style="width: 100%;">
									<?php echo $superLottery['SuperLottery']['nb_ticket_bought']; ?>/<?php echo $superLottery['SuperLottery']['nb_tickets']; ?> Tickets bought
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="col-md-3">
					<?php if($superLottery['SuperLottery']['status']=='unclaimed'): ?>
						<div class="form">
							<button class="btn btn-block btn-default btn-super-claim" data-super-lottery-id="<?php echo $superLottery['SuperLottery']['id']; ?>">Claim this super Lottery</button>
						</div>
					<?php elseif($superLottery['SuperLottery']['status']=='claimed') : ?>
						<button class="btn btn-block btn-default btn-claim btn-claim-credits" disabled>Super Lottery Claimed</button>
					<?php else: ?>
						<p>Super Lottery Completed. The items have been contracted to you.</p>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>
<?php endif; ?>