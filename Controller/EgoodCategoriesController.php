<?php

/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
class EgoodCategoriesController extends AppController
{

    public $name = 'EgoodCategories';
    public $helpers = array('Text', 'Time', 'GtwStripe.Stripe');

    public function index()
    {
        $this->paginate = array(
            'EgoodCategory' => array(
                'order' => 'EgoodCategory.id DESC'
            )
        );
        $this->set('egoodCategories', $this->paginate('EgoodCategory'));
    }
    public function add()
    {
        if ($this->request->is('post')) {
            $this->EgoodCategory->create();
            if ($this->EgoodCategory->save($this->request->data)) {
                $this->Session->setFlash(__d('gtw_egoods','The egood category has been created successfully'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('gtw_egoods','Unable to create egood category. Please, try again.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            }
        }
    }
    public function edit($egoodCategoryId = 0)
    {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['EgoodCategory']['id'] = $egoodCategoryId;
            if ($this->EgoodCategory->save($this->request->data)) {
                $this->Session->setFlash(____d('gtw_egoods','The egood category has been updated successfully'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(____d('gtw_egoods','The egood category could not be update. Please, try again.'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        } else {
            $this->request->data = $this->EgoodCategory->read(null, $egoodCategoryId);
        }
    }
    
    public function delete($egoodCategoryId = 0)
    {
        $this->EgoodCategory->recursive = -1;
        if (!empty($egoodCategoryId)) {
            if ($this->EgoodCategory->delete($egoodCategoryId)) {
                $this->Session->setFlash(__d('gtw_egoods','Egood category has been deleted successfully'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                $this->redirect($this->referer());
            }
        }
        $this->Session->setFlash(__d('gtw_egoods','Unable to delete egood category, Please try again'), 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-danger'
        ));
        $this->redirect($this->referer());
    }
    
    public function view($egoodCategoryId = 0)
    {
        $egoodCategory = $this->EgoodCategory->find('first', array(
            'conditions' => array(
                'EgoodCategory.id' => $egoodCategoryId
            ),
            'contain' => array(
                'UserModel'
            ),
        ));
        $this->set(compact('egoodCategory', 'egoodCategoryId'));
    }
}
