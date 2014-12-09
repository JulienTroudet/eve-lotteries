<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>
<div>



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

	function instanciateButtons(){
		$('.btn-claim').click(function(){
			var idWithdrawal = $(this).data('award-id');
			var claimType = $(this).data('claim-type');
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
						toastr.success('You have claim '+response.message+' !');
						location.reload(true);
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