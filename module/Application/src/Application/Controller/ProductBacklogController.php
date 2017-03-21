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
use Application\Model\ProductBacklog;

class ProductBacklogController extends AbstractActionController {

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

        $retorno = false;
//        $ultimoSprint = null;
        $formProductBacklog = new ProductBacklogForm();
//
        $request = $this->getRequest();
        if ($request->isPost()) {
            $productBacklog = new ProductBacklog();

            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $productBacklog->setDbAdapter($dbAdapter);

            $formProductBacklog->setInputFilter($productBacklog->getInputFilter());
            $formProductBacklog->setData($request->getPost());

            if ($formProductBacklog->isValid()) {
                $productBacklog->exchangeArray($formProductBacklog->getData());
                $retorno = $this->getProductBacklogTable()->salvar($productBacklog);

//                $ultimoProductBacklog = $this->getProductBacklogTable()->getLastId();
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
//            'cod_sprint' => $codSprint,
            'cod_projeto' => $codProjeto,
            'form_productbacklog' => $formProductBacklog,
        ));
    }
    
    public function editarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
        $codProductBacklog = (int) $this->params()->fromRoute('cod_productbacklog', null);

        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        $productBacklog = $this->getProductBacklogTable()->getProductBacklog($codProductBacklog);
        $productBacklog = $this->getProductBacklogTable()->getProductBacklog($codProductBacklog);


        $this->Redirecionamento()->redirecionarParaProjeto($projeto);

        if ($productBacklog == true) {
            $formProductBacklog = new ProductBacklogForm();
            $formProductBacklog->setData($productBacklog->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('productbacklog', array('cod_projeto' => $codProjeto));
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $productBacklog = new ProductBacklog();

            $formProductBacklog->setData($request->getPost());

            if ($formProductBacklog->isValid()) {

                $productBacklog->exchangeArray($formProductBacklog->getData());
                $retorno = $this->getProductBacklogTable()->salvar($productBacklog);
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_productbacklog' => $codProductBacklog,
            'cod_projeto' => $codProjeto,
            'form_productbacklog' => $formProductBacklog,
        ));
    }
    
    //metodo que retorna pagina de exclusão dos dados da funcionalidade ProductBacklog
    public function excluirAction() {
        //ActionHelper que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);
        $codProductBacklog = (int) $this->params()->fromRoute('cod_productbacklog', null);

        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        $productBacklog = $this->getProductBacklogTable()->getProductBacklog($codProductBacklog);

        $this->Redirecionamento()->redirecionarParaProjeto($codProjeto);

        if ($productBacklog == true) {
            $formProductBacklog = new ProductBacklogForm();
            $formProductBacklog->setData($productBacklog->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('productbacklog', array('cod_projeto' => $codProjeto));
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $retorno = $this->getProductBacklogTable()->excluir($codProductBacklog);
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_projeto' => $codProjeto,
            'cod_productbacklog' => $codProductBacklog,
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
