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
use Application\Form\SprintForm;
use Application\Model\Sprint;

class SprintController extends AbstractActionController {

    protected $sprintTable;
    protected $projetoTable;

    public function listarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();

        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);

        $this->Redirecionamento()->redirecionarParaProjeto($codProjeto);

        $sprints = $this->getSprintTable()->fetchAll($codProjeto);

        return new ViewModel(array(
            'partial_loop_listar' => $sprints,
            'cod_projeto' => $codProjeto,
        ));
    }

    public function cadastrarAction() {
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $this->Redirecionamento()->redirecionarParaProjeto($codProjeto);
        $formSprint = new SprintForm();
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);

        $request = $this->getRequest();
        if ($request->isPost()) {

            $sprint = new Sprint();

            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $sprint->setDbAdapter($dbAdapter);

            $formSprint->setInputFilter($sprint->getInputFilter());
            $formSprint->setData($request->getPost());

            if ($formSprint->isValid()) {

                $sprint->exchangeArray($formSprint->getData());
                $retorno = $this->getSprintTable()->salvar($sprint);
            }
        }
//        $projetos = $this->getProjetoTable()->fetchAll($this->ACLPermitir()->container()['cod_participante']);
        return new ViewModel(array(
//            'partial_loop_projetos' => $projetos,
            'cod_projeto' => $codProjeto,
            'cod_participante' => $this->ACLPermitir()->container()['cod_participante'],
            'retorno' => $retorno,
            'form_sprint' => $formSprint,
        ));
    }

    public function editarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
        $codSprint = (int) $this->params()->fromRoute('cod_sprint', null);

        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        $sprint = $this->getSprintTable()->getSprint($codSprint);
        $sprint = $this->getSprintTable()->getSprint($codSprint);


        $this->Redirecionamento()->redirecionarParaProjeto($projeto);

        if ($sprint == true) {
            $formSprint = new SprintForm();
            $formSprint->setData($sprint->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('sprint', array('cod_projeto' => $codProjeto));
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $sprint = new Sprint();

            $formSprint->setData($request->getPost());

            if ($formSprint->isValid()) {

                $sprint->exchangeArray($formSprint->getData());
                $retorno = $this->getSprintTable()->salvar($sprint);
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_sprint' => $codSprint,
            'cod_projeto' => $codProjeto,
            'form_sprint' => $formSprint,
        ));
    }

    //metodo que retorna pagina de exclusão dos dados da funcionalidade Sprint
    public function excluirAction() {
        //ActionHelper que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
        $codSprint = (int) $this->params()->fromRoute('cod_sprint', null);

        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        $sprint = $this->getSprintTable()->getSprint($codSprint);

        $this->Redirecionamento()->redirecionarParaProjeto($codProjeto);

        if ($sprint == true) {
            $formSprint = new SprintForm();
            $formSprint->setData($sprint->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('sprint', array('cod_projeto' => $codProjeto));
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $retorno = $this->getSprintTable()->excluir($codSprint);
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_projeto' => $codProjeto,
            'cod_sprint' => $codSprint,
            'form_sprint' => $formSprint,
        ));
    }

    //recupera e retorna a model SprintTable
    public function getSprintTable() {
        if (!$this->sprintTable) {
            $sm = $this->getServiceLocator();
            $this->sprintTable = $sm->get('Application\Model\SprintTable');
        }
        return $this->sprintTable;
    }

    //recupera e retorna o Service Manager
    private function getSm() {
        return $this->getEvent()->getApplication()->getServiceManager();
    }

    //recupera e retorna a model ProjetoTable
    public function getProjetoTable() {
        if (!$this->projetoTable) {
            $sm = $this->getServiceLocator();
            $this->projetoTable = $sm->get('Application\Model\ProjetoTable');
        }
        return $this->projetoTable;
    }

}
