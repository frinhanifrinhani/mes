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
use Zend\Paginator\Adapter\ArrayAdapter;
use \Application\Form\ParticipanteForm;
class ParticipanteController extends AbstractActionController 
{

    protected $participanteTable;

    //metodo que retorna pagina incial da funcionalidade Participante
    public function listarAction() {

        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        $participantes = $this->getParticipanteTable()->fetchAll();
        //retorna dados pra a view
        return new ViewModel(array(
            'partial_loop_listar' => $participantes,
        ));
    }

    //metodo que retorna pagina de cadastro da funcionalidade Participante
    public function cadastrarAction() {
        $formParticipante = new ParticipanteForm();

//        $formParticipante->get('botao_salvar')->setValue('Salvar');
        $request = $this->getRequest();
        if($request->isPost()){
            $participante = new Participante();
            $formParticipante->setInputFilter($participante->getInputFilter());
            $formParticipante->setData($request->getPost());
            if($formParticipante->isValid()){
                
                $participante->exchangeArray($formParticipante->getData());
//                var_dump($participante);
                $this->getParticipanteTable()->salvar($participante);
                //return $this->redirect()->toRoute('lanterna');
            }
        }
        
        
//        $request = $this->getRequest();
//        if($request->isPost()){
//           $data;
//        }
        return new ViewModel(array(
            'form_participante' => $formParticipante,
        ));
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

}
