<div id="user-navbar">
    <?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="articles form">
            <?php echo $this->Form->create('Transaction', array('action' => 'add', 'admin' => true)); ?>
            <fieldset>
                <legend><?php echo __('Add Transaction'); ?></legend>
                <?php
                echo $this->Form->input('walletLine', array(
                    'div' => array(
                        'class' => 'form-group'
                    ),
                    'class' => 'form-control',
                    'type' => "text",
                    'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-danger'))
                ));


                ?>

            </fieldset>
            <?php
            $optionsFormLogin = array(
                'label' => 'Submit',
                'div' => false,
                'class' => 'btn btn-block btn-primary'
            );
            echo $this->Form->end($optionsFormLogin); ?>
        </div>
        <div class="transactions index">
            <h2><?php echo __('API Waiting Transactions'); ?></h2>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('amount'); ?></th>
                    <th><?php echo $this->Paginator->sort('user_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('eve_date'); ?></th>
                    <th><?php echo $this->Paginator->sort('refid'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <?php if($transaction['Transaction']['refid'] == "waiting"): ?>
                        <tr class="warning">
                    <?php elseif($transaction['Transaction']['amount']<0): ?>
                        <tr class="danger">
                    <?php else: ?>
                        <tr>
                    <?php endif; ?>

                    <td><?php echo number_format($transaction['Transaction']['amount'], 2); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($transaction['User']['eve_name'], array('controller' => 'users', 'action' => 'view', $transaction['User']['id'])); ?>
                    </td>
                    <td><?php echo h($transaction['Transaction']['eve_date']); ?>&nbsp;</td>
                    <td><?php echo h($transaction['Transaction']['refid']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php if($transaction['Transaction']['refid'] == "waiting"): ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', 'admin' => true, $transaction['Transaction']['id']), array(), __('Are you sure you want to delete # %s? This will remove ISK from the player.', $transaction['Transaction']['id'])); ?>
                        <?php endif; ?>
                    </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-12">
                    <ul class="pager">
                        <li class="previous">
                            <?php echo $this->Paginator->prev('Previous', array(), null, array('class' => 'prev disabled')); ?>
                        </li>
                        <li>
                            <?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>
                        </li>
                        <li class="next">
                            <?php echo $this->Paginator->next('Next', array(), null, array('class' => 'next disabled')); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>