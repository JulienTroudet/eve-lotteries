<div id="user-navbar">
    <?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="awards index">
            <h2>Withdrawals to complete</h2>
            <div id="list-awards">
                <div class="well">
                    <div class="row">
                        <div class="col-md-2 col-xs-12">
                            <?php echo $this->Html->link(
                                'Reserve',
                                array('controller' => 'Withdrawals', 'action' => 'management', 'admin'=>false, 'plugin' => false, 'reserve_one' => true),
                                array('class' => 'btn btn-primary btn-lg btn-block')
                            );?>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            You have 10 minutes to complete this
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <?php
                            echo $this->Form->input(
                                'ingame_confirmation',
                                array(
                                    'div' => array(
                                        'class' => 'form-group'
                                    ),
                                    'placeholder' => false,
                                    'label' => false,
                                    'class' => 'form-control',
                                )
                            );?>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            <?php echo $this->Html->link(
                                'Complete',
                                array('controller' => 'Withdrawals', 'action' => 'complete', 'admin'=>false, 'plugin' => false),
                                array('class' => 'btn btn-success btn-lg btn-block')
                            );?>
                        </div>
                        <?php if(isset($reserved_award)): ?>
                            <?php
                            switch ($claimed_award['Withdrawal']['type']) {
                                case 'award_isk':
                                    ?>
                                    <button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.showInfo(1377, <?php echo $claimed_award['User']['id']; ?>)"><?php echo $claimed_award['User']['eve_name']; ?></button>
                                    <?php
                                    break;
                                case 'award_item':
                                    ?>
                                    <button class="btn btn-block btn-xs btn-warning" type="button" onclick="CCPEVE.buyType(<?php echo $claimed_award['Ticket']['Lottery']['EveItem']['eve_id']; ?>)">Buy <?php echo $claimed_award['Ticket']['Lottery']['name']; ?></button>
                                    <button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.createContract(1, 60003760, <?php echo $claimed_award['Ticket']['Lottery']['EveItem']['eve_id']; ?>)">Create Exchange Contract</button>
                                    <?php
                                    break;
                            }
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-sm-12 col-md-offset-1">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Player</th>
                                <th>Claimed as</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($claimed_awards as $claimed_award){?>
                                <tr>
                                    <td><img src="https://image.eveonline.com/Character/<?php echo $claimed_award['User']['id']; ?>_32.jpg"></td>
                                    <td>
                                        <?php echo $claimed_award['User']['eve_name']; ?>
                                    </td>

                                    <td>
                                        <?php
                                        switch ($claimed_award['Withdrawal']['type']) {
                                            case 'award_isk':
                                                echo number_format($claimed_award['Withdrawal']['value'], 2).' ISK';
                                                break;
                                            case 'award_item':
                                                echo $claimed_award['Ticket']['Lottery']['name'];
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $claimed_award['Withdrawal']['modified']; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <ul class="pager">
                        <li class="previous">
                            <?php echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled')); ?>
                        </li>
                        <li>
                            <?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} of {:pages}, showing {:current} awards out of {:count}, starting on award {:start}, ending on {:end}') )); ?>
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