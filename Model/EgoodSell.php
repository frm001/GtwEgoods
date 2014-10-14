<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
class EgoodSell extends AppModel {
	var $name = 'EgoodSell';
	
	var $belongsTo = array(
		'Egood' => array(
			'className' => 'Egood',
			'foreignKey' => 'egood_id',
			'counterCache' => true
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
		'Transaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'transaction_id'
		)
	);
    function addToSell($transactioDetail,$egood_id){
        $arrSell = array(
                        'egood_id' => $egood_id,
                        'transaction_id' => $transactioDetail['id'],
                        'user_id' => $transactioDetail['user_id'],
        );
        $this->create();
        $this->save($arrSell);
    }
    function checkSell($userId,$egoodId){
        return $this->find('count',array(
                        'conditions'=>array(
                            'user_id' => $userId,
                            'egood_id' => $egoodId,
                        ),
                        'recursive' => -1
                    ));
    }
}