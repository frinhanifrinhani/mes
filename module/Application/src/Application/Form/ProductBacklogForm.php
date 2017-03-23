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

class ProductBacklogForm extends Form {

//    public $tipoParticipanteTable;
    public $statusTable;

    public function __construct() {
        parent::__construct('form_productbacklog');

        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'form_productbacklog');

        $this->add(array(
            'name' => 'cod_product_backlog',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'cod_product_backlog',
                'class' => 'form-control',
                'placeholder' => 'Código do Item Product Backlog',
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => 'Código do Item Product Backlog',
            ),
        ));

        $this->add(array(
            'name' => 'nome_product_backlog',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'nome_product_backlog',
                'class' => 'form-control',
                'placeholder' => 'Nome do Item do Product Backlog',
            ),
            'options' => array(
                'label' => 'Nome do Item *',
            ),
        ));

        $this->add(array(
            'name' => 'descricao_product_backlog',
            'type' => 'Text',
            'attributes' => array(
                'id' => 'descricao_product_backlog',
                'class' => 'form-control',
                'placeholder' => 'Descrição do Item Product Backlog',
            ),
            'options' => array(
                'label' => 'Descrição do Item *',
            ),
        ));

        $this->add(array(
            'name' => 'prioridade_product_backlog',
            'type' => 'Select',
            'attributes' => array(
                'id' => 'prioridade_product_backlog',
                'class' => 'form-control',
                'placeholder' => 'Prioridade',
            ),
            'options' => array(
                'label' => 'Prioridade *',
                'value_options' => array(
                    null => 'Selecione...',
                    '1' => 'Alta',
                    '2' => 'Média',
                    '3' => 'Baixa',
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
                'placeholder' => 'Status',
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
