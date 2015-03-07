<h2>Won Flash Lotteries</h2>
<?php foreach ($flashWithdrawals as $flashWithdrawal): ?>
	<?php if (isset($flashWithdrawal)){ echo $this->element('FlashLotteries/FlashLotteryWithdrawalPanel', array("flashLottery" => $flashWithdrawal ));} ?>
<?php endforeach; ?>
