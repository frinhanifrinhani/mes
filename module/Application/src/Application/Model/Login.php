<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Model;

use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\AuthenticationService;
use Application\Model\Participante;
use Application\Model\ParticipanteTable;
use Zend\Db\Sql\TableIdentifier;
use Zend\Session\Container;

class Login{

    private $identidade;
    private $credencial;
    private $mensagens = array();
    
    public function __construct($identidade,$credencial)
    {
        $this->identidade = $identidade;
        $this->credencial = $credencial;
    }
    
    public function autenticar($sm)
    {
        $zendDb = $sm->get('Zend\Db\Adapter\Adapter');
        $adapter = new DbTable($zendDb);
        
        $adapter->setIdentityColumn('email_participante')
                ->setTableName(new TableIdentifier('participante'))
                ->setCredentialColumn('senha_participante')
                ->setIdentity($this->identidade)
                ->setCredential($this->credencial)
                ->setCredentialTreatment('MD5(?)');
        
        $autenticacao = new AuthenticationService();
        $autenticacao->setAdapter($adapter);
        //autentica
        $resultado = $autenticacao->authenticate();
        if($resultado->isValid()){
            $usuario = $autenticacao->getAdapter()->getResultRowObject(null, 'email_participante');
            $autenticacao->getStorage()->write($usuario);
            $sessao = new Container();
            $sessao->usuario = $usuario;
            
            return true;
        }else{
            $this->mensagens = $resultado->getMessages();
            
            return false;
        }
        
    }
}
