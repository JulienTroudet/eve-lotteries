<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));} 
	else{echo $this->element('VisitorNavbar', array());}?>
</div>




<div class="transactions index">
	

	
	<div class="row">
		<div id="wallet-resume" class="col-md-6 col-sm-12">
			<?php
			$buttonDeposit = '';
			if(isset($_SERVER['HTTP_EVE_TRUSTED']) && $_SERVER['HTTP_EVE_TRUSTED']=='Yes'){
				$buttonDeposit = '<a class="btn btn-lg btn-block btn-success" href="#" onclick="CCPEVE.showInfo(2, 98342107);" data-toggle="tooltip" data-placement="top" title="The deposits made to EVE-Lotteries will be available at the next API check.">Deposit <span class="badge">ISK</span></a>';
			}
			else {
				$buttonDeposit = '<a class="btn btn-lg btn-block btn-success" onclick="CCPEVE.showInfo(2, 98342107);" data-toggle="tooltip" data-placement="top" title="You must use the Ingame Browser to deposit ISK">Deposit <span class="badge">ISK</span></a>';
			}
			?>

			<h3>My Wallet</h3>
			<div class="well well-sm">
				<h3 style="margin-top: 10px;">
					<small>Actual credits : </small><?php echo number_format($userGlobal['wallet'],2); ?> <i class="fa fa-money"></i>
				</h3>
			</div>
			<p>
				<?php echo $buttonDeposit; ?>
			</p>
			<div class="alert alert-info" role="alert">
				<p>You can only deposit ISK in game. You can freely deposit any amount to the account of the EVE-Lotteries Corporation. No justification is needed. Your account will be updated on the next API check at : <?php echo $apiCheckTime; ?></p>
			</div>

			<!-- <div class="well well-sm">
				<small>Waiting withdrawal : </small>00000000000000000000<span class="badge">ISK</span>
			</div>
			<div class="alert alert-info" role="alert">
				<p>The ISK you withdraw will be added to your in game account by our team. Thank you for your patience.</p>
			</div> -->
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Account informations</h3>
				</div>
				<div class="panel-body">
					<div class="alert alert-success" role="alert">
						Total deposits : <?php echo number_format($totalDeposit,2); ?> <span class="badge">ISK</span>
					</div>
					<div class="alert alert-danger" role="alert">
						Total withdrawals : <?php echo number_format($totalClaimedIsk,2); ?> <span class="badge">ISK</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<h3>In Game Transactions</h3>
			<table class="table table-striped table-condensed">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('amount'); ?></th>
						<th><?php echo $this->Paginator->sort('eve_date'); ?></th>
						<th><?php echo $this->Paginator->sort('created'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($transactions as $transaction): ?>
						<tr>
							<td><?php echo h($transaction['Transaction']['amount']); ?>&nbsp;</td>
							<td><?php echo h($transaction['Transaction']['eve_date']); ?>&nbsp;</td>
							<td><?php echo h($transaction['Transaction']['created']); ?>&nbsp;</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div>
				<ul class="pager">
					<li class="previous">
						<?php
						echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
						?>
					</li>
					<li>
						<?php
						echo $this->Paginator->counter(array(
							'format' => __('Page {:page} of {:pages}, for {:count} Transactions')
							));
							?>	
						</li>
						<li class="next">
							<?php
							echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
							?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>