<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="statistics index">
				<h2>Total won : <?php echo number_format($totalWon, 2) ; ?> ISK</h2>

				<h2>Total Deposited : <?php echo number_format($totalDeposited, 2) ; ?> ISK</h2>

				<h2>Total In Wallets : <?php echo number_format($totalWallets, 2) ; ?> ISK</h2>

				<h2>Total In unclaimed Lotteries : <?php echo number_format($totalUnclaimed, 2) ; ?> ISK</h2>

				<h2>Total In claimed not completed Lotteries : <?php echo number_format($totalClaimed, 2) ; ?> ISK</h2>

				<h2>Total In Play (Lotteries) : <?php echo number_format($totalInPlay, 2) ; ?> ISK</h2>

				<h2>Total In Play (Super Lotteries) : <?php echo number_format($totalInPlaySuper, 2) ; ?> ISK</h2>

			</div>	
		</div>
	</div>
</div>
