<div class="row">
	<div class="col-md-3">
		<h2 class="pull-left">Ongoing Lotteries</h2>
	</div>
	<div class="col-md-9">
		<h3 class="pull-right">Total won: <?php echo number_format($totalWon, 2); ?> ISK</h3>
	</div>
</div>
<div class="row">
	<?php foreach ($lotteries as $lottery){ echo $this->element('Lotteries/LotteryPanel', array(
	"lottery" => $lottery ));} ?>
</div>
<h2>Last won Lotteries</h2>
<div class="row">
	<?php foreach ($old_lotteries as $lottery){echo $this->element('Lotteries/OldLotteryPanel', array(
	"lottery" => $lottery ));}?>
</div>
<div class="row">
	<div class="col-md-12">
		<?php echo $this->Html->link('See all Flash lotteries', array('controller' => 'flash_lotteries', 'action' => 'index'), array('class' => 'btn btn-lg btn-primary') ); ?>
		<?php echo $this->Html->link('See all Super lotteries', array('controller' => 'super_lotteries', 'action' => 'index'), array('class' => 'btn btn-lg btn-primary') ); ?>
		<?php echo $this->Html->link('See more won lotteries', array('controller' => 'lotteries', 'action' => 'old_list'), array('class' => 'btn btn-lg btn-primary') ); ?>
	</div>
</div>
<input type="hidden" id="timestamp-lotteries" value="<?php echo $timestamp_lotteries; ?>"/>
<input type="hidden" id="server-date" value="<?php echo date("c") ?>"/>
<script type="text/javascript">
	$(document).ready(function() {
		$("[data-toggle='tooltip']").tooltip();
	});
</script>