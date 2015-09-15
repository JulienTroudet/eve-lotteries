<div id="user-navbar">
	<?php echo $this->element('UserNavbar'); ?>
</div>
<div class="super_lotteries view">
	<div id="super-lottery">
		<?php echo $this->element('SuperLotteries/SuperLotteryTickets', array('superLottery' => $superLottery)); ?>
	</div>
</div>



<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip()


		instanciateSuperButtons();

        var server_date = moment.utc("<?php echo date("c") ?>");
		updateSuperCountDown(server_date);

	});

	function updateSuperCountDown(server_date) {
		countdown.setLabels(
			'ms| sec| min| hr|| wk|| yr',
			'ms| secs| mins| hrs|| wk|| yrs',
			' and ');

        var server_date_super = moment(server_date);

		var exp_date = "<?php echo $superLottery['SuperLottery']['expiration_date']; ?>";

		if(moment.utc(exp_date).isAfter()){
            server_date_super.add(1, 'seconds');
			$('.super-countdown').html("Ends in "+moment.utc(exp_date).countdown(server_date_super).toString());
		}
		else{
            server_date_super.add(1, 'seconds');
			$('.super-countdown').html("Lottery Closed");
		}
        setTimeout(function () {updateSuperCountDown(server_date_super)}, 1000 );
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
				toastr.warning(e.responseText);
				console.log(e);
			}
		});
	}



	function instanciateSuperButtons(){
		$('.buy-super-ticket').click(function(){
			var idSuper = $(this).data('id-super');
			var nbTickets = $(this).data('nb-ticket');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'super_lottery_tickets', 'action' => 'buy', 'ext' => 'json')); ?>",
				data:{
					id_super:idSuper,
					nb_tickets:nbTickets
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
						refreshUserNavbar();
						refreshSuperLottery();
						toastr.success('You have bought '+nbTickets+' ticket for the Super Lottery !');
					}
				},
				error: function(e) {
					toastr.warning(e.responseText);
					console.log(e);
				}
			});
		});
	}

	function refreshSuperLottery(){
		$.ajax({
			type:"get",
			url:"<?php echo $this->Html->url(array('controller' => 'super_lotteries', 'action' => 'list_tickets', $superLottery['SuperLottery']['id']))?>",
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				$('.super_lotteries').html(response);
				instanciateSuperButtons();
				updateSuperCountDown();
			},
			error: function(e) {
				toastr.warning(e.responseText);
				console.log(e);
			}
		});
	}
</script>