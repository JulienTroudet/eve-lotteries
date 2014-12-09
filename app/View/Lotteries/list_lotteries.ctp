<div class="row">
	<h2>Ongoing Lotteries</h2>
	<?php foreach ($lotteries as $lottery){ echo $this->element('LotteryPanel', array(
	"lottery" => $lottery ));} ?>
</div>
<h2>Won Lotteries</h2>
<div class="row">
	<?php foreach ($old_lotteries as $lottery){echo $this->element('OldLotteryPanel', array(
	"lottery" => $lottery ));}?>
</div>
<div class="row">
	<div class="col-md-3 pull-right">
		<?php echo $this->Html->link('See more won lotteries', array('controller' => 'lotteries', 'action' => 'old_list'), array('class' => 'btn btn-lg btn-primary') ); ?>
	</div>
</div>

