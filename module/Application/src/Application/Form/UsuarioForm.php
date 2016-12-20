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

class UsuarioForm extends Form {
    
    public function __construct() {
        parent::__construct('form_usuario');
        
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'nome',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'nome_usuario',
              'class'=>'form-control',
              'placeholder'=>'Nome Completo',
            ),
            'options'=>array(
                'label'=>'Nome Completo *',
            ),
        ));
        $this->add(array(
            'name' => 'cpf',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'cpf_usuario',
              'class'=>'form-control',
              'placeholder'=>'CPF',
            ),
            'options'=>array(
                'label'=>'CPF *',
            ),
        ));
        $this->add(array(
            'name' => 'telefone',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'telefone_usuario',
              'class'=>'form-control',
              'placeholder'=>'Telefone para contato',
            ),
            'options'=>array(
                'label'=>'Telefone',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'email_usuario',
              'class'=>'form-control',
              'placeholder'=>'E-mail',
            ),
            'options'=>array(
                'label'=>'E-mail *',
            ),
        ));
        $this->add(array(
            'name' => 'senha',
            'type' => 'password',
            'attributes'=>array(
              'id' => 'senha_usuario',
              'class'=>'form-control',
              'placeholder'=>'Senha *',
            ),
            'options'=>array(
                'label'=>'Senha',
            ),
        ));
        $this->add(array(
            'name' => 'confirma_senha',
            'type' => 'password',
            'attributes'=>array(
              'id' => 'senha_usuario',
              'class'=>'form-control',
              'placeholder'=>'Confirmacao da Senha',
            ),
            'options'=>array(
                'label'=>'Confirmação da Senha *'
            ),
        ));

        $this->add(array(
            'name' => 'botao_salvar',
            'type' => 'Submit',
            'attributes'=> array(
              'value' => 'Salvar', 
              'class'=>'btn btn-primary',
              'id' => 'botao_salvar',
            ),
        ));
    }
}
