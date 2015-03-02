<?php echo $this->Html->script('isotope.pkgd.min');?>
<?php if(isset($flashLottery['FlashLottery'])):?>
<div class="row flash-lot">
	<div class="col-md-10 col-sm-10 col-md-offset-1 well well-sm <?php if($flashLottery['FlashLottery']['status']=='ongoing'){echo 'well-ongoing';}else{echo 'well-finished';}?>">
		<div class="row">
			<div class="col-md-1">
				<img src="<?php echo $flashLottery['EveItem']['EveCategory']['url_start'].$flashLottery['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $flashLottery['EveItem']['name']; ?>"
				data-toggle="tooltip"
				data-placement="right"
				title = "Prize: <?php echo $flashLottery['EveItem']['name'];?> x <?php echo $flashLottery['FlashLottery']['number_items']; ?>"
				>
			</div>
			<div class="col-md-9" id="flash-tickets-container">
				
				<?php foreach ($flashLottery['FlashTicket'] as $key => $ticket) :?>
				
				<?php echo $this->element('FlashLotteries/FlashTicketIcon', array("flashTicket" => $ticket )); ?>
				<?php endforeach; ?>
				
			</div>
			<div class="col-md-2">
				<?php if($flashLottery['FlashLottery']['status']=='unclaimed'): ?>
				<div class="form">
					<button class="btn btn-block btn-default btn-super-claim" data-super-lottery-id="<?php echo $flashLottery['FlashLottery']['id']; ?>">Claim this super Lottery</button>
				</div>
				<?php elseif($flashLottery['FlashLottery']['status']=='claimed') : ?>
				<button class="btn btn-block btn-default btn-claim btn-claim-credits" disabled>Super Lottery Claimed</button>
				<?php else: ?>
				<p>Super Lottery Completed. The items have been contracted to you.</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
	
</div>
<?php endif; ?>
<script>
	$(document).ready(function() {
		organizeFlashTickets();
	});


	function organizeFlashTickets(){
		var $container = $('#flash-tickets-container');

		$container.isotope({
			itemSelector: '.flash-ticket',
			layoutMode: 'fitRows'
		});
	}
</script>