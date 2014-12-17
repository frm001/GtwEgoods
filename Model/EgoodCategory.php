<?php

/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
class EgoodCategory extends AppModel
{

    var $name = 'EgoodCategory';
    var $hasMany = array(
        'Egood' => array(
            'className' => 'Egood',
            'foreignKey' => 'egood_category_id'
    ));
}
