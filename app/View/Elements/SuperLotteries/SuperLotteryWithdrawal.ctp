<?php if(isset($superLottery['SuperLottery'])):?>
	<div class="row super-lot">
		<div class="col-md-10 col-sm-12 col-md-offset-1 well well-sm <?php if($superLottery['SuperLottery']['status']=='unclaimed'){echo 'well-unclaimed';}else if($superLottery['SuperLottery']['status']=='claimed'){echo 'well-claimed';}else{echo 'well-finished';}?>">
			<div class="row">
				<div class="col-md-1">
					<img src="<?php echo $superLottery['EveItem']['EveCategory']['url_start'].$superLottery['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $superLottery['EveItem']['name']; ?>">
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
						</div>

						<div class="col-md-7">

							<?php if(isset($userGlobal['id'])):?>
								<h5>You have won this Super Lottery with <?php if(isset($superLottery['SuperLotteryTicket'][$userGlobal['id']])){echo number_format($superLottery['SuperLotteryTicket'][$userGlobal['id']]['nb_tickets'], 0);} else{echo '0';} ?> tickets bought out of <?php echo $superLottery['SuperLottery']['nb_ticket_bought']?>.</h5>
							<?php endif; ?>
						</div>

					</div>
				</div>
				<div class="col-md-3">
					<?php if($superLottery['SuperLottery']['status']=='unclaimed'): ?>
						<div class="form">
							<button class="btn btn-block btn-default btn-super-claim" data-super-claim-type="item" data-super-lottery-id="<?php echo $superLottery['SuperLottery']['id']; ?>">
								Claim as Item(s)
							</button>
							<button class="btn btn-block btn-default btn-super-claim" data-super-claim-type="credits" data-super-lottery-id="<?php echo $superLottery['SuperLottery']['id']; ?>">
								Claim as Credits
							</button>
							<button class="btn btn-block btn-default btn-super-claim" data-super-claim-type="ISK" data-super-lottery-id="<?php echo $superLottery['SuperLottery']['id']; ?>">
								Claim as ISK
							</button>
						</div>
					<?php elseif($superLottery['SuperLottery']['status']=='claimed_item') : ?>
						<button class="btn btn-block btn-default btn-claim btn-claim-credits" disabled>Item(s) Claimed</button>
					<?php elseif($superLottery['SuperLottery']['status']=='claimed_isk') : ?>
						<button class="btn btn-block btn-default btn-claim btn-claim-credits" disabled>ISK Claimed</button>


					<?php elseif($superLottery['SuperLottery']['status']=='completed_item') : ?>
						<p>Super Lottery Completed. The items have been contracted to you.</p>

					<?php elseif($superLottery['SuperLottery']['status']=='completed_credits') : ?>
						<p>Super Lottery Completed. Credits given.</p>

					<?php elseif($superLottery['SuperLottery']['status']=='completed_isk') : ?>
						<p>Super Lottery Completed. ISK have been sent to you</p>

					<?php else: ?>
						<p>Super Lottery Completed. The items have been contracted to you.</p>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>
<?php endif; ?>
