<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;
use Application\Controller\SprintBacklogController;

class SprintBacklogForm extends Form {

    public $statusTable;
    public $participanteTable;
    public $productBacklogTable;

    public function __construct() {
        parent::__construct('form_sprint_backlog');

        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'form_sprint_backlog');

        $this->add(array(
            'name' => 'cod_sprint_backlog',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'cod_sprint_backlog',
                'class' => 'form-control',
                'placeholder' => 'Código da Sprint Backlog',
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => 'Código Sprint Backlog',
            ),
        ));

        $this->add(array(
            'name' => 'nome_sprint_backlog',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'nome_sprint_backlog',
                'class' => 'form-control',
                'placeholder' => 'Nome da Sprint Backlog',
            ),
            'options' => array(
                'label' => 'Nome Sprint Backlog *',
            ),
        ));

        $this->add(array(
            'name' => 'descricao_sprint_backlog',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'descricao_sprint_backlog',
                'class' => 'form-control',
                'placeholder' => 'Descrição da Sprint Backlog',
            ),
            'options' => array(
                'label' => 'Descrição Sprint Backlog',
            ),
        ));

        $this->add(array(
            'name' => 'tempo_sprint_backlog',
            'type' => 'text',
            'attributes' => array(
                'id' => 'tempo_sprint_backlog',
                'class' => 'form-control',
                'placeholder' => '00:00',
            ),
            'options' => array(
                'label' => 'Tempo de duração *',
            ),
        ));

        $this->add(array(
            'name' => 'cod_projeto',
            'type' => 'text',
            'attributes' => array(
                'id' => 'cod_projeto',
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'cod_status',
            'type' => 'Select',
            'attributes' => array(
                'id' => 'cod_status',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Status',
                'value_options' => $this->getValueStatusOptions(),
            ),
        ));
        $this->add(array(
            'name' => 'cod_participante',
            'type' => 'Select',
            'attributes' => array(
                'id' => 'cod_participante',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Atribuido para *',
                'value_options' => $this->getValueParticipanteOptions(),
            ),
        ));

        $this->add(array(
            'name' => 'cod_product_backlog',
            'type' => 'Select',
            'attributes' => array(
                'id' => 'cod_product_backlog',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Product Backlog *',
                'value_options' => $this->getValueProductBacklogOptions(),
            ),
        ));

        $this->add(array(
            'name' => 'botao_salvar',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary',
                'id' => 'botao_salvar',
            ),
        ));
        $this->add(array(
            'name' => 'botao_excluir',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Excluir',
                'class' => 'btn btn-danger',
                'id' => 'botao_excluir',
            ),
        ));
       
    }

    //Busca status
    private function getStatusTable() {
        if (!$this->statusTable) {
            $sm = $GLOBALS['sm'];
            $this->statusTable = $sm->get('Application\Model\StatusTable');
        }
        return $this->statusTable;
    }

    private function getValueStatusOptions() {
        $valueOptions = array();
        $status = $this->getStatusTable()->fetchAll();
//        $valueOptions[''] = 'Selecione...';
        foreach ($status as $statusSprint) {
            $valueOptions[$statusSprint->codStatus] = $statusSprint->descricaoStatus;
        }
        return $valueOptions;
    }

    // participante table
    private function getParticipanteTable() {
        if (!$this->participanteTable) {
            $sm = $GLOBALS['sm'];
            $this->participanteTable = $sm->get('Application\Model\ParticipanteTable');
        }
        return $this->participanteTable;
    }

    private function getValueParticipanteOptions() {
        $valueOptions = array();
        $participantes = $this->getParticipanteTable()->fetchAllScrumTeam(3);
        $valueOptions[''] = 'Selecione...';
        foreach ($participantes as $participante) {
            $valueOptions[$participante->codParticipante] = $participante->nomeParticipante;
        }
        return $valueOptions;
    }

    // product backlog table
    private function getProductBacklogTable() {
        if (!$this->productBacklogTable) {
            $sm = $GLOBALS['sm'];
            $this->productBacklogTable = $sm->get('Application\Model\ProductBacklogTable');
        }
        return $this->productBacklogTable;
    }

    public function getValueProductBacklogOptions(){

        $valueProductBacklogOptions = array();
        $productBacklogs = $this->getProductBacklogTable()->fetchAllForm();
        $valueProductBacklogOptions[''] = 'Selecione...';
        foreach ($productBacklogs as $productBacklog) {
            $valueProductBacklogOptions[$productBacklog->codProductBacklog] = $productBacklog->nomeProductBacklog;
        }
        return $valueProductBacklogOptions;

    }

}
