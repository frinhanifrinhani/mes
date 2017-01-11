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
class MESACL extends AbstractPlugin
{
    public $autenticado;
    public $redirect;
    
    public function __construct()
    {
        
        $this->autenticado = new AuthenticationService();
        $dados = $this->autenticado->getIdentity();
        
        $container = new Container();
        $container->email_participante = $dados->email_participante;
        
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
            $controller = $this->getController();
            $redirector = $controller->getPluginManager()->get('Redirect');
            return $redirector->toRoute('login');
        }
        
        
    }
}