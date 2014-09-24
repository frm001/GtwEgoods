<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
class EgoodDownload extends AppModel {
	var $name = 'EgoodDownload';
	
	var $belongsTo = array(
		'Egood' => array(
			'className' => 'Egood',
			'foreignKey' => 'egood_id',
			'counterCache' => true
		)
	);
}