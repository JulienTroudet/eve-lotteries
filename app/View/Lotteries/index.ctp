<div class="lotteries index">
	<h2><?php echo __('Lotteries'); ?></h2>

	<div class="row">
		<div class="panel panel-default col-md-12 col-sm-12">
			<div id="collapse-item" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-2 cols-sm-12 pull-left">
							<a class="btn btn-warning" data-toggle="collapse" href="#collapse-item">Close</a>
						</div>
						<div class="col-md-8 cols-sm-12 pull-right">
							<form class="form-inline pull-right" role="form">
								<div class="form-group pull-right">
									<label class="sr-only" for="item-search">Search : </label>
									<input type="text" class="form-control" id="item-search" placeholder="Item name" style="margin-left:5px;">
								</div>
								<div class="form-group pull-right">
									<label class="sr-only" for="item-select">Search : </label>

									<?php 

									echo $this->Form->select(
										'field',
										$eveCategories,
										array(
											'div' => array(
												'class' => 'form-group'
												),
											'class' => 'form-control',
											'id' => 'item-filter',
											'label' => 'Item Category',
											'placeholder' => 'Item Category',
											)
										);
										?>



									</div>
								</form>
							</div>
						</div>
						<div class="row">
							<?php 
							foreach ($eveItems as $eveItem){

								echo $this->element('ItemPanel', array(
									"eveItem" => $eveItem
									));}
									?>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div id="list-lotteries">
					<div class="row">
						<?php 
						foreach ($lotteries as $lottery){

							echo $this->element('LotteryPanel', array(
								"lottery" => $lottery
								));}
								?>
							</div>


							<div class="row">
								<ul class="pager">
									<li class="previous">
										<?php
										echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
										?>
									</li>
									<li>
										<?php
										echo $this->Paginator->counter(array(
											'format' => __('Page {:page} of {:pages}, showing {:current} lotteries out of {:count}, starting on lottery {:start}, ending on {:end}')
											));
											?>	
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
						<script>
	$(document).ready(function() {

		instanciateButtons();

		$('.item-button').click(function(){
			var itemId = $(this).data('item-id');
			$.ajax({
				type:"get",
				url:"<?php echo $this->Html->url(array('controller' => 'lotteries', 'action' => 'add','ext' => 'json')); ?>",

				data:{
					item_id:itemId
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
						$('#wallet').html(response.buyerWallet);
						toastr.success('You have bought a ticket for the '+response.itemName+' and created a new lottery !');
						refreshListLotteries()
					}
				},
				error: function(e) {
					alert("An error occurred: " + e.responseText.message);
					console.log(e);
				}
			});
		});




		var lastValue = '';

		$("#item-search").on('change keyup paste mouseup', function() {
			if ($(this).val() != lastValue) {
				lastValue = $(this).val();
				var notcorres = $('.item-panel').filter(function() { 
					return $(this).data("item-name").toLowerCase().indexOf($('#item-search').val().toLowerCase()) == -1; 
				});

				var corres = $('.item-panel').filter(function() { 
					return $(this).data("item-name").toLowerCase().indexOf($('#item-search').val().toLowerCase()) != -1; 
				});

				$(notcorres).hide();
				$(corres).show();
			}
		});

		$("#item-filter").on('change', function() {
			var notcorres = $('.item-panel').filter(function() { 
				return $(this).data("item-category") != ($('#item-filter').val()); 
			});

			var corres = $('.item-panel').filter(function() { 
				return $(this).data("item-category") == ($('#item-filter').val()); 
			});

			$(notcorres).hide();
			$(corres).show();
		});

	});

	function refreshListLotteries(){
		$.ajax({
			type:"get",
			url:"<?php echo $this->Html->url(array('controller' => 'lotteries', 'action' => 'list_lotteries')); ?>",


			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				$('#list-lotteries').html(response);
				instanciateButtons()
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText.message);
				console.log(e);
			}
		});
	}

	function instanciateButtons(){
		$('.buy-ticket').click(function(){
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
						$('#wallet').html(response.buyerWallet);
						refreshListLotteries();
						toastr.success('You have bought a ticket for the '+itemName+' !');
					}
				},
				error: function(e) {
					alert("An error occurred: " + e.responseText.message);
					console.log(e);
				}
			});
		});
	}
	</script>