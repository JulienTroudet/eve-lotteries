<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>
<div>
	<ul id="award-tabs" class="nav nav-tabs" role="tablist">
		<li class="active">
			<a href="#lotteries-pane" role="tab" data-toggle="tab" id="lotteries-link">
				My Lotteries <?php if($userGlobal['nb_new_won_lotteries']>0){echo '<span class="badge">'.$userGlobal['nb_new_won_lotteries'].'</span>';}?>
			</a>
		</li>
		<li>
			<a href="#super-lotteries-pane" role="tab" data-toggle="tab" id="super-lotteries-link">
				My Super Lotteries <?php if($userGlobal['nb_new_won_super_lotteries']>0){echo '<span class="badge">'.$userGlobal['nb_new_won_super_lotteries'].'</span>';}?>
			</a>
		</li>
		<li>
			<a href="#flash-lotteries-pane" role="tab" data-toggle="tab" id="flash-lotteries-link">
				My Flash Lotteries <?php if($userGlobal['nb_new_won_flash_lotteries']>0){echo '<span class="badge">'.$userGlobal['nb_new_won_flash_lotteries'].'</span>';}?>
			</a>
		</li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane fade in active" id="lotteries-pane">
			<div id="list-awards">
				<h2>Won Lotteries</h2>
				<div class="row">
					<?php foreach ($unclaimed_awards as $unclaimed_award){ echo $this->element('Withdrawals/AwardPanel', array("unclaimed_award" => $unclaimed_award ));} ?>
				</div>
				<div class="row">
					<div class="col-md-12">
						<ul class="pager">
							<li class="previous">
								<?php echo $this->Paginator->prev('Previous', array(), null, array('class' => 'prev disabled')); ?>
							</li>
							<li>
								<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>
							</li>
							<li class="next">
								<?php echo $this->Paginator->next('Next', array(), null, array('class' => 'next disabled')); ?>
							</li>
						</ul>
					</div>
				</div>
				<h2>Last Completed Lotteries</h2>
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Lottery Item</th>
									<th>Claimed as</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($claimed_awards as $claimed_award){?>
								<tr>
									<td>
										<?php echo $claimed_award['Ticket']['Lottery']['name']; ?>
									</td>
									<td>
										<?php
										switch ($claimed_award['Withdrawal']['type']) {
											case 'award_credit':
											echo number_format($claimed_award['Withdrawal']['value'], 2).' Credits';
											break;
											case 'award_isk':
											echo number_format($claimed_award['Withdrawal']['value'], 2).' ISK';
											break;
											case 'award_item':
											echo 'Item';
											break;
										}
										?>
									</td>
									<td>
										<?php echo $claimed_award['Withdrawal']['modified']; ?>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="pull-right">
					<?php echo $this->Html->link('See all my claimed Lotteries', array('controller' => 'withdrawals', 'action' => 'old_list'), array('class' => 'btn btn-lg btn-primary') ); ?>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="super-lotteries-pane">
			<div id="list-super-awards">
				<h2>Won Super Lotteries</h2>
				<?php foreach ($superWithdrawals as $superWithdrawal): ?>
					<?php if (isset($superWithdrawal)){ echo $this->element('SuperLotteries/SuperLotteryWithdrawal', array("superLottery" => $superWithdrawal ));} ?>
				<?php endforeach; ?>
				
			</div>
		</div>
		<div class="tab-pane fade" id="flash-lotteries-pane">
			<div id="list-flash-awards">
				<h2>Won Flash Lotteries</h2>
				<?php foreach ($flashWithdrawals as $flashWithdrawal): ?>
					<?php if (isset($flashWithdrawal)){ echo $this->element('FlashLotteries/FlashLotteryWithdrawalPanel', array("flashLottery" => $flashWithdrawal ));} ?>
				<?php endforeach; ?>

				
			</div>
		</div>
	</div>
	
</div>
<script>
	$(document).ready(function() {
		$("[data-toggle='tooltip']").tooltip();
		var hash = document.location.hash;
		var prefix = "tab_";
		if (hash) {
			$('.nav-tabs a[href='+hash.replace(prefix,"")+']').tab('show');
		}
		$('.nav-tabs a').on('shown.bs.tab', function (e) {
			window.location.hash = e.target.hash.replace("#", "#" + prefix);
		});
		instanciateButtons();
	});
	function refreshListAwards(){
		$.ajax({
			type:"get",
			url:"<?php echo $this->Html->url(array('controller' => 'withdrawals', 'action' => 'list_awards')); ?>",
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				$('#list-awards').html(response);
				instanciateButtons();
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText);
				console.log(e);
			}
		});
	}
	function refreshListSuperLotteries(){
		$.ajax({
			type:"get",
			url:"<?php echo $this->Html->url(array('controller' => 'super_lotteries', 'action' => 'list_super_awards')); ?>",
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				$('#list-super-awards').html(response);
				instanciateButtons();
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText);
				console.log(e);
			}
		});
	}
	function refreshListFlashLotteries(){
		$.ajax({
			type:"get",
			url:"<?php echo $this->Html->url(array('controller' => 'flash_lotteries', 'action' => 'list_flash_awards')); ?>",
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				$('#list-flash-awards').html(response);
				instanciateButtons();
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText);
				console.log(e);
			}
		});
	}
	function refreshUserNavbar(){
		$.ajax({
			type:"get",
			url:"<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'user_navbar')); ?>",
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				$('#user-navbar').html(response);
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText);
				console.log(e);
			}
		});
	}
	function instanciateButtons(){
		$('.btn-claim').click(function(){
			var idWithdrawal = $(this).data('award-id');
			var claimType = $(this).data('claim-type');
			$('.btn-claim').tooltip('destroy');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'withdrawals', 'action' => 'claim','ext' => 'json')); ?>",
				data:{
					withdrawal_id:idWithdrawal,
					claim_type:claimType
				},
				beforeSend: function(xhr) {
					xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				},
				success: function(response) {
					if (response.error) {
						toastr.warning(response.error);
						console.log(response.error);
					}
					if (response.success) {
						refreshListAwards();
						refreshUserNavbar();
						toastr.success('You have claim '+response.message+' !');

						if(response.nb_new_won_lotteries>0){
							$('#lotteries-link').html('My Lotteries <span class="badge">'+response.nb_new_won_lotteries+'</span>');
						}
						else{
							$('#lotteries-link').html('My Lotteries');
						}
						
					}
				},
				error: function(e) {
					alert("An error occurred: " + e.responseText);
					console.log(e);
				}
			});
		});
		$('.btn-super-claim').click(function(){
			var idSuperLottery = $(this).data('super-lottery-id');
			var claimTypeSuperLottery = $(this).data('super-claim-type');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'super_lotteries', 'action' => 'claim','ext' => 'json')); ?>",
				data:{
					super_lottery_id:idSuperLottery,
					super_lottery_claim_type:claimTypeSuperLottery,
				},
				beforeSend: function(xhr) {
					xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				},
				success: function(response) {
					if (response.error) {
						toastr.warning(response.error);
						console.log(response.error);
					}
					if (response.success) {
						refreshListSuperLotteries();
						refreshUserNavbar();
						toastr.success(response.message);
						if(response.nb_new_won_super_lotteries>0){
							$('#super-lotteries-link').html('My Super Lotteries <span class="badge">'+response.nb_new_won_super_lotteries+'</span>');
						}
						else{
							$('#super-lotteries-link').html('My Super Lotteries ');
						}
					}
				},
				error: function(e) {
					alert("An error occurred: " + e.responseText);
					console.log(e);
				}
			});
		});
		$('.btn-flash-claim').click(function(){
			var idFlashLottery = $(this).data('flash-lottery-id');
			var claimTypeFlashLottery = $(this).data('flash-claim-type');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'flash_lotteries', 'action' => 'claim','ext' => 'json')); ?>",
				data:{
					flash_lottery_id:idFlashLottery,
					flash_lottery_claim_type:claimTypeFlashLottery,
				},
				beforeSend: function(xhr) {
					xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				},
				success: function(response) {
					if (response.error) {
						toastr.warning(response.error);
						console.log(response.error);
					}
					if (response.success) {
						refreshListFlashLotteries();
						refreshUserNavbar();
						toastr.success(response.message);
						if(response.nb_new_won_flash_lotteries>0){
							$('#flash-lotteries-link').html('My Flash Lotteries <span class="badge">'+response.nb_new_won_flash_lotteries+'</span>');
						}
						else{
							$('#flash-lotteries-link').html('My Flash Lotteries ');
						}
					}
				},
				error: function(e) {
					alert("An error occurred: " + e.responseText);
					console.log(e);
				}
			});
		});
	}
</script>