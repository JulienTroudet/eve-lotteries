<div id="wrapper" >
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('ManagerMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="awards index">
				<h2>Transactions you must complete</h2>


				<div id="list-awards">
					<?php echo $this->element('Withdrawals/list_awards_admin', array("claimed_awards" => $claimed_awards)); ?>
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
		$('.btn-reserve').click(function(){
			var idWithdrawal = $(this).data('award-id-group');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'withdrawals', 'action' => 'reserve_award', 'admin' => true ,'ext' => 'json')); ?>",

				data:{
					withdrawal_group_id:idWithdrawal,
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

		$('.btn-complete').click(function(){
			var idWithdrawal = $(this).data('award-id-group');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'withdrawals', 'action' => 'complete_award', 'admin' => true ,'ext' => 'json')); ?>",

				data:{
					withdrawal_group_id:idWithdrawal,
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