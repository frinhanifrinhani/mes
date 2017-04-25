<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\I18n\Filter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\TableGateway\TableGateway;

class SprintBacklog implements InputFilterAwareInterface {

    public $codSprintBacklog;
    public $nomeSprintBacklog;
    public $descricaoSprintBacklog;
    public $tempoSprintBacklog;
    public $codStatus;
    public $descricaoStatus;
    public $codParticipante;
    public $nomeParticipante;
    public $codProjeto;
    public $codProductBacklog;
    public $sprintBacklogEmAberto;
    public $sprintBacklogEmAndamento;
    public $sprintBacklogParado;
    public $sprintBacklogFinalizado;
    public $totalSprintBacklog;
    public $dataCadastroSprintBacklog;
    protected $inputFilter;
    protected $dbAdapter;

    // public $data;

    function exchangeArray($data) {
        $this->codSprintBacklog = (isset($data['cod_sprint_backlog'])) ? $data['cod_sprint_backlog'] : null;
        $this->nomeSprintBacklog = (isset($data['nome_sprint_backlog'])) ? $data['nome_sprint_backlog'] : null;
        $this->descricaoSprintBacklog = (isset($data['descricao_sprint_backlog'])) ? $data['descricao_sprint_backlog'] : null;
        $this->tempoSprintBacklog = substr( (isset($data['tempo_sprint_backlog'])) ? $data['tempo_sprint_backlog'] : null,0,5);
        $this->codStatus = (isset($data['cod_status'])) ? $data['cod_status'] : null;
        $this->descricaoStatus = (isset($data['descricao_status'])) ? $data['descricao_status'] : null;
        $this->codParticipante = (isset($data['cod_participante'])) ? $data['cod_participante'] : null;
        $this->nomeParticipante = (isset($data['nome_participante'])) ? $data['nome_participante'] : null;
        $this->codProjeto = (isset($data['cod_projeto'])) ? $data['cod_projeto'] : null;
        $this->codProductBacklog = (isset($data['cod_product_backlog'])) ? $data['cod_product_backlog'] : null;
        $this->sprintBacklogEmAberto = (isset($data['sprint_backlog_em_aberto'])) ? $data['sprint_backlog_em_aberto'] : null;
        $this->sprintBacklogEmAndamento = (isset($data['sprint_backlog_em_andamento'])) ? $data['sprint_backlog_em_andamento'] : null;
        $this->sprintBacklogParado = (isset($data['sprint_backlog_parado'])) ? $data['sprint_backlog_parado'] : null;
        $this->sprintBacklogFinalizado = (isset($data['sprint_backlog_finalizado'])) ? $data['sprint_backlog_finalizado'] : null;
        $this->totalSprintBacklog = (isset($data['total_sprint_backlog'])) ? $data['total_sprint_backlog'] : null;
        $this->dataCadastroSprintBacklog = (isset($data['data_cadastro_sprint_backlog'])) ? $data['data_cadastro_sprint_backlog'] : null;
    }

    public function getArrayCopy() {
        return array(
            'cod_sprint_backlog' => $this->codSprintBacklog,
            'nome_sprint_backlog' => $this->nomeSprintBacklog,
            'descricao_sprint_backlog' => $this->descricaoSprintBacklog,
            'tempo_sprint_backlog' => $this->tempoSprintBacklog,
            'cod_status' => $this->codStatus,
            'descricao_status' => $this->descricaoStatus,
            'cod_participante' => $this->codParticipante,
            'nome_participante' => $this->nomeParticipante,
            'cod_projeto' => $this->codProjeto,
            'cod_product_backlog' => $this->codProductBacklog,
            'data_cadastro_sprint_backlog' => $this->dataCadastroSprintBacklog,
        );
    }

    /* add */

    public function setDbAdapter($dbAdapter) {

        $this->dbAdapter = $dbAdapter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'cod_product_backlog',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim')
                        ),
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo Product Backlog não pode ser vazio!'
                                    ),
                                ),
                            ),
                           
                        )
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'nome_sprint_backlog',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim')
                        ),
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo nome da Sprint Backlog não pode ser vazio!'
                                    ),
                                ),
                            ),
                           
                        )
            )));
            

            $inputFilter->add($factory->createInput(array(
                        'name' => 'tempo_sprint_backlog',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim')
                        ),
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo Tempo de duração não pode ser vazio!'
                                    ),
                                ),
                            ),
                           
                        )
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'cod_participante',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim')
                        ),
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo Atribuido para, não pode ser vazio!'
                                    ),
                                ),
                            ),
                           
                        )
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function toArray() {
        return get_object_vars($this);
    }

}
