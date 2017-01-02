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
use Application\Form\UsuarioForm;
use Application\Form\ParticipanteForm;

class UsuarioController extends AbstractActionController 
{
     protected $participanteTable;
     
    public function indexAction()
    {
        //metodo que verifica autenticação e perfil
        $this->ACLPermitir()->permitir();
        return new ViewModel();
    }
    
    public function criarContaProductOwnerAction()
    {
        $this->layout('layout/layout_cadastro');
        $formParticipante = new ParticipanteForm();
        
        $retorno = false;

        $request = $this->getRequest();

        if ($request->isPost()) {
            $participante = new Participante();
            $formParticipante->setInputFilter($participante->getInputFilter());
            $formParticipante->setData($request->getPost());
            if ($formParticipante->isValid()) {
                $participante->exchangeArray($formParticipante->getData());
                //$retorno = $this->getParticipanteTable()->salvar($participante);
                //$ultimoParticipante = $this->getParticipanteTable()->getLastId();
                $retorno = true;

            }
        }
        
    
        
        
        return new ViewModel(array(
            'form_participante'=> $formParticipante,
             'retorno' => $retorno,
        ));
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
