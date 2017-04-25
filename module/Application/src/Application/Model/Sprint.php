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

class Sprint implements InputFilterAwareInterface {

    public $codSprint;
    public $nomeSprint;
    public $descricaoSprint;
    public $tempoSprint;
    public $codStatus;
    public $codProjeto;
    public $descricaoStatus;
    public $dataCadastroSprint;
    public $sprintEmAberto;
    public $sprintEmAndamento;
    public $sprintParado;
    public $sprintFinalizado;
    public $totalSprint;
    protected $inputFilter;
    protected $dbAdapter;

    // public $data;

    function exchangeArray($data) {
        $this->codSprint = (isset($data['cod_sprint'])) ? $data['cod_sprint'] : null;
        $this->nomeSprint = (isset($data['nome_sprint'])) ? $data['nome_sprint'] : null;
        $this->descricaoSprint = (isset($data['descricao_sprint'])) ? $data['descricao_sprint'] : null;
        $this->tempoSprint = (isset($data['tempo_sprint'])) ? $data['tempo_sprint'] : null;
        $this->codStatus = (isset($data['cod_status'])) ? $data['cod_status'] : null;
        $this->descricaoStatus = (isset($data['descricao_status'])) ? $data['descricao_status'] : null;
        $this->descricaoStatus = (isset($data['descricao_status'])) ? $data['descricao_status'] : null;
        $this->sprintEmAberto = (isset($data['sprint_em_aberto'])) ? $data['sprint_em_aberto'] : null;
        $this->sprintEmAndamento = (isset($data['sprint_em_andamento'])) ? $data['sprint_em_andamento'] : null;
        $this->sprintParado = (isset($data['sprint_parado'])) ? $data['sprint_parado'] : null;
        $this->sprintFinalizado = (isset($data['sprint_finalizado'])) ? $data['sprint_finalizado'] : null;
        $this->totalSprint = (isset($data['total_sprint'])) ? $data['total_sprint'] : null;
        $this->dataCadastroSprint = (isset($data['data_cadastro_sprint'])) ? $data['data_cadastro_sprint'] : null;
    }

    public function getArrayCopy() {
        return array(
            'cod_sprint' => $this->codSprint,
            'nome_sprint' => $this->nomeSprint,
            'descricao_sprint' => $this->descricaoSprint,
            'tempo_sprint' => $this->tempoSprint,
            'descricao_status' => $this->descricaoStatus,
            'cod_status' => $this->codStatus,
            'cod_projeto' => $this->sprintEmAberto,
            'data_cadastro_sprint' => $this->dataCadastroSprint,
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
                        'name' => 'nome_sprint',
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
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo nome da sprintnão pode ser vazio!'
                                    ),
                                ),
                            ),
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'min' => 3,
                                    'max' => 255,
                                    'messages' => array(
                                        \Zend\Validator\StringLength::TOO_SHORT => 'O campo nome deve ter no mínimo 3 caracteres!',
                                        \Zend\Validator\StringLength::TOO_LONG => 'O campo nome deve ter no máximo 255 caracteres!',
                                    )
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
