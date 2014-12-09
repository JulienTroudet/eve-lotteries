<div id="wrapper" >
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="awards index">
				<h2>Transactions you must complete</h2>


				<div id="list-awards">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Lottery Item</th>
										<th>Claimed as</th>
										<th>Date</th>
										<th>Player</th>
										<th>Actions</th>
										<th>Complete</th>
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
												case 'award_isk':
												echo $claimed_award['Withdrawal']['value'].' <br/>';
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
										<td>
											<?php echo $claimed_award['User']['eve_name']; ?>
											<!--<button type="button" onclick="window.prompt('Copy to clipboard: Ctrl+C, Enter', '<?php echo $claimed_award['User']['eve_name']; ?>');"><?php echo $claimed_award['User']['eve_name']; ?></button>-->
											
										</td>
										<td>
											<?php 
											switch ($claimed_award['Withdrawal']['type']) {
												case 'award_isk':
												?>
												<button class="btn btn-block btn-success" type="button" onclick="CCPEVE.showInfo(1377, <?php echo $claimed_award['User']['eve_id']; ?>)">Show Info <?php echo $claimed_award['User']['eve_name']; ?></button>
												<?php
												break;
												case 'award_item':
												?>
												<button class="btn btn-block btn-warning" type="button" onclick="CCPEVE.buyType(<?php echo $claimed_award['Ticket']['Lottery']['EveItem']['eve_id']; ?>)">Buy <?php echo $claimed_award['Ticket']['Lottery']['name']; ?></button>
												<button class="btn btn-block btn-success" type="button" onclick="CCPEVE.createContract(1, 60003760, <?php echo $claimed_award['Ticket']['Lottery']['EveItem']['eve_id']; ?>)">Create Exchange Contract</button>
												<?php
												break;
											}
											?>

											
											
										</td>
										<td>
											<button class="btn btn-block btn-danger btn-complete" type="button" data-award-id="<?php echo $claimed_award['Withdrawal']['id']; ?>" >Complete this</button>
										</td>
										
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>		

					<div class="row">
						<ul class="pager">
							<li class="previous">
								<?php echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled')); ?>
							</li>
							<li>
								<?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} of {:pages}, showing {:current} awards out of {:count}, starting on award {:start}, ending on {:end}') )); ?>	
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
	</div>
</div>


<script>
	$(document).ready(function() {

		$("[data-toggle='tooltip']").tooltip(); 

		instanciateButtons();

	});



	function refreshListAwards(){
		$.ajax({
			type:"get",
			url:"<?php echo $this->Html->url(array('controller' => 'withdrawals', 'action' => 'list_awards_to_complete', 'admin' => true)); ?>",


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

	function instanciateButtons(){
		$('.btn-complete').click(function(){
			var idWithdrawal = $(this).data('award-id');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'withdrawals', 'action' => 'complete_award', 'admin' => true ,'ext' => 'json')); ?>",

				data:{
					withdrawal_id:idWithdrawal,
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
						toastr.success(response.message);
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