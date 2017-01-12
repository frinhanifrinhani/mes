<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;

class SenhaForm extends Form {

    public function __construct() {
        parent::__construct('form_alterarsenha');

        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'form_senha');

        $this->add(array(
            'name' => 'senha_atual',
            'type' => 'Password',
            'attributes' => array(
                'id' => 'senha_atual',
                'class' => 'form-control',
                'placeholder' => 'Informe sua senha atual',
            ),
            'options' => array(
                'label' => 'Senha Atual *',
            ),
        ));

        $this->add(array(
            'name' => 'nova_senha',
            'type' => 'Password',
            'attributes' => array(
                'id' => 'nova_senha',
                'class' => 'form-control',
                'placeholder' => 'Informe a nova senha',
            ),
            'options' => array(
                'label' => 'Nova senha *',
            ),
        ));

        $this->add(array(
            'name' => 'confirma_senha',
            'type' => 'Password',
            'attributes' => array(
                'id' => 'confirma_senha',
                'class' => 'form-control',
                'placeholder' => 'Confirme a nova senha',
            ),
            'options' => array(
                'label' => 'Confirmação senha *',
            ),
        ));

        $this->add(array(
            'name' => 'botao_salvar',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary',
                'id' => 'botao_salvar',
            ),
        ));
        
    }

}
