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
use Application\Form\ProductBacklogForm;
//use Application\Model\ProductBacklog;

class ProductBacklogController extends AbstractActionController
{
//    public function indexAction()
//    {
//        //metodo que verifica autenticação e perfil
//        $this->ACLPermitir()->permitir();
//        return new ViewModel();
//    }
    
    protected $productBacklogTable;
    protected $projetoTable;

    public function listarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();

        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);

        $productBacklog = $this->getProductBacklogTable()->fetchAll($codProjeto);

        return new ViewModel(array(
            'partial_loop_listar' => $productBacklog,
            'cod_projeto' => $codProjeto,
        ));
    }
    
    public function cadastrarAction() {
        $this->ACLPermitir()->permitir();
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
//        $retorno = false;
//        $ultimoSprint = null;
        $formProductBacklog = new ProductBacklogForm();
//
//        $request = $this->getRequest();
//        if ($request->isPost()) {
//
//            $sprint = new Sprint();
//
//            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
//            $sprint->setDbAdapter($dbAdapter);
//
//            $formSprint->setInputFilter($sprint->getInputFilter());
//            $formSprint->setData($request->getPost());
//
//            if ($formSprint->isValid()) {
//
//                $sprint->exchangeArray($formSprint->getData());
//                $retorno = $this->getSprintTable()->salvar($sprint);
//
//                $ultimoSprint = $this->getSprintTable()->getLastId();
//            }
//        }
//
//        $projetos = $this->getProjetoTable()->fetchAll($this->ACLPermitir()->container()['cod_participante']);
//        return new ViewModel(array(
//            'partial_loop_projetos' => $projetos,
//            'cod_projeto' => $codProjeto,
//            'cod_participante' => $this->ACLPermitir()->container()['cod_participante'],
//            'ultimoSprint' => $ultimoSprint,
//            'retorno' => $retorno,
//            'form_sprint' => $formSprint,
//        ));
//    }


        return new ViewModel(array(
//            'retorno' => $retorno,
//            'cod_sprint' => $codSprint,
            //'cod_projeto' => $codProjeto,
            'form_productbacklog' => $formProductBacklog,
        ));
    }
    
    
    //recupera e retorna a model ProductBacklogTable
    public function getProductBacklogTable() {
        if (!$this->productBacklogTable) {
            $sm = $this->getServiceLocator();
            $this->productBacklogTable = $sm->get('Application\Model\ProductBacklogTable');
        }
        return $this->productBacklogTable;
    }

    //recupera e retorna a model ProjetoTable
    public function getProjetoTable() {
        if (!$this->projetoTable) {
            $sm = $this->getServiceLocator();
            $this->projetoTable = $sm->get('Application\Model\ProjetoTable');
        }
        return $this->projetoTable;
    }
    
    //recupera e retorna o Service Manager
    private function getSm() {
        return $this->getEvent()->getApplication()->getServiceManager();
    }

}
