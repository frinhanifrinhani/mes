<?php

namespace Application\Controller\ActionHelper;

use Zend\Permissions\Acl\Acl as BaseAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class ACL extends BaseAcl {

    public function __construct() {

        $this->addRole(new Role('Scrum Team'));
        $this->addRole(new Role('Scrum Master'));
        $this->addRole(new Role('Product Owner'));

        $this->addResource(new Resource('Application\Controller\Index'));
        $this->addResource(new Resource('Application\Controller\Participante'));
        $this->addResource(new Resource('Application\Controller\Projeto'));
        $this->addResource(new Resource('Application\Controller\ProductBacklog'));
        $this->addResource(new Resource('Application\Controller\SprintBacklog'));
        $this->addResource(new Resource('Application\Controller\Sprint'));
        $this->addResource(new Resource('Application\Controller\ProductBacklogPorSprint'));


        //Scrum Team - 3
        $this->allow('Scrum Team', 'Application\Controller\Index', 'inicio');
        $this->allow('Scrum Team', 'Application\Controller\Participante', array('alterarsenha'));
        $this->allow('Scrum Team', 'Application\Controller\Projeto', array('listar', 'gerenciar'));
        $this->allow('Scrum Team', 'Application\Controller\Sprint', array('listar'));
        $this->allow('Scrum Team', 'Application\Controller\ProductBacklog', array('listar'));
        $this->allow('Scrum Team', 'Application\Controller\SprintBacklog', array('escolher', 'listar', 'cadastrar', 'editar')); //verificar excluir

        //Scrum Master - 2
        $this->allow('Scrum Master', 'Application\Controller\Index', 'inicio');
        $this->allow('Scrum Master', 'Application\Controller\Participante', array('listar', 'cadastrar', 'editar', 'excluir', 'alterarsenha'));
        $this->allow('Scrum Master', 'Application\Controller\Projeto', array('listar', 'gerenciar', 'relatorio'));
        $this->allow('Scrum Master', 'Application\Controller\Sprint', array('listar', 'cadastrar', 'editar', 'excluir')); //verificar editar e excluir
        $this->allow('Scrum Master', 'Application\Controller\ProductBacklog', array('listar'));
        $this->allow('Scrum Master', 'Application\Controller\SprintBacklog', array('escolher', 'listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow('Scrum Master', 'Application\Controller\ProductBacklogPorSprint', array('escolher', 'listar'));

        //Product Owner - 1
        $this->allow('Product Owner', 'Application\Controller\Index', 'inicio');
        $this->allow('Product Owner', 'Application\Controller\Participante', array('listar', 'cadastrar', 'editar', 'excluir', 'alterarsenha'));
        $this->allow('Product Owner', 'Application\Controller\Projeto', array('listar', 'cadastrar', 'editar', 'excluir', 'gerenciar', 'relatorio'));
        $this->allow('Product Owner', 'Application\Controller\Sprint', array('listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow('Product Owner', 'Application\Controller\ProductBacklog', array('listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow('Product Owner', 'Application\Controller\SprintBacklog', array('escolher', 'listar', 'cadastrar', 'editar', 'excluir'));
        $this->allow('Product Owner', 'Application\Controller\ProductBacklogPorSprint', array('escolher', 'listar'));
    }

}
