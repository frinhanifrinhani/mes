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

class ProjetoForm extends Form {

    public $statusTable;
    public $participanteTable;

    public function __construct() {
        parent::__construct('form_projeto');

        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'form_projeto');

        $this->add(array(
            'name' => 'cod_projeto',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'cod_projeto',
                'class' => 'form-control',
                'placeholder' => 'Código do Projeto',
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => 'Código do Projeto',
            ),
        ));

        $this->add(array(
            'name' => 'nome_projeto',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'nome_projeto',
                'class' => 'form-control',
                'placeholder' => 'Nome do Projeto',
            ),
            'options' => array(
                'label' => 'Nome do Projeto *',
            ),
        ));

        $this->add(array(
            'name' => 'descricao_projeto',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'descricao_projeto',
                'class' => 'form-control',
                'placeholder' => 'Descrição do Projeto',
            ),
            'options' => array(
                'label' => 'Descrição do Projeto',
            ),
        ));

        $this->add(array(
            'name' => 'data_inicio_projeto',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'data_inicio_projeto',
                'class' => 'form-control',
                'placeholder' => 'Data de Início do Projeto',
                'onchange' => 'calcularDiasProjeto();',
            ),
            'options' => array(
                'label' => 'Data de Início do Projeto *',
            ),
        ));

        $this->add(array(
            'name' => 'data_fim_projeto',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'data_fim_projeto',
                'class' => 'form-control',
                'placeholder' => 'Data prevista para Finalização do Projeto',
                'onchange' => 'calcularDiasProjeto(); verificarData();',
            ),
            'options' => array(
                'label' => 'Data Fim do Pojeto *',
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
                'value_options' => $this->getStatusValueOptions(),
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
                'label' => 'Dono do Projeto *',
                'value_options' => $this->getParticipanteValueOptions(),
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
    private function getParticipanteTable() {
        if (!$this->participanteTable) {
            $sm = $GLOBALS['sm'];
            $this->participanteTable = $sm->get('Application\Model\participanteTable');
        }
        return $this->participanteTable;
    }

    //Monta array com os status, e será retornado para a combobox 
    private function getStatusValueOptions() {
        $valueOptions = array();
        $status = $this->getStatusTable()->fetchAll();
//        $valueOptions[''] = 'Selecione...';
        foreach ($status as $statusProjeto) {
            $valueOptions[$statusProjeto->codStatus] = $statusProjeto->descricaoStatus;
        }
        return $valueOptions;
    }
    //Monta array com os participantes, e será retornado para a combobox 
    private function getParticipanteValueOptions() {
        $valueOptions = array();
        $participantes = $this->getParticipanteTable()->fetchAllProductOwner();
        $valueOptions[''] = 'Selecione...';
        foreach ($participantes as $participante) {
            $valueOptions[$participante->codParticipante] = $participante->nomeParticipante;
        }
        return $valueOptions;
    }

}
