<?php

namespace App\Controller;

use Cake\Event\Event;
use App\Form\UpdatePostForm;
use App\Lib\Api;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

/**
 * Posts page
 */
class AboutController extends AppController {
    /**
     * Add/update info
     */
    public function update() {
        $param = array(
            'type' => 'about'
        );
        $data = Api::call(Configure::read('API.url_pages_detail'), $param);
        // Create breadcrumb
        $pageTitle = __('Giới thiệu cty');
        $listPageUrl = h($this->BASE_URL . '/about/update');
        $this->Breadcrumb->setTitle($pageTitle)
            ->add(array(
                'name' => $pageTitle,
            ));
        $form = new UpdatePostForm();
        $this->UpdateForm->reset()
            ->setModel($form)
            ->setData($data)
            ->setAttribute('autocomplete', 'off')
            ->addElement(array(
                'id' => 'id',
                'type' => 'hidden',
                'label' => __('id'),
            ))
            ->addElement(array(
                'id' => 'content',
                'label' => __('LABEL_CONTENT'),
                'type' => 'editor'
            ))
            ->addElement(array(
                'type' => 'submit',
                'value' => __('LABEL_SAVE'),
                'class' => 'btn btn-primary',
            ))
            ->addElement(array(
                'type' => 'submit',
                'value' => __('LABEL_CANCEL'),
                'class' => 'btn',
                'onclick' => "return back();"
            ));
        // Valdate and update
        if ($this->request->is('post')) {
            // Trim data
            $data = $this->request->data();
            foreach ($data as $key => $value) {
                if (is_scalar($value)) {
                    $data[$key] = trim($value);
                }
            }
            // Validation
            if ($form->validate($data)) {
                // Call API
                $id = Api::call(Configure::read('API.url_pages_addupdate'), $data);
                if (!empty($id) && !Api::getError()) {            
                    $this->Flash->success(__('MESSAGE_SAVE_OK'));
                    return $this->redirect("{$this->BASE_URL}/{$this->controller}/update");
                } else {
                    return $this->Flash->error(__('MESSAGE_SAVE_NG'));
                }
            }
        }
    }
}
