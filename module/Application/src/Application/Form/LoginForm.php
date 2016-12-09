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
        parent::__construct();
        
        $this->setAttribute('method', 'post');
//        $this->setAttribute('enctype','multipart/form-data');
        $this->add(array(
            'name' => 'usuario',
            'type' => 'Text',
            'attributes'=>array(
              'id' => 'login-username',
              'class'=>'form-control',
              'placeholder'=>'Usuario',
            ),
        ));
//        <input id="login-password" type="password" class="form-control" name="password" placeholder="Senha">
        $this->add(array(
            'name' => 'senha',
            'type' => 'Password',
            'attributes'=>array(
              'id' => 'inputPassword',
              'class'=>'form-control',
              'placeholder'=>'Senha',
            ),
        ));
        $this->add(array(
            'name' => 'botao_entrar',
            'type' => 'Submit',
            'attributes'=> array(
              'value' => 'Entrar',  
              'id' => 'botao_entrar' 
            ),
        ));
    }
}
