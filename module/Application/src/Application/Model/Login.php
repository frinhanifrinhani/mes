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

class Login {

    private $identidade;
    private $credencial;
    private $mensagens = array();

    public function __construct($identidade, $credencial) {
        $this->identidade = $identidade;
        $this->credencial = $credencial;
    }

    public function autenticar($sm) {
        try {
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

            $resultado = $autenticacao->authenticate();
            if ($resultado->isValid()) {
                $usuario = $autenticacao->getAdapter()->getResultRowObject();
                $autenticacao->getStorage()->write($usuario);
                return true;
            }else{
                return false;
            }
            
        } catch (\Exception $e) {
            return $e->getPrevious();
        }
    }

}
