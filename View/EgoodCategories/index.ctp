<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
?>
<div class="gtwServices">
    <div class="pull-right">
        <?php echo $this->Html->actionIconBtn('fa fa-plus',' '.__('New Category'),'add',array(),'btn-primary'); ?>
    </div>
    <h1><?php echo __('Egood Category')?></h1>
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th width='2%'><?php echo $this->Paginator->sort('id'); ?></th>
                <th width='25%'><?php echo $this->Paginator->sort('name'); ?></th>
                <th width='10%'><?php echo $this->Paginator->sort('egood_count',__('# Egoods')); ?></th>
                <th width='12%'><?php echo $this->Paginator->sort('created', 'Added On'); ?></th>
                <th width='12%'><?php echo $this->Paginator->sort('modified', 'Date Updated'); ?></th>
                <th width='10%' class='text-center'><?php echo __('Action')?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($egoodCategories)){?>
                <tr>
                    <td colspan='7' class='text-warning'><?php echo __('No record found.')?></td>
                </tr>
            <?php 
                }else{
                    foreach ($egoodCategories as $egoodCategory){                            
            ?>
                        <tr>
                            <td><?php echo $egoodCategory['EgoodCategory']['id']?></td>
                            <td><?php echo $egoodCategory['EgoodCategory']['name']?></td>
                            <td class="text-center"><?php echo $egoodCategory['EgoodCategory']['egood_count']?></td>
                            <td><?php echo $this->Time->format('Y-m-d H:i:s', $egoodCategory['EgoodCategory']['created']); ?></td>
                            <td><?php echo $this->Time->format('Y-m-d H:i:s', $egoodCategory['EgoodCategory']['modified']); ?></td>
                            <td class="text-center actions">
                                <?php 
                                    echo $this->Html->actionIcon('fa fa-th', 'view', $egoodCategory['EgoodCategory']['id']);
                                    echo "&nbsp;|&nbsp;";
                                    echo $this->Html->actionIcon('fa fa-pencil', 'edit', $egoodCategory['EgoodCategory']['id']);
									echo "&nbsp;|&nbsp;";
									echo $this->Html->link('<i class="fa fa-trash-o"> </i>',array('controller'=>'egood_categories','action'=>'delete',$egoodCategory['EgoodCategory']['id']),array('role'=>'button','escape'=>false,'title'=>__('Delete this Egoods Category')),__('Are you sure? You want to delete this Egoods Category.'));
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
