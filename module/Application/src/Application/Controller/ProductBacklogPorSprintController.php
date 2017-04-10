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
use Application\Form\ProductBacklogPorSprintForm;
use Application\Model\ProductBacklogPorSprint;

class ProductBacklogPorSprintController extends AbstractActionController {

    protected $productBacklogPorSprintTable;
    protected $productBacklogTable;
    protected $sprintTable;
    protected $projetoTable;

    public function indexAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();

        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
        $sprint = $this->getSprintTable()->fetchAll($codProjeto);

        return new ViewModel(array(
            'partial_loop_sprint' => $sprint,
            'cod_projeto' => $codProjeto,
        ));
    }

    public function listarAction() {
//        metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();

        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
        $codSprint = (int) $this->params()->fromRoute('cod_sprint', null);
        $sprint = $this->getSprintTable()->fetchAll($codProjeto);
        $productBacklog = $this->getProductBacklogPorSprintTable()->fetchAll($codProjeto);
        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        $sprintCur = $this->getSprintTable()->getSprint($codSprint);
        
        $request = $this->getRequest();
        if ($request->isPost()) {

            $productBacklogPorSprint = new ProductBacklogPorSprint();

            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $productBacklogPorSprint->setDbAdapter($dbAdapter);

            $productBacklogPorSprint->exchangeArray($request->getPost());
            $retorno = $this->getProductBacklogPorSprintTable()->salvar($productBacklogPorSprint);
        }

        return new ViewModel(array(
            'partial_loop_sprint' => $sprint,
            'product_backlog' => $productBacklog,
            'cod_projeto' => $codProjeto,
            'cod_sprint' => $codSprint,
            'projeto' => $projeto,
            'sprint' => $sprintCur,
        ));
    }

    //recupera e retorna a model ProductBacklogTable
    public function getProjetoTable() {
        if (!$this->projetoTable) {
            $sm = $this->getServiceLocator();
            $this->projetoTable = $sm->get('Application\Model\ProjetoTable');
        }
        return $this->projetoTable;
    }
    public function getSprintTable() {
        if (!$this->sprintTable) {
            $sm = $this->getServiceLocator();
            $this->sprintTable = $sm->get('Application\Model\SprintTable');
        }
        return $this->sprintTable;
    }

    //recupera e retorna a model ProductBacklogTable
    public function getProductBacklogPorSprintTable() {
        if (!$this->productBacklogPorSprintTable) {
            $sm = $this->getServiceLocator();
            $this->productBacklogPorSprintTable = $sm->get('Application\Model\ProductBacklogPorSprintTable');
        }
        return $this->productBacklogPorSprintTable;
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
