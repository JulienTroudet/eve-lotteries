<div class="row">
				<?php foreach ($lotteries as $lottery){ echo $this->element('LotteryPanel', array(
				"lottery" => $lottery ));} ?>
			</div>
			<h2>Won Lotteries</h2>
			<div class="row">
				<?php foreach ($old_lotteries as $lottery){echo $this->element('OldLotteryPanel', array(
				"lottery" => $lottery ));}?>
			</div>
			<div class="pull-right">
				<?php echo $this->Html->link('See more won lotteries', array('controller' => 'lotteries', 'action' => 'list_old'), array('class' => 'btn btn-lg btn-primary') ); ?>
			</div>
