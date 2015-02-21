<div id="user-navbar">
	<?php echo $this->element('UserNavbar', array("userGlobal" => $userGlobal)); ?>
</div>
<div class="statistics index">
	<h2>Total won : <?php echo number_format($totalWon, 2) ; ?> ISK</h2>
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Most ISK won</h3></div>
				<div class="panel-body">
					<?php foreach ($usersIsk as $key => $user): ?>
						<?php echo $this->element('Statistics/UserStatPanel', array("user" => $user)); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Most Lotteries won</h3></div>
				<div class="panel-body">
					<?php foreach ($usersLotWon as $key => $user): ?>
						<?php echo $this->element('Statistics/UserStatPanel', array("user" => $user)); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Items most played</h3></div>
				<div class="panel-body">
					<?php foreach ($popularsItems as $key => $popularItem): ?>
						<?php echo $this->element('Statistics/ItemStatPanel', array("popularItem" => $popularItem)); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>	