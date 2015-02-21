<?php echo $this->Html->css('dataTables.bootstrap'); ?>
<?php echo $this->Html->script('jquery.dataTables.min');?>
<?php echo $this->Html->script('dataTables.bootstrap');?>

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
				<div><button id="update-all" class="btn btn-large btn-block btn-default"><?php echo __('Update All Visible Items Price'); ?></button></div>
				<table id='items' class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>Eve ID</th>
							<th>Name</th>
							<th class="filter" data-col-i="2"><?php echo __('Category'); ?></th>
							<th><?php echo __('Value'); ?></th>
							<th class="filter" data-col-i="4"><?php echo __('Status'); ?></th>
							<th class="filter" data-col-i="5"><?php echo __('Tickets'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($eveItems as $eveItem): ?>
							<tr>
								<td><img src="<?php echo $eveItem['EveCategory']['url_start'].$eveItem['EveItem']['eve_id']?>_64.png"></td>
								<td><?php echo $this->Html->link(h($eveItem['EveItem']['name']), array(
									'action' => 'view', 'admin' => true, $eveItem['EveItem']['id']),
								array()
								); ?>&nbsp;</td>
								<td><?php echo h($eveItem['EveCategory']['name']); ?>&nbsp;</td>
								<td><span id="price-<?php echo h($eveItem['EveItem']['id']); ?>"><?php echo number_format($eveItem['EveItem']['eve_value'], 0); ?></span></td>
								<td><?php echo h($eveItem['EveItem']['status']); ?>&nbsp;</td>
								<td><?php echo h($eveItem['EveItem']['nb_tickets_default']); ?>&nbsp;</td>
								<td class="actions">
									<button class="btn btn-xs btn-block btn-default update-price" data-item-id="<?php echo h($eveItem['EveItem']['id']); ?>" data-item-name="<?php echo h($eveItem['EveItem']['name']); ?>">Update Price</button>
									<br/>
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
			</div>
		</div>
	</div>

	<script>
		$( document ).ready(function() {


			$('#update-all').click(function(){
				$('.update-price').trigger( "click" );
			});

			var table = $('#items').DataTable({
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"drawCallback": function( settings ) {
					$( ".update-price").unbind( "click" );
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

									$('#price-'+idItem).html(response.itemValue);

									toastr.success('You have updated the value for the '+itemName+' !');

								}
								else{
									toastr.warning('Cannot update the '+itemName+' !');
								}
							},
							error: function(e) {
								toastr.warning("An error occurred: " + e.responseText.message);
								console.log(e);
							}
						});
					});
				}
			});

$("#items thead th.filter").each( function ( i ) {
	i = $(this).data('col-i');
	var select = $('<select><option value=""></option></select>')
	.prependTo( $(this).empty() )
	.on( 'change', function () {
		var val = $(this).val();

		table.column( i )
		.search( val ? '^'+$(this).val()+'$' : val, true, false )
		.draw();
	} );

	table.column( i ).data().unique().sort().each( function ( d, j ) {
		select.append( '<option value="'+d+'">'+d+'</option>' )
	} );
} );


});
</script>