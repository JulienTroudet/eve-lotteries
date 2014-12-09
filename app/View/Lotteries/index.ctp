<div class="lotteries index">
	<h2><?php echo __('Lotteries'); ?></h2>

	<div class="row">
		<?php foreach ($lotteries as $lottery){
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

			<script>
				$( document ).ready(function() {
					$('.buy-ticket').click(function(){
						var idTicket = $(this).data('ticket-id');
						var itemName = $(this).data('item-name');
						bootbox.confirm("Buy a ticket for the "+itemName+" ?", function(result) {
							if(result){
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
											bootbox.alert(response.error);
											console.log(response.error);
										}
										if (response.success) {

											var contentHtml = '<div class="media well well-sm" ><span class="pull-left"><img src="https://image.eveonline.com/Character/'+response.buyerEveId+'_64.jpg" /></span><span>'+response.buyerName+'</span></div>';
											console.log($('#ticket-'+idTicket));
											$('#ticket-'+idTicket).html(contentHtml);
										}
									},
									error: function(e) {
										alert("An error occurred: " + e.responseText.message);
										console.log(e);
									}
								});
							}
						});
});
});
</script>