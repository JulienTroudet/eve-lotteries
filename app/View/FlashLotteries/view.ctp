<?php echo $this->Html->script('isotope.pkgd.min'); ?>
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

		
		organizeFlashTickets();
		instanciateFlashButtons();
		updateFlashCountDown();
		
	});

	function updateFlashCountDown() {
		countdown.setLabels(
			'ms| sec| min| hr|| wk|| yr',
			'ms| secs| mins| hrs|| wk|| yrs',
			' and ');
		exp_date = "<?php echo $flashLottery['FlashLottery']['expiration_date']; ?>";

		if(moment(exp_date).isAfter()){
			$('.flash-countdown').html("End in "+moment(exp_date).countdown().toString());
		}
		else{
			$('.flash-countdown').html("Lottery Closed");
		}
		setTimeout(updateFlashCountDown, 10 );
	}

	function organizeFlashTickets(){
		$container.isotope({
			itemSelector: '.flash-isotope',
			layoutMode: 'masonry',
			masonry: {
				columnWidth: 80,
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