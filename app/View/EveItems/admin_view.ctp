<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="eveItems view">
				<h2><?php echo __('Eve Item'); ?></h2>
				<img src="<?php echo $eveItem['EveCategory']['url_start'].$eveItem['EveItem']['eve_id']?>_64.png">
				<dl>
					<dt><?php echo __('Id'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['id']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Eve Id'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['eve_id']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Name'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Eve Category'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveCategory']['name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Eve Value'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['eve_value']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Status'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['status']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Nb Tickets Default'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['nb_tickets_default']); ?>
						&nbsp;
					</dd>
				</dl>
			</div>
			<div class="actions">
				<h3><?php echo __('Actions'); ?></h3>
				<ul>
					<li><?php echo $this->Html->link(__('Edit Eve Item'), array('action' => 'edit', 'admin' => true, $eveItem['EveItem']['id'])); ?> </li>
					<li><?php echo $this->Form->postLink(__('Delete Eve Item'), array('action' => 'delete', 'admin' => true, $eveItem['EveItem']['id']), array(), __('Are you sure you want to delete # %s?', $eveItem['EveItem']['id'])); ?> </li>
				</ul>
			</div>
			
		</div>
	</div>
</div>

