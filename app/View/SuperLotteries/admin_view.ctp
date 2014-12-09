<div id="wrapper">
	<?php  echo $this->element('AdminMenu', array());?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="superLotteries view">
				<h2><?php echo __('Super Lottery'); ?></h2>
				<dl>
					<dt><?php echo __('Id'); ?></dt>
					<dd>
						<?php echo h($superLottery['SuperLottery']['id']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Eve Item'); ?></dt>
					<dd>
						<?php echo $this->Html->link($superLottery['EveItem']['name'], array('controller' => 'eve_items', 'action' => 'view', $superLottery['EveItem']['id'])); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Number Items'); ?></dt>
					<dd>
						<?php echo h($superLottery['SuperLottery']['number_items']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Name'); ?></dt>
					<dd>
						<?php echo h($superLottery['SuperLottery']['name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('User'); ?></dt>
					<dd>
						<?php echo $this->Html->link($superLottery['User']['eve_name'], array('controller' => 'users', 'action' => 'view', $superLottery['User']['id'])); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Created'); ?></dt>
					<dd>
						<?php echo h($superLottery['SuperLottery']['created']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Modified'); ?></dt>
					<dd>
						<?php echo h($superLottery['SuperLottery']['modified']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Nb Tickets'); ?></dt>
					<dd>
						<?php echo h($superLottery['SuperLottery']['nb_tickets']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Ticket Value'); ?></dt>
					<dd>
						<?php echo h($superLottery['SuperLottery']['ticket_value']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Lottery Status'); ?></dt>
					<dd>
						<?php echo $this->Html->link($superLottery['LotteryStatus']['name'], array('controller' => 'lottery_statuses', 'action' => 'view', $superLottery['LotteryStatus']['id'])); ?>
						&nbsp;
					</dd>
				</dl>
			</div>
		</div>
	</div>
</div>