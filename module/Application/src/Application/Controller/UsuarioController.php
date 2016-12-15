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
use Application\Form\UsuarioForm;

class UsuarioController extends AcessoController
{
    public function indexAction()
    {
        //metodo que verifica autenticação e perfil
        $this->permitir();
        return new ViewModel();
    }
    
    public function criarContaProductOwnerAction()
    {
        $this->layout('layout/login');
        $formUsuario = new UsuarioForm();
        return new ViewModel(array(
            'form_usuario'=> $formUsuario
        ));
    }
    
    
}
