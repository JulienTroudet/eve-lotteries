<?php if(!isset($userGlobal) || $userGlobal['nb_unread_news']>=1):?>
	<div class="alert alert-info alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		
		<div class="row">
			<div class="col-md-9 col-sm-12">
			<strong><?php echo $article['Article']['title']?>:</strong> <?php echo $article['Article']['lead']?>
			</div>
		</div>
		<div class="row">
			<div class="pull-right">

					<?php
					$label = 'Read more';

					echo $this->Html->link(
						$label, 
						array('controller' => 'articles', 'action' => 'index'),
						array(
							'class' => 'btn btn-primary')
						);
						?>

						<?php  if(isset($userGlobal)){
							$label = 'Close this';

							echo $this->Html->link(
								$label, 
								array('controller' => 'articles', 'action' => 'read_all'),
								array(
									'class' => 'btn btn-warning')
								);
						}
						?>
						&nbsp;

				</div>
			</div>
		</div>






		<script> 

			$(document).ready(function() {
				function CountDownTimer(dt, div_class)
				{	
					console.log(dt);
					var end = new Date(dt);
					console.log(end);
					var _second = 1000;
					var _minute = _second * 60;
					var _hour = _minute * 60;
					var _day = _hour * 24;
					var timer;

					function showRemaining() {
						var now = new Date();
						var distance = new Date(end - now);
						if (distance < 0) {

							clearInterval(timer);
							$('.'+div_class).html('any minute!');

							return;
						}
						var days = Math.floor(distance / _day);
						var hours = Math.floor((distance % _day) / _hour);
						var minutes = Math.floor((distance % _hour) / _minute);
						var seconds = Math.floor((distance % _minute) / _second);

						$('.'+div_class).html( minutes + ' minutes '+ seconds + ' seconds');
					}

					timer = setInterval(showRemaining, 1000);
				}

				CountDownTimer('<?php echo $apiCheckTime; ?>', 'countdown');

				$('#button-deposit').click(function(){

					window.scrollTo(0,0);


					$('#deposit-modal').modal('show');

				});
			});


</script>

<?php endif;?>