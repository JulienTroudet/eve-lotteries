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
			<div class="users index">
				<h2><?php echo __('Users'); ?></h2>
				<table class="table table-striped table-condensed" id="users-table">
					<thead>
						<tr>
							<th><?php echo __('Nom'); ?></th>
							<th><?php echo __('Groupe'); ?></th>
							<th><?php echo __('Created'); ?></th>
							<th><?php echo __('Sponsor'); ?></th>
							<th><?php echo __('Wallet'); ?></th>
							<th><?php echo __('Points'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($users as $user): ?>
							<tr>
								<td><?php echo h($user['User']['eve_name']); ?>&nbsp;</td>
								<td><?php echo h($user['Group']['name']); ?></td>
								<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
								<td><?php echo h($user['Sponsor']['eve_name']); ?>&nbsp;</td>
								<td><?php echo h($user['User']['wallet']); ?>&nbsp;</td>
								<td><?php echo h($user['User']['tokens']); ?>&nbsp;</td>
								<td class="actions">
									<?php echo $this->Html->link(__('View'), array('action' => 'view', 'admin' => true, $user['User']['id'])); ?>
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', 'admin' => true, $user['User']['id'])); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$( document ).ready(function() {

		var table = $('#users-table').DataTable({
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]});


	});
</script>