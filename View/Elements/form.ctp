<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
$this->Helpers->load('GtwRequire.GtwRequire');
$this->GtwRequire->req('ui/wysiwyg');
echo $this->GtwRequire->req($this->Html->url('/',true).'GtwEgoods/js/egoods.js');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8"><h3 class="title"><?php echo $title?></h3></div>
            <div class="col-md-4 text-right"><?php echo $this->Html->actionIconBtn('fa fa-reply',__(' Back'),'listing');?></div>
        </div>
    </div>
    <div class="panel-body gtw-egoods">
        <?php echo $this->Form->create('Egood', array('type'=>'file','inputDefaults' => array('div' => 'col-md-12 form-group','class' => 'form-control'),'class' => 'form-horizontal','id'=>'EGoodAddEditForm', 'novalidate'=>'novalidate')); ?>
        <div class="row">
            <div class="col-md-12">                
                <?php echo $this->Form->input('title',array(
                    'type'=>'text'
                )); ?>
                <?php echo $this->Form->input('description',array(
                    'class' =>'wysiwyg',
                    'style' => 'width:100%',
                )); ?>
                <?php echo $this->Form->input('photo', array(
                    'type' => 'file',
                )); ?>
                <?php echo $this->Form->input('attachement', array(
                    'type' => 'file',
                )); ?>
                <?php echo $this->element('GtwEgoods.paid_form');?>
                <?php echo $this->Form->input('status', array(
                    'options' => $status,
                )); ?>
                <?php echo $this->Form->submit($title, array(
                    'div' => false,
                    'class' => 'btn btn-primary'
                )); ?>
                <?php echo $this->Html->actionBtn(__('Cancel'), 'index'); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
