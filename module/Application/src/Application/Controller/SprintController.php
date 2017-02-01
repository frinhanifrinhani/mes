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

    public function listarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $sprints = $this->getSprintTable()->fetchAll();

        return new ViewModel(array(
            'partial_loop_listar' => $sprints,
        ));
    }

    public function cadastrarAction() {
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $ultimoSprint = null;
        $formSprint = new SprintForm();

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

                $ultimoSprint = $this->getSprintTable()->getLastId();
            }
        }

        return new ViewModel(array(
            'ultimoSprin' => $ultimoSprint,
            'retorno' => $retorno,
            'form_sprint' => $formSprint,
        ));
    }

    public function editarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $codSprint = (int) $this->params()->fromRoute('cod_sprint', null);

        $sprint = $this->getSprintTable()->getSprint($codSprint);
        if ($sprint == true) {
            $formSprint = new SprintForm();
            $formSprint->setData($sprint->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('sprint');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $sprint = new Sprint();


            $formSprint->setData($request->getPost());

            if ($formSprint->isValid()) {

                $sprint->exchangeArray($formSprint->getData());
                $retorno = $this->getSprintTable()->salvar($sprint);

                $ultimoSprint = $this->getSprintTable()->getLastId();
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_sprint' => $codSprint,
            'form_sprint' => $formSprint,
        ));
    }

    //metodo que retorna pagina de exclusão dos dados da funcionalidade Sprint
    public function excluirAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $codSprint = (int) $this->params()->fromRoute('cod_sprint', null);

        $sprint = $this->getSprintTable()->getSprint($codSprint);

        if ($sprint == true) {
            $formSprint = new SprintForm();
            $formSprint->setData($sprint->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('sprint');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $retorno = $this->getSprintTable()->excluir($codSprint);
            //return $this->redirect()->toRoute('sprint');
        }

        return new ViewModel(array(
            'retorno' => $retorno,
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

}
