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
use Zend\Authentication\AuthenticationService;
use Application\Model\Login;

class IndexController extends AcessoController
{
    public function indexAction()
    {
        $autenticacao = new AuthenticationService;
        if ($autenticacao->hasIdentity()) {
            return $this->redirect()->toRoute('inicio');
        }else{
            return $this->redirect()->toRoute('login');
            
        }

    }
    
    public function inicioAction()
    {
        //metodo que verifica autenticação e perfil
        $this->permitir();
        return new ViewModel();
    }
}
