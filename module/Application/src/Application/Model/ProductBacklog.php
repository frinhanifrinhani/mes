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

class ProductBacklog implements InputFilterAwareInterface {

    public $codProductBacklog;
    public $nomeProductBacklog;
    public $descricaoProductBacklog;
    public $prioridadeProductBacklog;
    public $codProjeto;
    public $codStatus;
    //public $descricaoStatus;
    public $dataCadastroProductBacklog;
    protected $inputFilter;
    protected $dbAdapter;

    //Recupera os valores que vem por post e passa para os Atributos, caso não exista valores, pass null (no ZF2 faz o papel do get)
    function exchangeArray($data) {
        $this->codProductBacklog = (isset($data['cod_product_backlog'])) ? $data['cod_product_backlog'] : null;
        $this->nomeProductBacklog = (isset($data['nome_product_backlog'])) ? $data['nome_product_backlog'] : null;
        $this->descricaoProductBacklog = (isset($data['descricao_product_backlog'])) ? $data['descricao_product_backlog'] : null;
        $this->prioridadeProductBacklog = (isset($data['prioridade_product_backlog'])) ? $data['prioridade_product_backlog'] : null;
        $this->codProjeto = (isset($data['cod_projeto'])) ? $data['cod_projeto'] : null;
        $this->codStatus = (isset($data['cod_status'])) ? $data['cod_status'] : null;
        $this->dataCadastroProductBacklog = (isset($data['data_cadastro_product_backlog'])) ? $data['data_cadastro_product_backlog'] : null;
        
    }

    //Rassa os valores que vem do banco para os Atributos, (no ZF2 faz o papel do set)
    public function getArrayCopy() {
        return array(
            'cod_product_backlog' => $this->codProductBacklog,
            'nome_product_backlog' => $this->nomeProductBacklog,
            'descricao_product_backlog' => $this->descricaoProductBacklog,
            'prioridade_product_backlog' => $this->prioridadeProductBacklog,
            'cod_projeto' => $this->codProjeto,
            'cod_status' => $this->codStatus,
            'data_cadastro_product_backlog' => $this->dataCadastroProductBacklog, 
        );
    }
    //seta o adaptador do banco de dados
    public function setDbAdapter($dbAdapter) {

        $this->dbAdapter = $dbAdapter;
    }
    
    //seta o inputfilter e retorna uma exessão
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Não");
    }
    //recupera o input filter, tratado os dados que vem do Form
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
