<?php

/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
class EgoodSell extends AppModel
{

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

    function addToSell($transactioDetail, $egood_id)
    {
        $arrSell = array(
            'egood_id' => $egood_id,
            'transaction_id' => $transactioDetail['id'],
            'user_id' => $transactioDetail['user_id'],
        );
        $this->create();
        $this->save($arrSell);
    }

    function checkSell($userId, $egoodId)
    {
        return $this->find('count', array(
                    'conditions' => array(
                        'user_id' => $userId,
                        'egood_id' => $egoodId,
                    ),
                    'recursive' => -1
        ));
    }
    
    function getTransactions()
    {
        $conditions = array();
        $conditions['Egood.status'] = 1; // Display only active Product
        $conditions['EgoodSell.user_id'] = CakeSession::read('Auth.User.id');
        return $this->paginate = array(
            'EgoodSell' => array(
                'fields' => array(
                    'EgoodSell.*',
                    'Egood.id',
                    'Egood.title',
                    'Egood.photo',
                    'Egood.price',
                    'Egood.slug',
                    'Transaction.amount',
                    'Transaction.brand',
                    'Transaction.last4',
                ),
                'conditions' => $conditions,
                'contain' => array(
                    'UserModel'
                ),
                'order' => 'Egood.created DESC'
            )
        );
    }

}
