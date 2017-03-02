<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            //rota para tela inicial
            'inicio' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/inicio',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'inicio',
                    ),
                ),
            ),
            //rota para tela de login
            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Login',
                        'action' => 'login',
                    ),
                ),
            ),
            //rota para funcionalidade sair
            'sair' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/sair',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Login',
                        'action' => 'sair',
                    )
                )
            ),
            //rota para funcionalidade alterar senha
            'alterarsenha' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/alterarsenha',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Participante',
                        'action' => 'alterarsenha',
                    )
                )
            ),
            //rota para funcionalidade esqueci a senha
            'recuperasenha' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/recuperasenha',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Participante',
                        'action' => 'recuperarsenha',
                    )
                )
            ),
            /*             * ************* ROTAS PARA PARTICPANTE ************** */

            //rota para tela criar conta
            'criarcontaproductowner' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/criarcontaproductowner',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Participante',
                        'action' => 'criarcontaproductowner',
                    ),
                ),
            ),
            //rota para tela de participante
            'participante' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/participante',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Participante',
                        'action' => 'listar',
                    ),
                ),
            ),
            //Rota cadastrar participante
            'participante-cadastrar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/participante-cadastrar',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Participante',
                        'action' => 'cadastrar',
                    ),
                ),
            ),
            //Rota editar participante
            'participante-editar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/participante-editar[/:cod_participante]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Participante',
                        'action' => 'editar',
                    ),
                ),
            ),
            //Rota excluir participante
            'participante-excluir' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/participante-excluir[/:cod_participante]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Participante',
                        'action' => 'excluir',
                    ),
                ),
            ),
            
            /*             * ************* ROTAS PARA PARTICIPANTE POR PROJETO ************** */
            //Rota participante
            'participanteprojeto' => array(
                'type' => 'Segment',//Segment
                'options' => array(
                    'route' => '/participanteprojeto[/:cod_participante]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\ParticipanteProjeto',
                        'action' => 'listarprojeto',
                    ),
                ),
            ),
            /*             * ************* ROTAS PARA PRODUCTBACKLOG ************** */
            //rota para tela productbacklog
            'productbacklog' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/productbacklog',
                    'route' => '/projeto[/:cod_projeto]/productbacklog',
                    'defaults' => array(
                        'controller' => 'Application\Controller\ProductBacklog',
                        'action' => 'listar',
                    ),
                ),
            ),
            /*             * ************* ROTAS PARA PROJETO ************** */
            //rota para tela projeto
            'projeto' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/projeto',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Projeto',
                        'action' => 'listar',
                    ),
                ),
            ),
            //Rota cadastrar projeto
            'projeto-cadastrar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/projeto-cadastrar',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Projeto',
                        'action' => 'cadastrar',
                    ),
                ),
            ),
            //Rota editar projeto
            'projeto-editar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/projeto-editar[/:cod_projeto]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Projeto',
                        'action' => 'editar',
                    ),
                ),
            ),
            //Rota excluir projeto
            'projeto-excluir' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/projeto-excluir[/:cod_projeto]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Projeto',
                        'action' => 'excluir',
                    ),
                ),
            ),
            /*             * ************* ROTAS PARA SPRINTBACKLOG ************** */
            //rota para tela sprintbacklog
            'sprintbacklog' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/sprintbacklog',
                    'defaults' => array(
                        'controller' => 'Application\Controller\SprintBacklog',
                        'action' => 'index',
                    ),
                ),
            ),
            
            //Rota cadastrar product backlog
            'productbacklog-cadastrar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/projeto[/:cod_projeto]/productbacklog-cadastrar',
                    'defaults' => array(
                        'controller' => 'Application\Controller\ProductBacklog',
                        'action' => 'cadastrar',
                    ),
                ),
            ),
            
            /*             * ************* ROTAS PARA SPRINT ************** */

            //rota para tela sprint
            'sprint' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/projeto[/:cod_projeto]/sprint',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Sprint',
                        'action' => 'listar',
                    ),
                ),
            ),
            //Rota cadastrar sprint
            'sprint-cadastrar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/projeto[/:cod_projeto]/sprint-cadastrar',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Sprint',
                        'action' => 'cadastrar',
                    ),
                ),
            ),
            //Rota editar sprint
            'sprint-editar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/projeto[/:cod_projeto]/sprint-editar[/:cod_sprint]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Sprint',
                        'action' => 'editar',
                    ),
                ),
            ),
            //Rota excluir sprint
            'sprint-excluir' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/projeto[/:cod_projeto]/sprint-excluir[/:cod_sprint]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Sprint',
                        'action' => 'excluir',
                    ),
                ),
            ),
        /*         * ************* ROTAS PARA USUARIO ************** */
        //rota para tela usuario
//            'usuario' => array(
//                'type' => 'Literal', //criarContaProductOwner
//                'options' => array(
//                    'route'    => '/usuario',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Usuario',
//                        'action'     => 'index',
//                    ),
//                ),
//            ),
        // The following is a route to simplify getting started creating
        // new controllers and actions without needing to create a new
        // module. Simply drop new controllers in, and you can access them
        // using the path /application/:controller/:action
//*** 
//            'application' => array(
//                'type'    => 'Literal',
//                'options' => array(
//                    'route'    => '/application',
//                    'defaults' => array(
//                        '__NAMESPACE__' => 'Application\Controller',
//                        'controller'    => 'Index',
//                        'action'        => 'index',
//                    ),
//                ),
//                'may_terminate' => true,
//                'child_routes' => array(
//                    'default' => array(
//                        'type'    => 'Segment',
//                        'options' => array(
//                            'route'    => '/[:controller[/:action]]',
//                            'constraints' => array(
//                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
//                            ),
//                            'defaults' => array(
//                            ),
//                        ),
//                    ),
//                ),
//            ),
//***
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    /** invocando os controllers */
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Login' => 'Application\Controller\LoginController',
            'Application\Controller\Participante' => 'Application\Controller\ParticipanteController',
            'Application\Controller\ParticipanteProjeto' => 'Application\Controller\ParticipanteProjetoController',
            'Application\Controller\ProductBacklog' => 'Application\Controller\ProductBacklogController',
            'Application\Controller\Projeto' => 'Application\Controller\ProjetoController',
            'Application\Controller\SprintBacklog' => 'Application\Controller\SprintBacklogController',
            'Application\Controller\Sprint' => 'Application\Controller\SprintController',
        ),
    ),
    /** invocando a(s) view helper(s) */
    'view_helpers' => array(
        'invokables' => array(
            'Notificacoes' => 'Application\View\Helper\Notificacoes',
//                    'MascaraCpf' => 'Application\View\Helper\MESCpf',    
//                    'LimpaMascaraCpf' => 'Application\View\Helper\MESCpf',    
        ),
    ),
    /** invocando o(s) plugin(s) */
    'controller_plugins' => array(
        'invokables' => array(
            'ACLPermitir' => 'Application\Controller\ActionHelper\MESACL',
            'Email' => 'Application\Controller\ActionHelper\MESEmail',
//           'LimpaMascaraCpf' => 'Application\Controller\ActionHelper\MESCpf',    
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
