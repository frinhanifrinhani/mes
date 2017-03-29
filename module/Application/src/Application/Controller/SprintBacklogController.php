<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\SprintBacklogForm;
use Application\Model\Projeto;
use Application\Model\SprintBacklog;

class SprintBacklogController extends AbstractActionController {

    protected $projetoTable;
    protected $sprintBacklogTable;
    protected $productBacklogTable;

    public function escolherAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $projetos = $this->getProjetoTable()->fetchAll();
//        $codProjeto = $this->getProjetoTable()->getProjeto();
        return new ViewModel(array(
            'partial_loop_projetos' => $projetos,
                //'nome_participante' => $this->ACLPermitir()->container()['nome_participante'],
        ));
    }

    public function listarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();

        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
        //$this->Redirecionamento()->redirecionarParaProjeto($codProjeto);

        $sprintBacklog = $this->getSprintBacklogTable()->fetchAll($codProjeto);

        return new ViewModel(array(
            'partial_loop_listar' => $sprintBacklog,
            'cod_projeto' => $codProjeto,
        ));
    }

    public function cadastrarAction() {
        $this->ACLPermitir()->permitir();
        $retorno = false;

        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
//        $this->Redirecionamento()->redirecionarParaProjeto($codProjeto);
        $formSprintBacklog = new SprintBacklogForm();
        
        $productBacklog = $this->getProductBacklogTable()->fetchAll($codProjeto);

        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $sprintBacklog = new SprintBacklog();
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $sprintBacklog->setDbAdapter($dbAdapter);
            $formSprintBacklog->setInputFilter($sprintBacklog->getInputFilter());
            $formSprintBacklog->setData($request->getPost());
//
            if ($formSprintBacklog->isValid()) {
                $sprintBacklog->exchangeArray($formSprintBacklog->getData());
                $retorno = $this->getSprintBacklogTable()->salvar($sprintBacklog);
//
//                $ultimoProductBacklog = $this->getProductBacklogTable()->getLastId();
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'partial_loop_product_backlog' => $productBacklog,
//            'cod_sprint' => $codSprint,
            'cod_projeto' => $codProjeto,
            'form_sprint_backlog' => $formSprintBacklog,
        ));
    }

    public function editarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
        $codSprintBacklog = (int) $this->params()->fromRoute('cod_sprint_backlog', null);

        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        //$productBacklog = $this->getProductBacklogTable()->fetchAll($codProjeto);

        $sprintBacklog = $this->getSprintBacklogTable()->getSprintBacklog($codSprintBacklog);
//        $this->Redirecionamento()->redirecionarParaProjeto($projeto);

        if ($sprintBacklog == true) {
            $formSprintBacklog = new SprintBacklogForm();
            $formSprintBacklog->setData($sprintBacklog->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('sprint-backlog', array('cod_projeto' => $codProjeto));
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $sprintBacklog = new SprintBacklog();

            $formSprintBacklog->setData($request->getPost());

            if ($formSprintBacklog->isValid()) {

                $sprintBacklog->exchangeArray($formSprintBacklog->getData());
                $retorno = $this->getSprintBacklogTable()->salvar($sprintBacklog);
            }
        }

        return new ViewModel(array(
            //'partial_loop_product_backlog' => $productBacklog,
            'retorno' => $retorno,
            'cod_sprint_backlog' => $codSprintBacklog,
            'cod_projeto' => $codProjeto,
            'form_sprint_backlog' => $formSprintBacklog,
        ));
    }
    
    //metodo que retorna pagina de exclusão dos dados da funcionalidade Sprint Backlog
    public function excluirAction() {
        //ActionHelper que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
        $codSprintBacklog = (int) $this->params()->fromRoute('cod_sprint_backlog', null);

        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        $sprintBacklog = $this->getSprintBacklogTable()->getSprintBacklog($codSprintBacklog);

        $this->Redirecionamento()->redirecionarParaProjeto($codProjeto);

        if ($sprintBacklog == true) {
            $formSprintBacklog = new SprintBacklogForm();
            $formSprintBacklog->setData($sprintBacklog->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('sprintbacklog', array('cod_projeto' => $codProjeto));
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $retorno = $this->getSprintBacklogTable()->excluir($codSprintBacklog);
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_projeto' => $codProjeto,
            'cod_sprint_backlog' => $codSprintBacklog,
            'form_sprint_backlog' => $formSprintBacklog,
        ));
    }

    //recupera e retorna a model ProjetoTable
    public function getProjetoTable() {
        if (!$this->projetoTable) {
            $sm = $this->getServiceLocator();
            $this->projetoTable = $sm->get('Application\Model\ProjetoTable');
        }
        return $this->projetoTable;
    }

    //recupera e retorna a model SprintBacklogTable
    public function getSprintBacklogTable() {
        if (!$this->sprintBacklogTable) {
            $sm = $this->getServiceLocator();
            $this->sprintBacklogTable = $sm->get('Application\Model\SprintBacklogTable');
        }
        return $this->sprintBacklogTable;
    }

    //recupera e retorna a model ProductBacklogTable
    public function getProductBacklogTable() {
        if (!$this->productBacklogTable) {
            $sm = $this->getServiceLocator();
            $this->productBacklogTable = $sm->get('Application\Model\ProductBacklogTable');
        }
        return $this->productBacklogTable;
    }

    //recupera e retorna o Service Manager
    private function getSm() {
        return $this->getEvent()->getApplication()->getServiceManager();
    }

}
