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
//add
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\Controller\Plugin\Url;
//use Application\Model\Login;
//use Application\Model\Usuario;



class AcessoController extends AbstractActionController
{
    public $autenticado;

    public function __construct()
    {
        $this->autenticado = new AuthenticationService();
        $dados = $this->autenticado->getIdentity();
        
    }
    
    public function verificarAutenticacao() {
        if (!$this->autenticado->hasIdentity()) {
            return false;
        }else{
            return true;
        }
    }
    
    public function permitir()
    {
        $autenticado = $this->verificarAutenticacao();
        if($autenticado==false){
            return $this->redirect()->toRoute('login');
        }
    }

}
