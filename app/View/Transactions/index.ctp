<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>




<div class="transactions index">
	

	
	<div class="row">
		<div id="wallet-resume" class="col-md-6 col-sm-12">
			<ul id="wallet-tabs" class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#wallet-pane" role="tab" data-toggle="tab">My Wallet</a></li>
				<li><a href="#statistics-pane" role="tab" data-toggle="tab">My Statistics</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade in active" id="wallet-pane">
					<?php
					$buttonDeposit = '';
					if(isset($_SERVER['HTTP_EVE_TRUSTED']) && $_SERVER['HTTP_EVE_TRUSTED']=='Yes'){
						$buttonDeposit = '<a class="btn btn-lg btn-block btn-success" href="#" onclick="CCPEVE.showInfo(2, 98342107);" data-toggle="tooltip" data-placement="top" title="The deposits made to EVE-Lotteries will be available at the next API check.">Deposit <span class="badge">ISK</span></a>';
					}
					else {
						$buttonDeposit = '<a class="btn btn-lg btn-block btn-success" onclick="CCPEVE.showInfo(2, 98342107);" data-toggle="tooltip" data-placement="top" title="You must use the Ingame Browser to deposit ISK">Deposit <span class="badge">ISK</span></a>';
					}
					?>
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

					<div class="well well-sm">
						<small>Waiting withdrawal : </small><?php echo number_format($waitingWithdrawals,2); ?> <span class="badge">ISK</span> (Items not included)
					</div>

					<div class="alert alert-info" role="alert">
						<p>The ISK you withdraw will be added to your in game account by our team. Thank you for your patience.</p>
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Account informations</h3>
						</div>
						<div class="panel-body">
							<div class="alert alert-success" role="alert">
								Total deposits : <?php echo number_format($totalDeposit,2); ?> <span class="badge">ISK</span>
							</div>
							<div class="alert alert-danger" role="alert">
								Total claimed ISK : <?php echo number_format($totalClaimedIsk,2); ?> <span class="badge">ISK</span> (Items included)
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="statistics-pane">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Lotteries statistics</h3>
						</div>
						<div class="panel-body" style="padding-bottom:0px">
							<div class="well well-sm">
								Lotteries played : <?php echo number_format($totalLotteriesPlayed,0); ?> 
							</div>
							<div class="well well-sm">
								Lotteries won : <?php echo number_format($totalLotteriesWon,0); ?>
							</div>
						</div>
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Super Lotteries statistics</h3>
						</div>
						<div class="panel-body" style="padding-bottom:0px">
							<div class="well well-sm">
								Super Lotteries played : <?php echo number_format($totalSuperLotteriesPlayed,0); ?> 
							</div>
							<div class="well well-sm">
								Super Lotteries won : <?php echo number_format($totalSuperLotteriesWon,0); ?>
							</div>
						</div>
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">ISK and credits statistics</h3>
						</div>
						<div class="panel-body" style="padding-bottom:0px">
							<div class="well well-sm">
								Total deposits : <?php echo number_format($totalDeposit,2); ?> <span class="badge">ISK</span>
							</div>
							<div class="well well-sm">
								Total Credits played : <?php echo number_format($totalPlayed,2); ?> <i class="fa fa-money"></i>
							</div>
							<div class="well well-sm">
								Total claimed ISK : <?php echo number_format($totalClaimedIsk,2); ?> <span class="badge">ISK</span> (Items included)
							</div>
							<div class="well well-sm">
								Total claimed Credits : <?php echo number_format($totalCreditsClaimed,2); ?> <i class="fa fa-money"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<ul id="transactions-tabs" class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#in-game-pane" role="tab" data-toggle="tab">In Game Transactions</a></li>
				<li><a href="#el-tansaction-pane" role="tab" data-toggle="tab">EVE-Lotteries Transactions</a></li>
			</ul>
			<div class="tab-content">
				<?php
				$this->Js->JqueryEngine->jQueryObject = 'jQuery';
				$transactionPaginator = clone $this->Paginator; //workaround to implement the second paginator
				$statisticsPaginator = $this->Paginator; 
				$transactionPaginator->options(array('update' => '#in-game-pane', 'evalScripts' => true));
				$statisticsPaginator->options(array('update' => '#el-tansaction-pane', 'evalScripts' => true));
				?>
				<div class="tab-pane fade in active" id="in-game-pane">

					<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th><?php echo $transactionPaginator->sort('amount', 'Amount', array('url'=>array('action'=>'list_transactions'))); ?></th>
								<th><?php echo $transactionPaginator->sort('eve_date', 'EVE Date', array('url'=>array('action'=>'list_transactions'))); ?></th>
								<th><?php echo $transactionPaginator->sort('created', 'Date', array('url'=>array('action'=>'list_transactions'))); ?></th>
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
					<div class="row">
						<div class="col-md-12">
							<ul class="pager">
								<li class="previous">
									<?php echo $transactionPaginator->prev('Previous', array('url'=>array('action'=>'list_transactions')), null, array('class' => 'prev disabled')); ?>
								</li>
								<li>
									<?php echo $transactionPaginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>	
								</li>
								<li class="next">
									<?php echo $transactionPaginator->next('Next', array('url'=>array('action'=>'list_transactions')), null, array('class' => 'next disabled')); ?>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="el-tansaction-pane">
					<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th><?php echo $statisticsPaginator->sort('isk_value', __('Value'), array('url'=>array('controller'=>'statistics', 'action'=>'list_stats'))); ?></th>
								<th><?php echo $statisticsPaginator->sort('type', __('Type'), array('url'=>array('controller'=>'statistics', 'action'=>'list_stats'))); ?></th>
								<th><?php echo $statisticsPaginator->sort('created', __('Date'), array('url'=>array('controller'=>'statistics', 'action'=>'list_stats'))); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($player_stats as $player_stat): ?>
								<tr>
									<?php
									switch ($player_stat['Statistic']['type']) {
										case 'withdrawal_credits':
										$player_stat['Statistic']['type'] = 'Lottery Credits Prize';
										break;
										case 'buy_ticket':
										$player_stat['Statistic']['type'] = 'Ticket Bought';
										$player_stat['Statistic']['isk_value'] = $player_stat['Statistic']['isk_value']*-1;
										break;
										case 'sponsor_isk':
										$player_stat['Statistic']['type'] = 'Sponsoring Bonus';
										break;
									}


									?>
									<td><?php echo h($player_stat['Statistic']['isk_value']); ?>&nbsp;</td>
									<td><?php echo h($player_stat['Statistic']['type']); ?>&nbsp;</td>
									<td><?php echo h($player_stat['Statistic']['created']); ?>&nbsp;</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<div class="row">
						<div class="col-md-12">
							<ul class="pager">
								<li class="previous">
									<?php echo $statisticsPaginator->prev('Previous', array('url'=>array('controller'=>'statistics', 'action'=>'list_stats')), null, array('class' => 'prev disabled')); ?>
								</li>
								<li>
									<?php echo $statisticsPaginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>	
								</li>
								<li class="next">
									<?php echo $statisticsPaginator->next('Next', array('url'=>array('controller'=>'statistics', 'action'=>'list_stats')), null, array('class' => 'next disabled')); ?>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo $this->Js->writeBuffer(); ?>