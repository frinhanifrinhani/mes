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
use Application\Model\Usuario;
use Application\Model\UsuarioTable;
use Application\Model\Participante;
use Application\Model\ParticipanteTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    // configu
    public function getServiceConfig()
    {
       return array(
           
//           'Application\Model\UsuarioTable' => function($sm) {
//                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//                    $table = new UsuarioTable($dbAdapter);
//                    return $table;
//                },
//                
//                
           //factories para acesso as tabelas
           'factories' => array(
               //instacia um objeto da UsuarioTable e retorna seus elementos
               'Application\Model\UsuarioTable' =>  function($sm) {
                            $tableGateway = $sm->get('UsuarioTableGateway');
                            $table = new UsuarioTable($tableGateway);
                            return $table;
               },
//             //instancia um array objeto da Usuario, e retorna uma TableGateway 
//             //passando o nome da tabela 'usuario'
               'UsuarioTableGateway' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Usuario());
                    return new TableGateway(new TableIdentifier('usuario'),$dbAdapter, null, $resultSetPrototype);
               },
               //instacia um objeto da ParticiapanteTable e retorna seus elementos
               'Application\Model\ParticipanteTable' =>  function($sm) {
                            $tableGateway = $sm->get('ParticipanteTableGateway');
                            $table = new ParticipanteTable($tableGateway);
                            return $table;
               },
//             //instancia um array objeto da Participante, e retorna uma TableGateway 
//             //passando o nome da tabela 'participante'
               'ParticipanteTableGateway' => function ($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Participante());
                    return new TableGateway(new TableIdentifier('participante'),$dbAdapter, null, $resultSetPrototype);
               },
               
                
               
       

           )
       ); 
    }
}
