<div>

	<?php if(isset($article['Article'])){echo $this->element('Articles/Capo', array("article" => $article));} ?>

</div>

<div id="user-navbar">

	<?php echo $this->element('UserNavbar', array("userGlobal" => $userGlobal)); ?>

</div>

<div class="lotteries index">



	<div class="row">

		<div class="col-md-12 col-sm-12">

			<div class="panel panel-default">

				<div id="collapse-item" class="panel-collapse collapse <?php if (isset($openCreate) && $openCreate == 'open') { echo 'in';} ?>">

					<div class="panel-body">

						<div class="row">

							<div class="col-md-2 cols-sm-12 pull-left">

								<a class="btn btn-warning" data-toggle="collapse" href="#collapse-item">Close</a>

							</div>

							<div class="col-md-8 cols-sm-12 pull-right">

								<form class="form-inline pull-right" role="form">

									<div class="form-group pull-right">

										<label class="sr-only" for="item-search">Search: </label>

										<input type="text" class="form-control" id="item-search" placeholder="Item name" style="margin-left:5px;">

									</div>

									<div class="form-group pull-right">

										<label class="sr-only" for="item-select">Search: </label>

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

												'style'=> 'margin-left:5px;',

												)

											);

											?>

										</div>



									</form>

									<div class="form-group pull-right">

										<button class="btn btn-primary" id="sort-name">Sort by Name</button>

										<button class="btn btn-primary" id="sort-value">Sort by Value</button>

									</div>

								</div>

							</div>

							<div class="row" id="all-items">

								<?php foreach ($eveItems as $eveItem){echo $this->element('ItemPanel', array(

								"eveItem" => $eveItem));} ?>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div id="list-special-lotteries">

			<?php echo $this->element('SpecialLotteries', array("flashLottery" => $flashLottery, "superLottery" => $superLottery,  "userGlobal" => $userGlobal)); ?>

		</div>

		<div id="list-lotteries">

			<div class="row">

				<div class="col-md-3">

					<h2 class="pull-left">Ongoing Lotteries</h2>

				</div>

				<div class="col-md-9">

					<h3 class="pull-right">Total won: <?php echo number_format($totalWon, 2); ?> ISK</h3>

				</div>

			</div>

			<div class="row">

				<?php foreach ($lotteries as $lottery){ echo $this->element('Lotteries/LotteryPanel', array(

				"lottery" => $lottery ));} ?>

			</div>

			<h2>Last won Lotteries</h2>

			<div class="row">

				<?php foreach ($old_lotteries as $lottery){echo $this->element('Lotteries/OldLotteryPanel', array(

				"lottery" => $lottery ));}?>

			</div>

			<div class="row">

				<div class="col-md-12">

					<?php echo $this->Html->link('See all Flash lotteries', array('controller' => 'flash_lotteries', 'action' => 'index'), array('class' => 'btn btn-lg btn-primary') ); ?>

					<?php echo $this->Html->link('See all Super lotteries', array('controller' => 'super_lotteries', 'action' => 'index'), array('class' => 'btn btn-lg btn-primary') ); ?>

					<?php echo $this->Html->link('See more won lotteries', array('controller' => 'lotteries', 'action' => 'old_list'), array('class' => 'btn btn-lg btn-primary') ); ?>

				</div>

			</div>

			<input type="hidden" id="timestamp-lotteries" value="<?php echo $timestamp_lotteries; ?>"/>

		</div>

	</div>

	<div class="modal fade" id="choose-ticket-modal" tabindex="-1" role="dialog" aria-labelledby="choose-ticket-modal-label" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

					<h3 class="modal-title" id="choose-ticket-modal-item-label"></h3>

					<h5 id="choose-ticket-modal-ticket-label"></h5>

					<h5>My Wallet : <span id="wallet-modal"><?php echo number_format($userGlobal['wallet'],2); ?></span> <i class="fa fa-money"></i> </h5>

				</div>

				<div class="modal-body">

					<div class="row" id="choose-ticket-modal-body">

					</div>



				</div>

				<div class="modal-footer">

					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>

					<button type="button" class="btn btn-primary" id="button-buy-list">Buy</button>

				</div>

			</div>

		</div>

	</div>



	<div class="modal fade" id="inactive-modal" tabindex="-1" role="dialog" aria-labelledby="inactive-modal-label" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header">

					<h3 class="modal-title" id="inactive-modal-item-label">EVE-Lotteries is sleeping !</h3>

				</div>

				<div class="modal-body">

					EVE-Lotteries is sleeping !

				</div>

				<div class="modal-footer">

				</div>

			</div>

		</div>

	</div>



	<script>



		var userIsActive = true;

		var idleTime = 0;



		$(document).ready(function() {

			$("[data-toggle='tooltip']").tooltip();

			instanciateButtons();

			instanciateSuperButtons();



			instanciateItemsButtons();

			updateLotteriesCountDown();



			//Increment the idle time counter every minute.

    		var idleInterval = setInterval(timerIncrement, 60000);



			//fonction thas auto refresh the lotteries unless the user is AFK

			(function poll() {

				setTimeout(function() {

					if(userIsActive){

						console.log('refresh');

						refreshListLotteries();

						refreshListSpecialLotteries();

					}

					poll();

				}, 20000);

			})();



			$(this).mousemove(function (e) {

				wakeUp();

			});

			$(this).keypress(function (e) {

				wakeUp();

			});



		});



		function timerIncrement() {

			idleTime = idleTime + 1;

			if (idleTime > 4) {

				putToSleep();

			}

		}



		function putToSleep() {

			userIsActive = false;

			window.scrollTo(0,0);

			$('#inactive-modal').modal('show')

		}



		function wakeUp() {

			if(!userIsActive){

				console.log('refresh');

				refreshListLotteries();

				refreshListSpecialLotteries();

			}

			userIsActive = true;

			idleTime = 0;

			$('#inactive-modal').modal('hide')

		}



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

			timestamp_lotteries = $("#timestamp-lotteries").val();

			$.ajax({

				type:"get",

				data:{

					timestamp:timestamp_lotteries,

				},

				url:"<?php echo $this->Html->url(array('controller' => 'lotteries', 'action' => 'list_lotteries')); ?>",

				beforeSend: function(xhr) {

					xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

				},

				success: function(response) {

					if(response != null && response != ''){

						$('#list-lotteries').html(response);

						instanciateButtons();

						updateLotteriesCountDown();

					}

				},

				error: function(e) {

					//toastr.warning(e.responseText);

					console.log(e);

				}

			});

		}

		function refreshListSpecialLotteries(){

			timestamp_super_lotteries = $("#timestamp-super-lotteries").val();

			timestamp_flash_lotteries = $("#timestamp-flash-lotteries").val();



			$.ajax({

				type:"get",

				data:{

					timestamp:timestamp_super_lotteries,

				},

				url:"<?php echo $this->Html->url(array('controller' => 'super_lotteries', 'action' => 'see_last')); ?>",

				beforeSend: function(xhr) {

					xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

				},

				success: function(response) {

					if(response != null && response != ''){

						$('#last-super-lottery').html(response);

						instanciateButtons();

						instanciateSuperButtons();

					}

				},

				error: function(e) {

					//toastr.warning(e.responseText);

					console.log(e);

				}

			});



			$.ajax({

				type:"get",

				data:{

					timestamp:timestamp_flash_lotteries,

				},

				url:"<?php echo $this->Html->url(array('controller' => 'flash_lotteries', 'action' => 'see_last')); ?>",

				beforeSend: function(xhr) {

					xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

				},

				success: function(response) {

					if(response != null && response != ''){

						$('#last-flash-lottery').html(response);

						instanciateButtons()

					}

				},

				error: function(e) {

					//toastr.warning(e.responseText);

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

					$('#wallet-modal').html($('#wallet').html());

				},

				error: function(e) {

					//toastr.warning(e.responseText);

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

					if(e.status == 403){

						toastr.warning("You must log in to play !");

					}

					console.log(e);

				}

			});

		}

		function instanciateButtons(){

			$('.buy-ticket').off('click');

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



		function instanciateItemsButtons(){

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

						if(e.status == 403){

							toastr.warning("You must log in to play !");

						}

						console.log(e);

					}

				});

			});



			$('.item-choice-button').click(function(){

				<?php if(isset($_SERVER['HTTP_EVE_TRUSTED'])): ?>

				window.scrollTo(0,0);

			<?php endif; ?>



			var itemId = $(this).data('item-id');

			var itemName = $(this).data('item-name');

			var itemNbTickets = $(this).data('item-nbt');

			var ticketPrice = $(this).data('ticket-price');

			var ticketFPrice = number_format(ticketPrice, 0,'.',',');



			var itemPrice = number_format($(this).data('item-price'), 0,'.',',');

			$('#choose-ticket-modal').modal('show');

			$('#choose-ticket-modal-item-label').html(itemName +' : '+itemPrice+' <span class="badge">ISK</span>');

			$('#choose-ticket-modal-ticket-label').html(ticketFPrice+' <i class="fa fa-money"></i> for one <i class="fa fa-ticket"></i> <span class="modal-total-buy"></span>');

			var htmlTickets = "";

			for (var i = 1; i <= itemNbTickets; i++) {

				htmlTickets+= '<div class="col-md-6 col-sm-12"><button class="btn btn-block btn-primary ticket-modal" data-value="'+ticketPrice+'" data-position="'+(i-1)+'">'+i+'. Buy this ticket</button></div>';

			};

			$('#button-buy-list').data('item-id', itemId);

			$('#choose-ticket-modal-body').html(htmlTickets);



			instanciateChoiceButtons();

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



			//orders the item by value when the button is clicked

			$("#sort-value").on('click', function() {

				if($(this).data('order') == 'asc'){

					$(this).data('order', 'desc')

					tinysort('#all-items>.item-panel',{order:'desc',data:'item-price'});

				}

				else{

					$(this).data('order', 'asc')

					tinysort('#all-items>.item-panel',{order:'asc',data:'item-price'});

				}





			});



			//orders the item by name when the button is clicked

			$("#sort-name").on('click', function() {

				if($(this).data('order') == 'asc'){

					$(this).data('order', 'desc')

					tinysort('#all-items>.item-panel',{order:'desc',data:'item-name'});

				}

				else{

					$(this).data('order', 'asc')

					tinysort('#all-items>.item-panel',{order:'asc',data:'item-name'});

				}



			});

		}



		function instanciateChoiceButtons(){

			$('.ticket-modal').click(function(){



				if($(this).hasClass('active')) {

					$(this).removeClass('active');

				}

				else {

					$(this).addClass('active');

				}



				var ticketPrice = $(this).data('value');

				var nbtickets = $('.ticket-modal.active').length;



				if(nbtickets>0){

					$('.modal-total-buy').html('('+number_format(ticketPrice*nbtickets, 0,'.',',')+')');

				}

				else{

					$('.modal-total-buy').html('');

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

							refreshListSpecialLotteries();

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



		function updateLotteriesCountDown() {



			countdown.setLabels(

				'm|s|m|h|d|w|m| year| decade| century| millennium',

				'm|s|m|h|d|w|m| years| decades| centuries| millennia',

				' : ',

				' : ',

				'');





			$( ".lot-timer" ).each(function( index ) {

				var start_date = $(this).data('start');



				$(this).html('Started since '+moment.utc(start_date).countdown().toString());

			});



			setTimeout( updateLotteriesCountDown, 1000 );

		}

	</script>