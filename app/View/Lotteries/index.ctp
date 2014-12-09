<div id="user-navbar">
	<?php echo $this->element('UserNavbar', array("userGlobal" => $userGlobal)); ?>
</div>
<div class="lotteries index">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="panel panel-default">
				<div id="collapse-item" class="panel-collapse collapse <?php if (isset($openCreate)) { echo 'in';} ?>">
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
								<?php foreach ($eveItems as $eveItem){echo $this->element('ItemPanel', array(
								"eveItem" => $eveItem));} ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="list-lotteries">
			<?php if (isset($superLottery)){ echo $this->element('SuperLotteries/SuperLotteryPanel', array("superLottery" => $superLottery, "userGlobal" => $userGlobal));} ?>
			<div class="row">
				<div class="col-md-3">
					<h2 class="pull-left">Ongoing Lotteries</h2>
				</div>
				<div class="col-md-9">
					<h3 class="pull-right">Total won : <?php echo number_format($totalWon, 2); ?> ISK</h3>
				</div>
			</div>
			<div class="row">
				<?php foreach ($lotteries as $lottery){ echo $this->element('Lotteries/LotteryPanel', array(
				"lottery" => $lottery ));} ?>
			</div>
			<h2>Last won lotteries</h2>
			<div class="row">
				<?php foreach ($old_lotteries as $lottery){echo $this->element('Lotteries/OldLotteryPanel', array(
				"lottery" => $lottery ));}?>
			</div>
			<div class="row">
				<div class="col-md-3 pull-right">
					<?php echo $this->Html->link('See all super lotteries', array('controller' => 'super_lotteries', 'action' => 'index'), array('class' => 'btn btn-lg btn-block btn-primary') ); ?>
					<?php echo $this->Html->link('See more won lotteries', array('controller' => 'lotteries', 'action' => 'old_list'), array('class' => 'btn btn-lg btn-block btn-primary') ); ?>
				</div>
			</div>

		</div>
	</div>

	<div class="modal fade" id="choose-ticket-modal" tabindex="-1" role="dialog" aria-labelledby="choose-ticket-modal-label" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="choose-ticket-modal-label"></h4>
				</div>
				<div class="modal-body">
					<div class="row" id="choose-ticket-modal-body">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="button-buy-list">Buy</button>
					</div>
				</div>
			</div>
		</div>
	</div>




	<script>
		$(document).ready(function() {

			$("[data-toggle='tooltip']").tooltip(); 

			instanciateButtons();

			$('.item-random-button').click(function(){
				var itemId = $(this).data('item-id');
				$.ajax({
					type:"get",
					url:"<?php echo $this->Html->url(array('controller' => 'tickets', 'action' => 'buy_firsts','ext' => 'json')); ?>",
					dataType: 'text json',
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
							toastr.success('You have bought a ticket for the '+response.itemName+' and created a new lottery !');
							refreshListLotteries();
							refreshUserNavbar();
						}
					},
					error: function(e) {
						toastr.warning(e.responseText);
						console.log(e);
					}
				});
			});



			$('.item-choice-button').click(function(){

				<?php if(isset($_SERVER['HTTP_EVE_TRUSTED'])) { ?>
					window.scrollTo(0,0);
					<?php } ?>

					var itemId = $(this).data('item-id');
					var itemName = $(this).data('item-name');
					var itemNbTickets = $(this).data('item-nbt');
					var itemPrice = number_format($(this).data('item-price'), 0,'.',',');

					$('#choose-ticket-modal').modal('show');



					$('#choose-ticket-modal-label').html(itemName +'&nbsp;&nbsp;&nbsp;'+itemPrice+' <i class="fa fa-money"></i> for one <i class="fa fa-ticket"></i>');
					var htmlTickets = "";
					for (var i = 1; i <= itemNbTickets; i++) {
						htmlTickets+= '<div class="col-md-6 col-sm-12"><button class="btn btn-block btn-primary ticket-modal" data-toggle="button" data-position="'+(i-1)+'">'+i+'. Buy this ticket</button></div>';
					};
					$('#button-buy-list').data('item-id', itemId);
					$('#choose-ticket-modal-body').html(htmlTickets);
				});

			$('#button-buy-list').click(function(){
				var itemId = $(this).data('item-id');

				var choosenTickets = $('.ticket-modal.active');
				var listPos = [];
				for (var i = 0; i < choosenTickets.length; i++) {
					listPos.push($(choosenTickets[i]).data('position'));
				};

				buyListTickets(itemId, listPos)

				$('#choose-ticket-modal').modal('hide');
			});



			$("#item-search").on('change keyup paste mouseup', function() {
				filterItems();
			});

			$("#item-filter").on('change', function() {
				filterItems();
			});


			// (function poll() {
			// 	setTimeout(function() {
			// 		$.ajax({
			// 			type:"get",
			// 			url:"<?php echo $this->Html->url(array('controller' => 'lotteries', 'action' => 'list_lotteries')); ?>",


			// 			beforeSend: function(xhr) {
			// 				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			// 			},
			// 			success: function(response) {
			// 				$('#list-lotteries').html(response);
			// 				instanciateButtons();
			// 				poll();
			// 			},
			// 			error: function(e) {
			// 				alert("An error occurred: " + e.responseText);
			// 				console.log(e);
			// 			}
			// 		});
			// 	}, 3000);
			// })();

});


function filterItems(){
	lastValue = $("#item-search").val();
	var notcorres = $('.item-panel').filter(function() { 
		var b1 =  $(this).data("item-category") != ($('#item-filter').val()); 
		var b2 =  $(this).data("item-name").toLowerCase().indexOf($('#item-search').val().toLowerCase()) == -1; 
		if (!$('#item-filter').val()){
			b1 = false;
		}
		return (b1 || b2);
	});

	var corres = $('.item-panel').filter(function() { 
		var b1 =  $(this).data("item-category") == ($('#item-filter').val()); 
		var b2 =  $(this).data("item-name").toLowerCase().indexOf($('#item-search').val().toLowerCase()) != -1; 
		if (!$('#item-filter').val()){
			b1 = true;
		}
		return (b1 && b2);
	});

	$(notcorres).hide();
	$(corres).show();
}

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

function buyListTickets(itemId, listPos){
	$.ajax({
		type:"get",
		url:"<?php echo $this->Html->url(array('controller' => 'tickets', 'action' => 'buy_firsts','ext' => 'json')); ?>",

		data:{
			item_id:itemId,
			list_positions:listPos
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
				toastr.success('You have bought '+listPos.length+' tickets for the '+response.itemName+' and created a new lottery !');
				refreshListLotteries();
				refreshUserNavbar();
			}
		},
		error: function(e) {
			toastr.warning(e.responseText);
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
					refreshListLotteries();
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
</script>