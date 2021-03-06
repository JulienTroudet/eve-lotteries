<div id="user-navbar">
	<?php echo $this->element('UserNavbar'); ?>
</div>
<div class="flash_lotteries view">
	<div id="list-lotteries">
		<?php echo $this->element('FlashLotteries/FlashLotteryTickets', array('flashLottery' => $flashLottery)); ?>
	</div>
</div>


<script>
	var $container = $('#flash-tickets-container');
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip()



		instanciateFlashButtons();

        var server_date = moment.utc("<?php echo date("c") ?>");

        updateFlashCountDown(server_date);
		
	});

	function updateFlashCountDown(server_date) {

        var server_date_flash = moment(server_date);

		countdown.setLabels(
			'ms| sec| min| hr|| wk|| yr',
			'ms| secs| mins| hrs|| wk|| yrs',
			' and ');
		var exp_date = "<?php echo $flashLottery['FlashLottery']['expiration_date']; ?>";

		if(moment.utc(exp_date).isAfter(server_date_flash)){
            server_date_flash.add(1, 'seconds');
			$('.flash-countdown').html("Ends in "+moment.utc(exp_date).countdown(server_date_flash).toString());
		}
		else{
            server_date_flash.add(1, 'seconds');
			$('.flash-countdown').html("Lottery Closed");
		}
        setTimeout(function () {updateFlashCountDown(server_date_flash)}, 1000 );
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

	

	function instanciateFlashButtons(){
		$('.buy-flash').click(function(){
			var idTicket = $(this).data('id');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'flash_tickets', 'action' => 'buy','ext' => 'json')); ?>",
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
						refreshFlashLottery();
						refreshUserNavbar();
						toastr.success('You have bought a ticket for the flash lottery !');
					}
				},
				error: function(e) {
					toastr.warning(e.responseText);
					console.log(e);
				}
			});
		});
	}

	function refreshFlashLottery(){
		$.ajax({
			type:"get",
			url:"<?php echo $this->Html->url(array('controller' => 'flash_lotteries', 'action' => 'list_tickets', $flashLottery['FlashLottery']['id']))?>",
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				$('.flash_lotteries').html(response);
				instanciateFlashButtons();
				updateFlashCountDown();
				organizeFlashTickets();
			},
			error: function(e) {
				toastr.warning(e.responseText);
				console.log(e);
			}
		});
	}
</script>