<?php

namespace Application\Controller\ActionHelper;

use Zend\Permissions\Acl\Acl as BaseAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class ACL extends BaseAcl {

    public function __construct() {
//        $this->addRole(new Role('3'));
//        $this->addRole(new Role('2'), '3');
//        $this->addRole(new Role('1'), '2');

        $this->addRole(new Role('scrumteam'));
        $this->addRole(new Role('scrummaster'));
        $this->addRole(new Role('productowner'));

//        
//        $this->addResource(new Resource('IndexController'));
//        $this->addResource(new Resource('ParticipanteController'));
//        $this->addResource(new Resource('ProjetoController'));

        $this->addResource(new Resource('Application\Controller\Index'));
        $this->addResource(new Resource('Application\Controller\Participante'));
        $this->addResource(new Resource('Application\Controller\Projeto'));
        $this->addResource(new Resource('Application\Controller\ProductBacklog'));
        $this->addResource(new Resource('Application\Controller\SprintBacklog'));
        $this->addResource(new Resource('Application\Controller\Sprint'));
        $this->addResource(new Resource('Application\Controller\ProductBacklogPorSprint'));


        //Scrum Team - 3
        $this->allow('scrumteam', 'Application\Controller\Index', 'inicio');
        $this->allow('scrumteam', 'Application\Controller\Participante', array('alterarsenha'));
        $this->allow('scrumteam', 'Application\Controller\Projeto', array('listar', 'gerenciar'));
        $this->allow('scrumteam', 'Application\Controller\Sprint', array('listar'));
        $this->allow('scrumteam', 'Application\Controller\ProductBacklog', array('listar'));
        $this->allow('scrumteam', 'Application\Controller\SprintBacklog', array('escolher', 'listar', 'cadastrar', 'editar')); //verificar excluir

        //Scrum Master - 2
        $this->allow('scrummaster', 'Application\Controller\Index', 'inicio');
        $this->allow('scrummaster', 'Application\Controller\Participante', array('listar', 'cadastrar', 'editar', 'excluir', 'alterarsenha'));
        $this->allow('scrummaster', 'Application\Controller\Projeto', array('listar', 'gerenciar', 'relatorio'));
        $this->allow('scrummaster', 'Application\Controller\Sprint', array('listar', 'cadastrar', 'editar', 'excluir')); //verificar editar e excluir
        $this->allow('scrummaster', 'Application\Controller\ProductBacklog', array('listar'));
        $this->allow('scrummaster', 'Application\Controller\SprintBacklog', array('escolher', 'listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow('scrummaster', 'Application\Controller\ProductBacklogPorSprint', array('escolher', 'listar'));

        //Product Owner - 1
        $this->allow('productowner', 'Application\Controller\Index', 'inicio');
        $this->allow('productowner', 'Application\Controller\Participante', array('listar', 'cadastrar', 'editar', 'excluir', 'alterarsenha'));
        $this->allow('productowner', 'Application\Controller\Projeto', array('listar', 'cadastrar', 'editar', 'excluir', 'gerenciar', 'relatorio'));
        $this->allow('productowner', 'Application\Controller\Sprint', array('listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow('productowner', 'Application\Controller\ProductBacklog', array('listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow('productowner', 'Application\Controller\SprintBacklog', array('escolher', 'listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow('productowner', 'Application\Controller\ProductBacklogPorSprint', array('escolher', 'listar'));
    }

}
