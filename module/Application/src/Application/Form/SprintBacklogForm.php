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

class SprintForm extends Form {

    public $statusTable;
    public $projetoTable;

    public function __construct() {
        parent::__construct('form_sprint');

        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'form_sprint');

        $this->add(array(
            'name' => 'cod_sprint',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'cod_sprint',
                'class' => 'form-control',
                'placeholder' => 'Código da Sprint',
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => 'Código da Sprint',
            ),
        ));

        $this->add(array(
            'name' => 'nome_sprint',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'nome_sprint',
                'class' => 'form-control',
                'placeholder' => 'Nome da Sprint',
            ),
            'options' => array(
                'label' => 'Nome da Sprint *',
            ),
        ));

        $this->add(array(
            'name' => 'descricao_sprint',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'descricao_sprint',
                'class' => 'form-control',
                'placeholder' => 'Descrição da Sprint',
            ),
            'options' => array(
                'label' => 'Descrição da Sprint',
            ),
        ));

        $this->add(array(
            'name' => 'tempo_sprint',
            'type' => 'Select',
            'attributes' => array(
                'id' => 'tempo_sprint',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Tempo de duração *',
                'value_options' => array(
                    null => 'Selecione...',
                    15 => '15 Dias',
                    20 => '20 Dias',
                    30 => '30 Dias',
                ),
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
                'value_options' => $this->getValueOptions(),
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

    //Busca projeto
//    private function getProjetoTable() {
//        if (!$this->projetoTable) {
//            $sm = $GLOBALS['sm'];
//            $this->projetoTable = $sm->get('Application\Model\ProjetoTable');
//        }
//        return $this->projetoTable;
//    }
//    private function getValueOptionsProjeto() {
//        $valueOptions = array();
//        $projetos = $this->getProjetoTable()->fetchAll($this->cod_participante);
//        $valueOptions[''] = 'Selecione...';
//        foreach ($projetos as $projeto) {
//            $valueOptions[$projeto->codProjeto] = $projeto->nomeProjeto;
//        }
//        return $valueOptions;
//    }
    //Busca status
    private function getStatusTable() {
        if (!$this->statusTable) {
            $sm = $GLOBALS['sm'];
            $this->statusTable = $sm->get('Application\Model\StatusTable');
        }
        return $this->statusTable;
    }

    private function getValueOptions() {
        $valueOptions = array();
        $status = $this->getStatusTable()->fetchAll();
//        $valueOptions[''] = 'Selecione...';
        foreach ($status as $statusSprint) {
            $valueOptions[$statusSprint->codStatus] = $statusSprint->descricaoStatus;
        }
        return $valueOptions;
    }

}
