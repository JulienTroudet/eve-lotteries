<?php echo $this->element('FlashLotteries/FlashLotteryTickets', array('flashLottery' => $flashLottery)); ?>

<script>
	var $container = $('#flash-tickets-container');
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip()
		organizeFlashTickets();
	});

	function organizeFlashTickets(){
		$container.isotope({
			itemSelector: '.flash-isotope',
			layoutMode: 'masonry',
			masonry: {
				columnWidth: 80,
			}
		});
	}
</script>