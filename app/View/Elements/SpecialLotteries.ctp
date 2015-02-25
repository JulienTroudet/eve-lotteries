<?php if (!empty($superLottery) && !empty($flashLottery)): ?>
	<div id="carousel-special-lotteries" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<?php echo $this->element('FlashLotteries/FlashLotteryPanel', array("flashLottery" => $flashLottery, "userGlobal" => $userGlobal)); ?>
			</div>
			<div class="item">
				<?php echo $this->element('SuperLotteries/SuperLotteryPanel', array("superLottery" => $superLottery, "userGlobal" => $userGlobal)); ?>
			</div>
		</div>
		<a class="left carousel-control" href="#carousel-special-lotteries" role="button" data-slide="prev">
			<i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-special-lotteries" role="button" data-slide="next">
			<i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i>
			<span class="sr-only">Next</span>
		</a>
	</div>
<?php else: ?>
	<?php if (!empty($superLottery)){ echo $this->element('SuperLotteries/SuperLotteryPanel', array("superLottery" => $superLottery, "userGlobal" => $userGlobal));} ?>
	<?php if (!empty($flashLottery)){ echo $this->element('FlashLotteries/FlashLotteryPanel', array("flashLottery" => $flashLottery, "userGlobal" => $userGlobal));} ?>
<?php endif; ?>

<script>
	$(document).ready(function() {
		$('.carousel').carousel({
			interval: false
		});

		var $container = $('#flash-tickets-container');

		$container.isotope({
			itemSelector: '.flash-ticket',
			layoutMode: 'fitRows'
		});


	});

	function instanciateButtons(){
		$('.buy-flash').click(function(){
			var idTicket = $(this).data('ticket-id');
			var itemName = $(this).data('item-name');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'tickets', 'action' => 'buy','ext' => 'json')); ?>",
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
						toastr.success('You have bought a ticket for the '+itemName+' !');
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
			url:"<?php echo $this->Html->url(array('controller' => 'flash_lotteries', 'action' => 'visible_flash_lottery')); ?>",
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				$('#flash-lot').html(response);
				instanciateButtons()
			},
			error: function(e) {
				toastr.warning(e.responseText);
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
			toastr.warning(e.responseText);
			console.log(e);
		}
	});
}
</script>