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
use Application\Model\SprintBacklog;
use Application\Model\SprintBacklogTable;
use Application\Model\ProductBacklog;
use Application\Model\ProductBacklogTable;
use Application\Model\ProductBacklogPorSprint;
use Application\Model\ProductBacklogPorSprintTable;
use Application\Model\Status;
use Application\Model\StatusTable;
use Application\Model\Projeto;
use Application\Model\ProjetoTable;
use Application\Model\ParticipanteProjeto;
use Application\Model\ParticipanteProjetoTable;
use Application\Model\ParticipantePorProjeto;
use Application\Model\ParticipantePorProjetoTable;
use Application\Model\ProjetoPorParticipante;
use Application\Model\ProjetoPorParticipanteTable;

//use Zend\Validator\Db\RecordExists;F

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $GLOBALS['sm'] = $e->getApplication()->getServiceManager();

        $serviceManager = $e->getApplication()->getServiceManager();
//        $container = $serviceManager->get('Application\Controller\Index');
    $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
     $viewModel->nomeParticipante =  'Thiago';//$container->container2();
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

    // configura a ligação das models com as respectivas tabelas do banco de dados
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
                /**                 * ************ PRODUCT BACKLOG ************** */
                //instacia um objeto da ProductBacklogTable e retorna seus elementos
                'Application\Model\ProductBacklogTable' => function($sm) {
                    $tableGateway = $sm->get('ProductBacklogTableGateway');
                    $table = new ProductBacklogTable($tableGateway);
                    return $table;
                },
                //instancia um array objeto da ProductBacklog, e retorna uma TableGateway 
                //passando o nome da tabela 'product_backlog'
                'ProductBacklogTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ProductBacklog());
                    return new TableGateway(new TableIdentifier('product_backlog'), $dbAdapter, null, $resultSetPrototype);
                },
                /**                 * ************ SPRINT BACKLOG ************** */
                //instacia um objeto da SprintBacklogTable e retorna seus elementos
                'Application\Model\SprintBacklogTable' => function($sm) {
                    $tableGateway = $sm->get('SprintBacklogTableGateway');
                    $table = new SprintBacklogTable($tableGateway);
                    return $table;
                },
                //instancia um array objeto da SprintBacklog, e retorna uma TableGateway 
                //passando o nome da tabela 'sprint_backlog'
                'SprintBacklogTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new SprintBacklog());
                    return new TableGateway(new TableIdentifier('sprint_backlog'), $dbAdapter, null, $resultSetPrototype);
                },
                /**                 * ************ PRODUCT BACKLOG POR SPRINT ************** */
                //instacia um objeto da ProductBacklogPorSprintTable e retorna seus elementos
                'Application\Model\ProductBacklogPorSprintTable' => function($sm) {
                    $tableGateway = $sm->get('ProductBacklogPorSprintTableGateway');
                    $table = new ProductBacklogPorSprintTable($tableGateway);
                    return $table;
                },
                //instancia um array objeto da ProductBacklogPorSprint, e retorna uma TableGateway 
                //passando o nome da tabela 'product_backlog_para_sprint'
                'ProductBacklogPorSprintTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ProductBacklogPorSprint());
                    return new TableGateway(new TableIdentifier('product_backlog_para_sprint'), $dbAdapter, null, $resultSetPrototype);
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
                /**                 * ************ PARTICIPANTE PROJETO ************** */
                //instacia um objeto da ProjetoParticipanteTable e retorna seus elementos
//                'Application\Model\ParticipanteProjetoTable' => function($sm) {
//                    $tableGateway = $sm->get('ParticipanteProjetoTableGateway');
//                    $table = new ParticipanteProjetoTable($tableGateway);
//                    return $table;
//                },
//                //instancia um array objeto da ProjetoParticipante, e retorna uma TableGateway 
//                //passando o nome da tabela 'projeto_para_participante'
//                'ParticipanteProjetoTableGateway' => function ($sm) {
//                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//                    $resultSetPrototype = new ResultSet();
//                    $resultSetPrototype->setArrayObjectPrototype(new ParticipanteProjeto());
//                    return new TableGateway(new TableIdentifier('participante_para_projeto'), $dbAdapter, null, $resultSetPrototype);
//                },
                /**                 * ************ PARTICIPANTE POR PROJETO ************** */
                //instacia um objeto da ProjetoParticipanteTable e retorna seus elementos
                'Application\Model\ParticipantePorProjetoTable' => function($sm) {
                    $tableGateway = $sm->get('ParticipantePorProjetoTableGateway');
                    $table = new ParticipantePorProjetoTable($tableGateway);
                    return $table;
                },
                //instancia um array objeto da ProjetoParticipante, e retorna uma TableGateway 
                //passando o nome da tabela 'projeto_para_participante'
                'ParticipantePorProjetoTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ParticipantePorProjeto());
                    return new TableGateway(new TableIdentifier('participante_para_projeto'), $dbAdapter, null, $resultSetPrototype);
                },
                /**                 * ************ PROJETO POR PARTICIPANTE************** */
                //instacia um objeto da ProjetoParticipanteTable e retorna seus elementos
                'Application\Model\ProjetoPorParticipanteTable' => function($sm) {
                    $tableGateway = $sm->get('ProjetoPorParticipanteTableGateway');
                    $table = new ProjetoPorParticipanteTable($tableGateway);
                    return $table;
                },
                //instancia um array objeto da ProjetoParticipante, e retorna uma TableGateway 
                //passando o nome da tabela 'projeto_para_participante'
                'ProjetoPorParticipanteTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ProjetoPorParticipante());
                    return new TableGateway(new TableIdentifier('participante_para_projeto'), $dbAdapter, null, $resultSetPrototype);
                },
            ),

        );
    }
}
