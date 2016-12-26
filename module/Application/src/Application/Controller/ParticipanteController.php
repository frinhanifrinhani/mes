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

class ParticipanteController extends AbstractActionController 
{

    protected $participanteTable;

    //metodo que retorna pagina incial da funcionalidade Participante
    public function listarAction() {

        //metodo que verifica autenticação e perfil
        $this->ACLpermitir()->permitir();
        $participantes = $this->getParticipanteTable()->fetchAllParticipantes();
        //retorna dados apra a view
        return new ViewModel(array(
            'partial_loop_listar' => $participantes,
            'title' => $this->setAndGetTitle(),
        ));
    }

    //metodo que retorna pagina de cadastro da funcionalidade Participante
    public function cadastrarAction() {
        return new ViewModel();
    }

    //metodo que retorna pagina de edição dos dados da funcionalidade Participante
    public function editarAction() {
        $cod_participante = (int) $this->params()->fromRoute('cod_participante', null);
        var_dump($cod_participante);
        exit();
        return new ViewModel();
    }

    //metodo que retorna pagina de exclusão dos dados da funcionalidade Participante
    public function excluirAction() {
        return new ViewModel();
    }

    //recupera e retorna a model PartticipanteTable
    public function getParticipanteTable() {
        if (!$this->participanteTable) {
            $sm = $this->getServiceLocator();
            $this->participanteTable = $sm->get('Application\Model\ParticipanteTable');
        }
        return $this->participanteTable;
    }

    //recupera e retorna o Service Manager
    private function getSm() {
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
