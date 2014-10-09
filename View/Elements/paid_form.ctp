<?php 
if($paymentSupport): 
    echo $this->Form->input('type',array(
        'options' => $type,
        'type' =>'radio',
        'before'=>'<label for="EgoodType">'.__('Type').'</label>',
        'class'=>'btn btn-default',
        'legend'=>false
    ));
    echo $this->Form->input('price',array(
            'min'=>0,
            'div' =>array('class'=>'col-md-12 form-group egood-price')
    ));
endif;
?>