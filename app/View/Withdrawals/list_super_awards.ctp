<h2>Won Super Lotteries</h2>
<?php foreach ($superWithdrawals as $superWithdrawal): ?>
	<?php if (isset($superWithdrawal)){ echo $this->element('SuperLotteries/SuperLotteryWithdrawal', array("superLottery" => $superWithdrawal ));} ?>
<?php endforeach; ?>
<div class="pull-right">
	<?php echo $this->Html->link('See all my Super Lotteries', array('controller' => 'withdrawals', 'action' => 'old_super_list'), array('class' => 'btn btn-lg btn-primary') ); ?>
</div>