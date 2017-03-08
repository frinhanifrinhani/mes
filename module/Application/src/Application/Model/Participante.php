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


class Participante implements InputFilterAwareInterface {

    public $codParticipante;
    public $nomeParticipante;
    public $cpfParticipante;
    public $telefoneParticipante;
    public $emailParticipante;
    public $codTipoParticipante;
    public $tipoParticipante;
    public $senhaParticipante;
    public $dataCadastroParticipante;
    protected $inputFilter;
    protected $dbAdapter;
   // public $data;

    function exchangeArray($data) {
        $this->codParticipante = (isset($data['cod_participante'])) ? $data['cod_participante'] : null;
        $this->nomeParticipante = (isset($data['nome_participante'])) ? $data['nome_participante'] : null;
        $this->cpfParticipante = (isset($data['cpf_participante'])) ? $data['cpf_participante'] : null;
        $this->telefoneParticipante = (isset($data['telefone_participante'])) ? $data['telefone_participante'] : null;
        $this->emailParticipante = (isset($data['email_participante'])) ? $data['email_participante'] : null;
        $this->codTipoParticipante = (isset($data['cod_tipo_participante'])) ? $data['cod_tipo_participante'] : null;
        $this->tipoParticipante = (isset($data['tipo_participante'])) ? $data['tipo_participante'] : null;
        $this->senhaParticipante =  (isset($data['senha_participante'])) ? $data['senha_participante'] : substr( md5(uniqid(rand(), true)), 0,6);
        $this->dataCadastroParticipante = (isset($data['data_cadastro_participante'])) ? $data['data_cadastro_participante'] : null;
    }

    public function getArrayCopy() {
        return array(
            'cod_participante' => $this->codParticipante,
            'nome_participante' => $this->nomeParticipante,
            'cpf_participante' => $this->cpfParticipante,
            'telefone_participante' => $this->telefoneParticipante,
            'email_participante' => $this->emailParticipante,
            'cod_tipo_participante' => $this->codTipoParticipante,
            'tipo_participante' => $this->tipoParticipante,
            'senha_participante' => $this->senhaParticipante,
            'data_cadastro_participante' => $this->dataCadastroParticipante,
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
                        'name' => 'nome_participante',
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
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo nome não pode ser vazio!'
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

            //verifica duplicidade do cpf
            $inputFilter->add($factory->createInput(array(
                        'name' => 'cpf_participante',
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => '\Zend\Validator\Db\NoRecordExists',
                                'options' => array(
                                    'table' => 'participante',
                                    'field' => 'cpf_participante',
                                    'adapter' => $this->dbAdapter,
                                    'messages' => array(
                                        \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'CPF já cadastrado',
                                    ),
                                ),
                            ),
                        ),
            )));
//            verifica duplicidade do email
            $inputFilter->add($factory->createInput(array(
                        'name' => 'email_participante',
                        'required' => true,
                        'validators' => array(
                            array(
                                'name' => '\Zend\Validator\Db\NoRecordExists',
                                'options' => array(
                                    'table' => 'participante',
                                    'field' => 'email_participante',
                                    'adapter' => $this->dbAdapter,
                                    'messages' => array(
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo E-mail não pode ser vazio!',
                                        \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'Email já cadastrado',
                                    ),
                                ),
                                'name' => 'NotEmpty',
                                'options' => array(
                                    'messages' => array(
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo e-mail não pode ser vazio!'
                                    ),
                                ),
                            ),
                        ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                        'name' => 'cod_tipo_participante',
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
                                        \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo Tipo participante não pode ser vazio!'
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
