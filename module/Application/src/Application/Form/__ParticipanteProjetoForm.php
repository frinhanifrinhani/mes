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

class ParticipanteProjetoForm extends Form {

    public $participanteTable;

    public function __construct() {
        parent::__construct('form_participante_projeto');

        $this->setAttribute('method', 'post');
        $this->setAttribute('id', 'form_participante_projeto');

 
        $this->add(array(
            'name' => 'cod_participante',
            'type' => 'Select',
            'attributes' => array(
                'id' => 'cod_participante',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Participante',
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
        $this->add(array(
            'name' => 'botao_enviar',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Enviar',
                'class' => 'btn btn-primary',
                'id' => 'botao_enviar',
            ),
        ));
    }

    //Busca participante
    private function getParticipanteTable() {
        if (!$this->participanteTable) {
            $sm = $GLOBALS['sm'];
            $this->participanteTable = $sm->get('Application\Model\participanteTable');
        }
        return $this->participanteTable;
    }

    private function getValueOptions() {
        $valueOptions = array();
        $participantes = $this->getParticipanteTable()->fetchAll();
        $valueOptions[''] = 'Selecione...';
        foreach ($participantes as $participante) {
            $valueOptions[$participante->codParticipante] = $participante->participante;
        }
        return $valueOptions;
    }

}
