<?php

namespace Application\Controller\ActionHelper;

use Zend\Permissions\Acl\Acl as BaseAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class ACL extends BaseAcl {

    public function __construct() {

        /*
         * 1 - Product Owner
         * 2 - Scrum Master
         * 3 - Scrum Team 
         */
        $this->addRole(new Role(3));
        $this->addRole(new Role(2));
        $this->addRole(new Role(1));

        $this->addResource(new Resource('Application\Controller\Index'));
        $this->addResource(new Resource('Application\Controller\Participante'));
        $this->addResource(new Resource('Application\Controller\Projeto'));
        $this->addResource(new Resource('Application\Controller\ProductBacklog'));
        $this->addResource(new Resource('Application\Controller\SprintBacklog'));
        $this->addResource(new Resource('Application\Controller\Sprint'));
        $this->addResource(new Resource('Application\Controller\ProductBacklogPorSprint'));

        //Scrum Team - 3
        $this->allow(3, 'Application\Controller\Index', 'inicio');
        $this->allow(3, 'Application\Controller\Participante', array('alterarsenha'));
        $this->allow(3, 'Application\Controller\Projeto', array('listar', 'gerenciar'));
        $this->allow(3, 'Application\Controller\Sprint', array('listar'));
        $this->allow(3, 'Application\Controller\ProductBacklog', array('listar'));
        $this->allow(3, 'Application\Controller\SprintBacklog', array('escolher', 'listar', 'cadastrar', 'editar')); //verificar excluir

        //Scrum Master - 2
        $this->allow(2, 'Application\Controller\Index', 'inicio');
        $this->allow(2, 'Application\Controller\Participante', array('listar', 'cadastrar', 'editar', 'excluir', 'alterarsenha'));
        $this->allow(2, 'Application\Controller\Projeto', array('listar', 'gerenciar', 'relatorio'));
        $this->allow(2, 'Application\Controller\Sprint', array('listar', 'cadastrar', 'editar', 'excluir')); //verificar editar e excluir
        $this->allow(2, 'Application\Controller\ProductBacklog', array('listar'));
        $this->allow(2, 'Application\Controller\SprintBacklog', array('escolher', 'listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow(2, 'Application\Controller\ProductBacklogPorSprint', array('escolher', 'listar'));

        //Product Owner - 1
        $this->allow(1, 'Application\Controller\Index', 'inicio');
        $this->allow(1, 'Application\Controller\Participante', array('listar', 'cadastrar', 'editar', 'excluir', 'alterarsenha'));
        $this->allow(1, 'Application\Controller\Projeto', array('listar', 'cadastrar', 'editar', 'excluir', 'gerenciar', 'relatorio'));
        $this->allow(1, 'Application\Controller\Sprint', array('listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow(1, 'Application\Controller\ProductBacklog', array('listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow(1, 'Application\Controller\SprintBacklog', array('escolher', 'listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow(1, 'Application\Controller\ProductBacklogPorSprint', array('escolher', 'listar'));
    }

}
