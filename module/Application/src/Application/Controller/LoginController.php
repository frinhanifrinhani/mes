<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\LoginForm;
//add
use Zend\Authentication\AuthenticationService;
use Application\Model\Login;
use Application\Model\Usuario;

class LoginController extends AbstractActionController {

//    protected $usuarioTable;

    public function loginAction() {
        $autenticacao = new AuthenticationService;

        if ($autenticacao->hasIdentity()) {
            return $this->redirect()->toRoute('inicio');
        }

        $this->layout('layout/login');
        $formLogin = new LoginForm();
        return new ViewModel(array(
            'form_login' => $formLogin
        ));
    }

//    public function getUsuarioTable() {
//        if (!$this->usuarioTable) {
//            $sm = $this->getServiceLocator();
//            $this->usuarioTable = $sm->get('Application\Model\UsuarioTable');
//        }
//
//        return $this->usuarioTable;
//    }

    public function autenticacaoAction() {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->redirect()->toRoute('login');
        }
        if($request->getPost()->email_participante == null){
            //return 
        }
        //die;
        $identidade = $request->getPost('email_participante');
        $credencial = $request->getPost('senha_participante');

        $usuario = new Login($identidade, $credencial);

        if ($usuario->autenticar($this->getServiceLocator())) {
            return $this->redirect()->toRoute('inicio');
        } else {
            return $this->redirect()->toRoute('login');
        }
    }

//    public function verificarAutenticacaoAction()
//    {
//        $autenticacao = new AuthenticationService;
//        
//        if (!$autenticacao->hasIdentity()) {
//            //return $this->redirect()->toRoute('login');
//            return $this->redirect()->toRoute('login');
//        } 
//    }


    public function sairAction() {
        $autenticacao = new AuthenticationService();
        $autenticacao->clearIdentity();
        return $this->redirect()->toRoute('login');
    }

}
