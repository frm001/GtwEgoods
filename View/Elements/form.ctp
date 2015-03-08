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
            <div class="col-md-4 text-right"><?php echo $this->Html->actionIconBtn('fa fa-reply', __d('gtw_egoods',' Back'),'listing');?></div>
        </div>
    </div>
    <div class="panel-body gtw-egoods">
        <?php echo $this->Form->create('Egood', array('type'=>'file','inputDefaults' => array('div' => 'col-md-12 form-group','class' => 'form-control'),'class' => 'form-horizontal','id'=>'EGoodAddEditForm', 'novalidate'=>'novalidate')); ?>
        <div class="row">
            <div class="col-md-12">
				<?php echo $this->Form->input('egood_category_id',array(
                    'label' => __d('gtw_egoods','Egood Category'),
                    'type'=>'select',
                    'options'=>$egoodCategories
                )); ?>              
                <?php echo $this->Form->input('title',array(
                    'label' => __d('gtw_egoods','Title'),
                    'type'=>'text'
                )); ?>
                <?php echo $this->Form->input('description',array(
                    'label' => __d('gtw_egoods','Description'),
                    'class' =>'wysiwyg',
                    'style' => 'width:100%',
                )); ?>
                <?php echo $this->Form->input('photo', array(
                    'label' => __d('gtw_egoods','Photo'),
                    'type' => 'file',
                )); ?>
                <?php echo $this->Form->input('attachement', array(
                    'label' => __d('gtw_egoods','Attachement'),
                    'type' => 'file',
                )); ?>
                <?php echo $this->element('GtwEgoods.paid_form');?>
                <?php echo $this->Form->input('status', array(
                    'label' => __d('gtw_egoods','Status'),
                    'options' => $status,
                )); ?>
                <?php echo $this->Form->submit($title, array(
                    'div' => false,
                    'class' => 'btn btn-primary'
                )); ?>
                <?php echo $this->Html->actionBtn( __d('gtw_egoods', 'Cancel'), 'index'); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
