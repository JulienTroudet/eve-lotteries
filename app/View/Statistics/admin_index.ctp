<div id="wrapper">
	<?php
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<table role="table" class="table table-striped">
				<thead>
					
				</thead>
				<tbody>
					<tr>
						<td>Total won</td>
						<td><?php echo number_format($totalWon, 2) ; ?> ISK</td>
					</tr>
					<tr>
						<td>Total Deposited</td>
						<td><?php echo number_format($totalDeposited, 2) ; ?> ISK</td>
					</tr>
					<tr>
						<td>Total In Wallets</td>
						<td><?php echo number_format($totalWallets, 2) ; ?> ISK</td>
					</tr>
					<tr>
						<td>Total In unclaimed Lotteries</td>
						<td><?php echo number_format($totalUnclaimed, 2) ; ?> ISK</td>
					</tr>
					<tr>
						<td>Total In claimed not completed Lotteries</td>
						<td><?php echo number_format($totalClaimed, 2) ; ?> ISK</td>
					</tr>
					<tr>
						<td>Total In Play (Lotteries)</td>
						<td><?php echo number_format($totalInPlay, 2) ; ?> ISK</td>
					</tr>
					<tr>
						<td>Total In Play (Super Lotteries)</td>
						<td><?php echo number_format($totalInPlaySuper, 2) ; ?> ISK</td>
					</tr>
					<tr>
						<td><strong>Should stay in Wallet Corpo</strong></td>
						<td><?php echo number_format($totalInPlaySuper+$totalInPlay+$totalClaimed+$totalUnclaimed+$totalWallets, 2) ; ?> ISK</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>