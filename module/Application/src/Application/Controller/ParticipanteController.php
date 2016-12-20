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
use Application\Model\Participante;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

class ParticipanteController extends AcessoController
{
    protected $participanteTable;
    
    //metodo que retorna pagina incial da funcionalidade Participante
    public function listarAction()
    {
        //utilizadação do metodo que verifica autenticação e perfil
        $this->permitir();
        //cria o Partial Loop (paginação) atravez do Service Manager 
        $partialLoop = $this->getSm()->get('viewhelpermanager')->get('PartialLoop');
        $partialLoop->setObjectKey('participante');
        //cria as rotas (cadastrar, editar,  deletar) para serem usadas na funcionalidade
        $urlCadastrar   = $this->url()->fromRoute('participante',array('action'=>'cadastrar'));
        $urlEditar      = $this->url()->fromRoute('participante',array('action'=>'editar'));
        $urlExcluir     = $this->url()->fromRoute('participante',array('action'=>'excluir'));
        
        $placeholder = $this->getSm()->get('viewhelpermanager')->get('placeholder');
        $placeholder('url')->editar = $urlEditar;
        $placeholder('url')->excluir = $urlExcluir;
        
        //instancia um objeto da DbSelect, passando como paramentro retorno da getParticipanteTable
        //para que os mesmos resultados possal criar a paginação atravéz de um objeto Paginator
        $pageAdapter = new DbSelect($this->getParticipanteTable()->fetchAllParticipantes(),$this->getParticipanteTable()->getSql());
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page',1))->setItemCountPerPage(5);
        //retorna dados apra a view
        return new ViewModel(array(
            'paginator'     => $paginator,
            'title'         => $this->setAndGetTitle(),
            'urlCadastrar'  => $urlCadastrar,
        ));
    }
    //metodo que retorna pagina de cadastro da funcionalidade Participante
    public function cadastrarAction()
    {
        return new ViewModel();
    }
    //metodo que retorna pagina de edição dos dados da funcionalidade Participante
    public function editarAction()
    {
        return new ViewModel();
    }
    //metodo que retorna pagina de exclusão dos dados da funcionalidade Participante
    public function excluirAction()
    {
        return new ViewModel();
    }

    //recupera e retorna a model PartticipanteTable
    public function getParticipanteTable()
    {
        if(!$this->participanteTable){
            $sm = $this->getServiceLocator();
            $this->participanteTable = $sm->get('Application\Model\ParticipanteTable');
        }
        return $this->participanteTable;   
        
    }
    //recupera e retorna o Service Manager
    private function getSm()
    {
        return $this->getEvent()->getApplication()->getServiceManager();
    }
    
    //retorna o titulo da funcionalidade através do Service Manager
    private function setAndGetTitle() {
        $title = 'Participantes';
        $headTitle = $this->getSm()->get('viewhelpermanager')->get('HeadTitle');
        $headTitle($title); 
        return $title;
    }
    
}
