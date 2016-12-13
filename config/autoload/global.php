<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

/*
 *  conexão com o banco de dados
 */
return array(
    'db' => array (
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=mes;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
        'username'       => 'root',
        'password'       => ''
        ),
        //configuração do service manager - adaptador do banco de dados
        'service_manager' => array(
            'factories' => array(
                'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
                'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory'
            ),
           
        ),
    );
