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
use Zend\Crypt\Password\Apache;  //Zend\Crypt\Password\Bcrypt 


class LoginController extends AbstractActionController
{
    protected $usuarioTable;
    
    public function loginAction()
    {
        $autentica = new AuthenticationService;
        
        if ($autentica->hasIdentity()) {
            return $this->redirect()->toRoute('sprint');
        }
        
        $this->layout('layout/login');
        $form = new LoginForm();
        
        return new ViewModel(array(
            'form' => $form
        ));

    }
    
    public function getUsuarioTable()
    {
        if(!$this->usuarioTable){
            $sm = $this->getServiceLocator();
            $this->usuarioTable = $sm->get('Application\Model\UsuarioTable');
        }
        
        
    }

    public function autenticacaoAction()
    {
        $request = $this->getRequest();
        
        if(!$request->isPost()){
            return $this->redirect()->toRoute('login');
        }
        $identidade = $request->getPost('usuario');       
        $credencial = $request->getPost('senha'); 
       
        $usuario = new Login($identidade,$credencial);
        
        if($usuario->autenticar($this->getServiceLocator())){
            return $this->redirect()->toRoute('sprint');
        }else{
            return $this->redirect()->toRoute('login');
        }
    }
    
    public function sairAction()
    {
        $autenticacao = new AuthenticationService();
        $autenticacao->clearIdentity();
        return $this->redirect()->toRoute('login');
    }
}
