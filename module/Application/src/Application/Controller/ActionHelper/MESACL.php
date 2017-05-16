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
use Application\Controller\ActionHelper\ACL;

class MESACL extends AbstractPlugin {

    public $autenticado;
    public $dados;
    public $redirect;

    public function __construct() {

        $this->autenticado = new AuthenticationService();
        $this->dados = $this->autenticado->getIdentity();

    }

    public function container() {

        $container = new Container();

        switch ($container->cod_tipo_participante){
            case 1:
                $this->dados->tipo_participante = 'Product Owner';
                break;
            
            case 2:
                $this->dados->tipo_participante = 'Scrum Master';
                break;
            
            case 3:
                $this->dados->tipo_participante = 'Scrum Team';
                break;
        }
        
        $container->cod_participante = $this->dados->cod_participante;
        $container->cod_tipo_participante = $this->dados->cod_tipo_participante;
        $container->tipo_participante = $this->dados->tipo_participante;
        $container->nome_participante = $this->dados->nome_participante;
        $container->email_participante = $this->dados->email_participante;
        $container->senha_participante = $this->dados->senha_participante;

        return array(
            'cod_participante' => $container->cod_participante,
            'cod_tipo_participante' => $container->cod_tipo_participante,
            'tipo_participante' => $container->tipo_participante,
            'nome_participante' => $container->nome_participante,
            'email_participante' => $container->email_participante,
            'senha_participante' => $container->senha_participante,
        );
    }

    public function acl() {
        $controller = $this->getController();

        $controllerName = $controller->params('controller');
        $actionName = $controller->params('action');

        $acl = new ACL();
        if ($acl->isAllowed($this->dados->tipo_participante, $controllerName, $actionName)) {
            return true;
        } else {

            return false;
        }
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
        $permitido = $this->acl();

        $container = new Container();

//        $this->layout()->nomeParticipante='Thiago';
        if ($autenticado == false) {
            $controller = $this->getController();
            $redirector = $controller->getPluginManager()->get('Redirect');
            return $redirector->toRoute('login');
        }

        if ($permitido == false) {
            $controller = $this->getController();
            $redirector = $controller->getPluginManager()->get('Redirect');
            return $redirector->toRoute('acesso-negado');
        }
    }

}
