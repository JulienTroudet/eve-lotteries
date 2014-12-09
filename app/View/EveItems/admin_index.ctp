<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="eveItems index">
				<h2><?php echo __('Eve Items'); ?></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('eve_id'); ?></th>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('eve_category_id'); ?></th>
							<th><?php echo $this->Paginator->sort('eve_value'); ?></th>
							<th><?php echo $this->Paginator->sort('status'); ?></th>
							<th><?php echo $this->Paginator->sort('nb_tickets_default', 'Nb Tickets'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($eveItems as $eveItem): ?>
							<tr>
								<td><img src="https://image.eveonline.com/Render/<?php echo $eveItem['EveItem']['eve_id']?>_64.png"></td>
								<td><?php echo h($eveItem['EveItem']['name']); ?>&nbsp;</td>
								<td><?php echo h($eveItem['EveCategory']['name']); ?>&nbsp;</td>
								<td><span id="price-<?php echo h($eveItem['EveItem']['id']); ?>"><?php echo number_format($eveItem['EveItem']['eve_value'], 0); ?>&nbsp;</span> <span class="badge">ISK</span></td>
								<td><?php echo h($eveItem['EveItem']['status']); ?>&nbsp;</td>
								<td><?php echo h($eveItem['EveItem']['nb_tickets_default']); ?>&nbsp;</td>
								<td class="actions">
									<button class="btn btn-xs btn-block btn-default update-price" data-item-id="<?php echo h($eveItem['EveItem']['id']); ?>" data-item-name="<?php echo h($eveItem['EveItem']['name']); ?>">Update Price</button>
									<?php echo $this->Html->link(__('View'), array(
										'action' => 'view', 'admin' => true, $eveItem['EveItem']['id']),
									array('class' => 'btn btn-xs btn-primary')
									); ?>
									<?php echo $this->Html->link(__('Edit'), array(
										'action' => 'edit', 'admin' => true, $eveItem['EveItem']['id']),
									array('class' => 'btn btn-xs btn-warning')
									); ?>
									<?php echo $this->Form->postLink(__('Delete'), array(
										'action' => 'delete', 'admin' => true, $eveItem['EveItem']['id']),
									array('class' => 'btn btn-xs btn-danger'), 
									__('Are you sure you want to delete # %s?', $eveItem['EveItem']['id'])); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
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
								'format' => __('Page {:page} of {:pages}, showing {:current} items out of {:count}, starting on item {:start}, ending on {:end}')
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
		</div>
	</div>

	<script>
		$( document ).ready(function() {
			$('.update-price').click(function(){
				var idItem = $(this).data('item-id');
				var itemName = $(this).data('item-name');
				$.ajax({
					type:"get",
					url:"<?php echo $this->Html->url(array('controller' => 'EveItems', 'action' => 'update_prices','ext' => 'json')); ?>",

					data:{
						idItem:idItem
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
							console.log('success');

							$('#price-'+idItem).html(response.itemValue);

							toastr.success('You have updated the value for the '+itemName+' !');

						}
					},
					error: function(e) {
						toastr.warning("An error occurred: " + e.responseText.message);
						console.log(e);
					}
				});
			});
		});
	</script>