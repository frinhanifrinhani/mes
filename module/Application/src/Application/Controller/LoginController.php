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
use Zend\Authentication\AuthenticationService;
use Application\Model\Login;

class LoginController extends AbstractActionController {

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

    public function autenticacaoAction() {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->redirect()->toRoute('login');
        }

        $identidade = $request->getPost('email_participante');
        $credencial = $request->getPost('senha_participante');

        $usuario = new Login($identidade, $credencial);

        if ($usuario->autenticar($this->getServiceLocator()) == true) {
            return $this->redirect()->toRoute('inicio');
        } else {
            return $this->redirect()->toRoute('error-login');
        }
    }

    public function errorLoginAction(){
        $this->layout('layout/login');
       return new ViewModel(array(
            
        )); 
    }

    public function sairAction() {
        $autenticacao = new AuthenticationService();
        $autenticacao->clearIdentity();
        return $this->redirect()->toRoute('login');
    }

}
