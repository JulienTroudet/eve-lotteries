<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));} 
	else{echo $this->element('VisitorNavbar', array());}?>
</div>
<div>
	<div id="list-awards">
		<h2>Unclaimed Awards</h2>
		<div class="row">
			<?php foreach ($unclaimed_awards as $unclaimed_award){ echo $this->element('AwardPanel', array("unclaimed_award" => $unclaimed_award ));} ?>
		</div>
		<div class="row">
			<ul class="pager">
				<li class="previous">
					<?php echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled')); ?>
				</li>
				<li>
					<?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} of {:pages}, showing {:current} waiting awards out of {:count}, starting on award {:start}, ending on {:end}') )); ?>	
				</li>
				<li class="next">
					<?php
					echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
					?>
				</li>
			</ul>
		</div>
		<h2>Last Claimed Awards</h2>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Lottery Name</th>
							<th>Claimed as</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($claimed_awards as $claimed_award){?>
						<tr>
							<td>
								<?php echo $claimed_award['Lottery']['name']; ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			
		</div>
		<div class="pull-right">
			<?php echo $this->Html->link('See all my claimed awards', array('controller' => 'withdrawals', 'action' => 'old_list'), array('class' => 'btn btn-lg btn-primary') ); ?>
		</div>
	</div>
</div>




<script>
	$(document).ready(function() {

		$("[data-toggle='tooltip']").tooltip(); 

		instanciateClaimCreditsButtons();
		instanciateClaimISKButtons();
		instanciateClaimItemButtons();

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
				instanciateClaimCreditsButtons();
				instanciateClaimISKButtons();
				instanciateClaimItemButtons();
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

	function instanciateClaimCreditsButtons(){
		$('.btn-claim-credits').click(function(){
			var idTicket = $(this).data('ticket-id');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'withdrawals', 'action' => 'claim_credits','ext' => 'json')); ?>",

				data:{
					ticket_id:idTicket
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
						toastr.success('You have claim '+response.valueCredits+' credits !');
					}
				},
				error: function(e) {
					alert("An error occurred: " + e.responseText);
					console.log(e);
				}
			});
		});
	}

	function instanciateClaimISKButtons(){
		$('.btn-claim-isk').click(function(){
			var idTicket = $(this).data('ticket-id');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'withdrawals', 'action' => 'claim_isk','ext' => 'json')); ?>",

				data:{
					ticket_id:idTicket
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
						toastr.success('You have claim '+response.valueCredits+' ISK !');
					}
				},
				error: function(e) {
					alert("An error occurred: " + e.responseText);
					console.log(e);
				}
			});
		});
	}

	function instanciateClaimItemButtons(){
		$('.btn-claim-item').click(function(){
			var idTicket = $(this).data('ticket-id');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'withdrawals', 'action' => 'claim_item','ext' => 'json')); ?>",

				data:{
					ticket_id:idTicket
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
						toastr.success('You have claim '+response.itemName+' !');
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