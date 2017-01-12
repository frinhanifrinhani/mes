<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\ActionHelper;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\Validator\Authentication;
//add
use Zend\Authentication\AuthenticationService;
//use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\Session\Container;

class MESACL extends AbstractPlugin {

    public $autenticado;
    public $dados;
    public $redirect;

    public function __construct() {

        $this->autenticado = new AuthenticationService();
        $this->dados = $this->autenticado->getIdentity();
 
    }
    
    public function container(){
        
        $container = new Container();
        
        $container->cod_participante = $this->dados->cod_participante;
        $container->cod_tipo_participante = $this->dados->cod_tipo_participante;
        $container->email_participante = $this->dados->email_participante;
        $container->senha_participante = $this->dados->senha_participante;
        
       return array(
            'cod_participante' => $container->cod_participante,
            'cod_tipo_participante' => $container->cod_tipo_participante,
            'email_participante' => $container->email_participante,
            'senha_participante' => $container->senha_participante,
        );
    }

    public function verificarAutenticacao() {
        if (!$this->autenticado->hasIdentity()) {
            return false;
        } else {
            return true;
        }
    }

    public function permitir() {
        $autenticado = $this->verificarAutenticacao();
        $container = new Container();
        
        if ($autenticado == false) {
            $controller = $this->getController();
            $redirector = $controller->getPluginManager()->get('Redirect');
            return $redirector->toRoute('login');
        }

    }

}
