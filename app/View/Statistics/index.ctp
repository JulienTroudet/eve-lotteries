<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));} 
	else{echo '<h2>Want to play ? Log in with your EVE account !</h2>';}?>
</div>
<div class="statistics index">
	<h2>Total ISK played : <?php echo number_format($totalPlayed) ; ?> <i class="fa fa-money"></i></h2>
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Most ISK earned</h3></div>
				<div class="panel-body">
					<?php foreach ($usersIsk as $key => $user): ?>
						<?php echo $this->element('Statistics/UserStatPanel', array("user" => $user)); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Most Lotteries Won</h3></div>
				<div class="panel-body">
					<?php foreach ($usersLotWon as $key => $user): ?>
						<?php echo $this->element('Statistics/UserStatPanel', array("user" => $user)); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><h3>Most Items claimed</h3></div>
				<div class="panel-body">
					<?php foreach ($usersItems as $key => $user): ?>
						<?php echo $this->element('Statistics/UserStatPanel', array("user" => $user)); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>	
