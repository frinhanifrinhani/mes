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

class LoginForm extends Form {
    
    public function __construct() {
        parent::__construct('form_login');
        
        $this->setAttribute('method', 'post');

        $this->setAttribute('id', 'form_login');
        
        $this->add(array(
            'name' => 'email_participante',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'email_participante',
              'class'=>'form-control',
              'placeholder'=>'E-mail',
            ),
        ));
        $this->add(array(
            'name' => 'senha_participante',
            'type' => 'Password',
            'attributes'=>array(
              'id' => 'senha_participante',
              'class'=>'form-control',
              'placeholder'=>'Senha',
            ),
        ));
        $this->add(array(
            'name' => 'botao_entrar',
            'type' => 'Submit',
            'attributes'=> array(
              'value' => 'Entrar', 
              'class'=>'btn btn-primary',
              'id' => 'botao_entrar' 
            ),
        ));
    }
}
