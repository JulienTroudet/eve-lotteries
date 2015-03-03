<?php echo $this->Html->script('isotope.pkgd.min');?>
<?php if (!empty($superLottery) && !empty($flashLottery)): ?>
	<div id="carousel-special-lotteries" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner" role="listbox">
			<div class="item active" id="last-flash-lottery">
				<?php echo $this->element('FlashLotteries/FlashLotteryPanel', array("flashLottery" => $flashLottery, "userGlobal" => $userGlobal)); ?>
			</div>
			<div class="item" id="last-super-lottery">
				<?php echo $this->element('SuperLotteries/SuperLotteryPanel', array("superLottery" => $superLottery, "userGlobal" => $userGlobal)); ?>
			</div>
		</div>
		<a class="left carousel-control" href="#carousel-special-lotteries" role="button" data-slide="prev">
			<i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-special-lotteries" role="button" data-slide="next">
			<i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i>
			<span class="sr-only">Next</span>
		</a>
	</div>
<?php else: ?>
	<?php if (!empty($superLottery)): ?>
		<div id="last-flash-lottery">
			<?php echo $this->element('FlashLotteries/FlashLotteryPanel', array("flashLottery" => $flashLottery, "userGlobal" => $userGlobal)); ?>
		</div>
	<?php elseif (!empty($flashLottery)): ?>
		<div id="last-super-lottery">
			<?php echo $this->element('SuperLotteries/SuperLotteryPanel', array("superLottery" => $superLottery, "userGlobal" => $userGlobal)); ?>
		</div>
	<?php endif; ?>
<?php endif; ?>

<script>
	$(document).ready(function() {
		$('.carousel').carousel({
			interval: 20000
		});

		updateFlashCountDown();
	});

	function updateFlashCountDown() {
		countdown.setLabels(
			'ms| sec| min| hr|| wk|| yr',
			'ms| secs| mins| hrs|| wk|| yrs',
			' and ');
		exp_date = "<?php echo $flashLottery['FlashLottery']['expiration_date']; ?>";

		if(moment(exp_date).isAfter()){
			$('.flash-countdown').html("End in "+moment(exp_date).countdown().toString());
		}
		else{
			$('.flash-countdown').html("Closed");
		}
		setTimeout(updateFlashCountDown, 10 );
	}

</script>