<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8"><h3 class="title">E-Goods</h3></div>
            <div class="col-md-4 text-right"><?php echo $this->Html->actionIconBtn('fa fa-plus',' Add E-Good','add',array(),'btn-primary'); ?></div>
        </div>
    </div>    
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <?php $colCount = 6?>
            <tr>
                <th width='3%'><?php echo $this->Paginator->sort('id'); ?></th>
                <th width='33%'><?php echo $this->Paginator->sort('title'); ?></th>
                <?php if($this->Session->read('Auth.User.role')=='admin'){?>
                    <th width='15%'><?php echo $this->Paginator->sort('User.first','Added By'); ?></th>
                    <?php $colCount++;?>
                <?php }?>
                <?php if($paymentSupport):?>
                    <th width='8%'><?php echo $this->Paginator->sort('type'); ?></th>
                    <th width='8%'><?php echo $this->Paginator->sort('price'); ?></th>
                    <?php $colCount++;$colCount++;?>
                <?php endif;?>
                <th width='8%'><?php echo $this->Paginator->sort('egood_download_count','# Download'); ?></th>
                <th width='5%'><?php echo $this->Paginator->sort('status'); ?></th>
                <th width='10%'><?php echo $this->Paginator->sort('created', 'Date Added'); ?></th>
                <th width='10%'><?php echo $this->Paginator->sort('modified', 'Date Updated'); ?></th>
                <th width='10%' class='text-center'>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($goods)){?>
                <tr>
                    <td colspan='<?php echo $colCount;?>' class='text-warning'><?php echo __('No record found.')?></td>
                </tr>
            <?php 
                }else{
                    foreach ($goods as $good){
            ?>
                        <tr>
                            <td><?php echo $good['Egood']['id']?></td>
                            <td><?php echo $good['Egood']['title'];?></td>
                            <?php if($this->Session->read('Auth.User.role')=='admin'){?>
                                <td><?php echo $good['User']['first'].' <small>('.$good['User']['email'].')</small>';?></td>
                            <?php }?>
                            <?php if($paymentSupport):?>
                                <td class="text-center"><?php echo $type[$good['Egood']['type']]?></td>
                                <td class="text-right">
                                    <?php 
                                        if($good['Egood']['type']){
                                            echo Configure::read('GtwStripe.currency').' '.$good['Egood']['price'];
                                        }else{
                                            echo __('N/A');
                                        }
                                    ?>
                                </td>
                            <?php endif;?>
                            <td class="text-center"><?php echo $good['Egood']['egood_download_count']?></td>
                            <td><?php echo $status[$good['Egood']['status']]?></td>
                            <td><?php echo $this->Time->format('Y-m-d H:i:s', $good['Egood']['created']); ?></td>
                            <td><?php echo $this->Time->format('Y-m-d H:i:s', $good['Egood']['modified']); ?></td>
                            <td class="text-center actions">
                                <?php 
                                    if($this->Session->read('Auth.User.role')=='admin'){                                        
                                    }
                                    echo $this->Html->actionIcon('fa fa-pencil', 'edit', $good['Egood']['slug']);
                                    echo '&nbsp|&nbsp';
                                    echo $this->Html->link('<i class="fa fa-trash-o"> </i>',array('controller'=>'egoods','action'=>'delete',$good['Egood']['slug']),array('role'=>'button','escape'=>false,'title'=>'Delete this comment'),'Are you sure? You want to delete this e-good.');
                                ?>
                            </td>
                        </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>    
</div>
