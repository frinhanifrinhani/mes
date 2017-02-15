<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

// importação das bibliotecas do ZendFramework
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
//add
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\TableIdentifier;
use Application\Model\TipoParticipante;
use Application\Model\TipoParticipanteTable;
use Application\Model\Participante;
use Application\Model\ParticipanteTable;
use Application\Model\Sprint;
use Application\Model\SprintTable;
use Application\Model\Status;
use Application\Model\StatusTable;
use Application\Model\Projeto;
use Application\Model\ProjetoTable;

//use Zend\Validator\Db\RecordExists;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $GLOBALS['sm'] = $e->getApplication()->getServiceManager();
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    // configu
    public function getServiceConfig() {
        return array(
            //factories para acesso as tabelas
            'factories' => array(
                /**                 * ************ TIPO PARTICIPANTE ************** */
                //instacia um objeto da TipoParticipanteTable e retorna seus elementos
                'Application\Model\TipoParticipanteTable' => function($sm) {
                    $tableGateway = $sm->get('TipoParticipanteTableGateway');
                    $table = new TipoParticipanteTable($tableGateway);
                    return $table;
                },
                //instancia um array objeto da Participante, e retorna uma TableGateway 
                //passando o nome da tabela 'participante'
                'TipoParticipanteTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new TipoParticipante());
                    return new TableGateway(new TableIdentifier('tipo_participante'), $dbAdapter, null, $resultSetPrototype);
                },
                /**                 * ************ PARTICIPANTE ************** */
                //instacia um objeto da ParticiapanteTable e retorna seus elementos
                'Application\Model\ParticipanteTable' => function($sm) {
                    $tableGateway = $sm->get('ParticipanteTableGateway');
                    $table = new ParticipanteTable($tableGateway);
                    return $table;
                },
                //instancia um array objeto da Participante, e retorna uma TableGateway 
                //passando o nome da tabela 'participante'
                'ParticipanteTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Participante());
                    return new TableGateway(new TableIdentifier('participante'), $dbAdapter, null, $resultSetPrototype);
                },
                /**                 * ************ SPRINT ************** */
                //instacia um objeto da SprintTable e retorna seus elementos
                'Application\Model\SprintTable' => function($sm) {
                    $tableGateway = $sm->get('SprintTableGateway');
                    $table = new SprintTable($tableGateway);
                    return $table;
                },
                //instancia um array objeto da Sprint, e retorna uma TableGateway 
                //passando o nome da tabela 'sprint'
                'SprintTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Sprint());
                    return new TableGateway(new TableIdentifier('sprint'), $dbAdapter, null, $resultSetPrototype);
                },
                /**                 * ************ STATUS ************** */
                //instacia um objeto da StatusTable e retorna seus elementos
                'Application\Model\StatusTable' => function($sm) {
                    $tableGateway = $sm->get('StatusTableGateway');
                    $table = new StatusTable($tableGateway);
                    return $table;
                },
                //instancia um array objeto da Status, e retorna uma TableGateway 
                //passando o nome da tabela 'status'
                'StatusTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Status());
                    return new TableGateway(new TableIdentifier('status'), $dbAdapter, null, $resultSetPrototype);
                },
                /**                 * ************ PROJETO ************** */
                //instacia um objeto da ProjetoTable e retorna seus elementos
                'Application\Model\ProjetoTable' => function($sm) {
                    $tableGateway = $sm->get('ProjetoTableGateway');
                    $table = new ProjetoTable($tableGateway);
                    return $table;
                },
                //instancia um array objeto da Projeto, e retorna uma TableGateway 
                //passando o nome da tabela 'projeto'
                'ProjetoTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Projeto());
                    return new TableGateway(new TableIdentifier('projeto'), $dbAdapter, null, $resultSetPrototype);
                },
            )
        );
    }

}
