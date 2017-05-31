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
use Application\Model\Projeto;
use Application\Form\ProjetoForm;
use DOMPDFModule\View\Model\PdfModel;

class ProjetoController extends AbstractActionController {

    protected $projetoTable;
    protected $sprintTable;
    protected $productBacklogTable;
    protected $sprintBacklogTable;

    public function listarAction() {

        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $projetos = $this->getProjetoTable()->fetchAll();
        //retorna dados pra a view
        return new ViewModel(array(
            'cod_tipo_participante'=> $this->ACLPermitir()->container()['cod_tipo_participante'],
            'partial_loop_listar' => $projetos,
        ));
    }

    //metodo que retorna pagina de cadastro da funcionalidade Projeto
    public function cadastrarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $ultimoProjeto = null;
        $formProjeto = new ProjetoForm();

        $request = $this->getRequest();

        if ($request->isPost()) {

            $projeto = new Projeto();

            $formProjeto->setInputFilter($projeto->getInputFilter());
            $formProjeto->setData($request->getPost());
            if ($formProjeto->isValid()) {

                $projeto->exchangeArray($formProjeto->getData());
                $retorno = $this->getProjetoTable()->salvar($projeto);
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'form_projeto' => $formProjeto,
        ));
    }

    //metodo que retorna pagina de edicao da funcionalidade Projeto
    public function editarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);

        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        if ($projeto == true) {
            $formProjeto = new ProjetoForm();
            $formProjeto->setData($projeto->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('projeto');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $projeto = new Projeto();

            $formProjeto->setData($request->getPost());

            if ($formProjeto->isValid()) {

                $projeto->exchangeArray($formProjeto->getData());
                $retornoCod = $this->getProjetoTable()->salvar($projeto);
                if ($retornoCod == 23000) {
                    $retorno = false;
                } else {
                    $retorno = true;
                }
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_projeto' => $codProjeto,
            'form_projeto' => $formProjeto,
        ));
    }

    //metodo que retorna pagina de exclusao da funcionalidade Projeto
    public function excluirAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);

        $projeto = $this->getProjetoTable()->getProjeto($codProjeto);
        if ($projeto == true) {
            $formProjeto = new ProjetoForm();
            $formProjeto->setData($projeto->getArrayCopy());
        } else {
            return $this->redirect()->toRoute('projeto');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $retornoCod = $this->getProjetoTable()->excluir($codProjeto);
            if ($retornoCod == 23000) {
                $retorno = false;
            } else {
                $retorno = true;
            }
        }

        return new ViewModel(array(
            'retorno' => $retorno,
            'cod_projeto' => $codProjeto,
            'form_projeto' => $formProjeto,
        ));
    }

    public function relatorioAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();

        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);

        $projeto = $this->getProjetoTable()->getProjetoJoin($codProjeto);
        $projetoDados = $projeto->getArrayCopy();
        $sprints = $this->getSprintTable()->fetchAll($codProjeto);
        $productBacklogs = $this->getProductBacklogTable()->fetchAll($codProjeto);
        $sprintBacklogs = $this->getSprintBacklogTable()->fetchAll($codProjeto);

        $dadosSprint = $this->getSprintTable()->retornarDadosSprint($codProjeto);
        $dadosProductBacklog = $this->getProductBacklogTable()->retornarDadosProductBacklog($codProjeto);
        $dadosSprintBacklog = $this->getSprintBacklogTable()->retornarDadosSprintBacklog($codProjeto);

        $pdf = new PdfModel();
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d-m-Y_Hi');
        $nomeArquivo = "Relatorio_do_Projeto_{$data}";
        // $pdf->setOption("filename", $nomeArquivo);
        $pdf->setOption('paperSize', 'a4');
        $pdf->setOption('paperOrientation', 'portrait');

        $pdf->setVariables(array(
            'dados_projeto' => $projetoDados,
            'sprints' => $sprints,
            'productBacklogs' => $productBacklogs,
            'sprintBacklogs' => $sprintBacklogs,
            'dados_sprint' => $dadosSprint,
            'dados_product_backlog' => $dadosProductBacklog,
            'dados_sprint_backlog' => $dadosSprintBacklog,
        ));

        return $pdf;
    }

    //metodo que retorna pagina gerenciar projeto funcionalidade Projeto
    public function gerenciarAction() {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $retorno = false;
        $codProjeto = (int) $this->params()->fromRoute('cod_projeto', null);

        $projeto = $this->getProjetoTable()->getProjetoJoin($codProjeto);

        if ($projeto == true) {
            $projetoDados = $projeto->getArrayCopy();
            $dadosSprint = $this->getSprintTable()->retornarDadosSprint($codProjeto);
            $dadosProductBacklog = $this->getProductBacklogTable()->retornarDadosProductBacklog($codProjeto);
            $dadosSprintBacklog = $this->getSprintBacklogTable()->retornarDadosSprintBacklog($codProjeto);
        } else {
            return $this->redirect()->toRoute('projeto');
        }

        return new ViewModel(array(
            'dados_sprint' => $dadosSprint,
            'dados_product_backlog' => $dadosProductBacklog,
            'dados_sprint_backlog' => $dadosSprintBacklog,
            'retorno' => $retorno,
            'cod_projeto' => $codProjeto,
            'projetos' => $projetoDados,
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

    //recupera e retorna a model SprintTable
    public function getSprintTable() {
        if (!$this->sprintTable) {
            $sm = $this->getServiceLocator();
            $this->sprintTable = $sm->get('Application\Model\SprintTable');
        }
        return $this->sprintTable;
    }

    //recupera e retorna a model ProductBacklogTable
    public function getProductBacklogTable() {
        if (!$this->productBacklogTable) {
            $sm = $this->getServiceLocator();
            $this->productBacklogTable = $sm->get('Application\Model\ProductBacklogTable');
        }
        return $this->productBacklogTable;
    }

    //recupera e retorna a model SprintBacklogTable
    public function getSprintBacklogTable() {
        if (!$this->sprintBacklogTable) {
            $sm = $this->getServiceLocator();
            $this->sprintBacklogTable = $sm->get('Application\Model\SprintBacklogTable');
        }
        return $this->sprintBacklogTable;
    }

    //recupera e retorna o Service Manager
    private function getSm() {
        return $this->getEvent()->getApplication()->getServiceManager();
    }

}
