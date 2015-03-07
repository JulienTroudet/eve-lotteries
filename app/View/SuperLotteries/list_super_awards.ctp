<h2>Won Super Lotteries</h2>
<?php foreach ($superWithdrawals as $superWithdrawal): ?>
	<?php if (isset($superWithdrawal)){ echo $this->element('SuperLotteries/SuperLotteryWithdrawal', array("superLottery" => $superWithdrawal ));} ?>
<?php endforeach; ?>
