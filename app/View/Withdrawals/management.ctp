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
                            <div class="btn-group-vertical btn-block" role="group" aria-label="...">
                                <?php echo $this->Html->link(
                                    'Book a claim',
                                    array('controller' => 'Withdrawals', 'action' => 'reserve_one', 'admin'=>false, 'plugin' => false),
                                    array('class' => 'btn btn-group btn-lg btn-primary')
                                );?>
                                <?php echo $this->Html->link(
                                    'Cancel booking',
                                    array('controller' => 'Withdrawals', 'action' => 'cancel_reservation', 'admin'=>false, 'plugin' => false),
                                    array('class' => 'btn btn-group btn-xs btn-danger ')
                                );?>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            <?php if(!empty($reserved_award)): ?>
                            You have 10 minutes to complete this
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <div>
                                <?php
                                echo $this->Form->create(
                                    'Withdrawal',
                                    array(
                                        'url' => array(
                                            'controller' => 'Withdrawals',
                                            'action' => 'complete'
                                        ),
                                        'class' => 'row',
                                        'role' => 'form'
                                    ));
                                ?>
                                <div class="col-md-10 col-xs-12">
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
                                    <?php
                                    $optionsFormLogin = array(
                                        'label' => 'Complete',
                                        'div' => false,
                                        'class' => 'btn btn-success'
                                    );
                                    echo $this->Form->end($optionsFormLogin);
                                    ?>

                                </div>
                            </div>
                            <div>
                                <?php if(!empty($reserved_award)): ?>
                                <div class="row">
                                    <div class="col-md-1 col-xs-12">
                                        <img src="https://image.eveonline.com/Character/<?php echo $reserved_award['User']['id']; ?>_32.jpg">
                                    </div>
                                    <div class="col-md-3 col-xs-12">
                                        <?php echo $reserved_award['User']['eve_name']; ?>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <?php
                                        switch ($reserved_award['Withdrawal']['type']) {
                                            case 'award_isk':
                                                echo number_format($reserved_award['Withdrawal']['value'], 2).' ISK <br/>';
                                                echo $reserved_award['Withdrawal']['value'];
                                                break;
                                            case 'award_item':
                                                echo $reserved_award['Ticket']['Lottery']['name'];
                                                ?>
                                                <?php echo $reserved_award['Ticket']['Lottery']['name']; ?>
                                                <button class="btn btn-block btn-xs btn-warning" type="button" onclick="CCPEVE.buyType(<?php echo $reserved_award['Ticket']['Lottery']['EveItem']['eve_id']; ?>)">
                                                    Market Access
                                                </button>
                                                <?php
                                                break;
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-2 col-xs-12">

                                        <button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.showInfo(1377, <?php echo $reserved_award['User']['id']; ?>)">
                                           In game profile
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>

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
                                                echo 'ISK';
                                                break;
                                            case 'award_item':
                                                echo 'Item';
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