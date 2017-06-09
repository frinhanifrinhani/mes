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

class ProductBacklogPorSprint {//implements InputFilterAwareInterface {

    public $codProjeto;
    public $codProductBacklog;
    public $codProductBacklogPb;
    public $codSprint;
    public $nomeSprint;
    public $nomeProductBacklog;
    public $descricaoProductBacklog;
    protected $inputFilter;
    protected $dbAdapter;

    //Recupera os valores que vem por post e passa para os Atributos, caso não exista valores, pass null (no ZF2 faz o papel do set)
    function exchangeArray($data) {
        $this->codProjeto = (isset($data['cod_projeto'])) ? $data['cod_projeto'] : null;
        $this->codProductBacklog = (isset($data['cod_product_backlog'])) ? $data['cod_product_backlog'] : null;
        $this->codProductBacklogPb = (isset($data['cod_product_backlog_pb'])) ? $data['cod_product_backlog_pb'] : null;
        $this->codSprint = (isset($data['cod_sprint'])) ? $data['cod_sprint'] : null;
        $this->nomeSprint = (isset($data['nome_sprint'])) ? $data['nome_sprint'] : null;
        $this->descricaoProductBacklog = (isset($data['descricao_product_backlog'])) ? $data['descricao_product_backlog'] : null;
        $this->nomeProductBacklog = (isset($data['nome_product_backlog'])) ? $data['nome_product_backlog'] : null;
    }

    //Rassa os valores que vem do banco para os Atributos, (no ZF2 faz o papel do get)
    public function getArrayCopy() {
        return array(
            'cod_projeto' => $this->codProjeto,
            'cod_product_backlog' => $this->codProductBacklog,
            'cod_product_backlog_pb' => $this->codProductBacklogPb,
            'cod_sprint' => $this->codSprint,
            'nome_sprint' => $this->nomeSprint,
            'nome_product_backlog' => $this->nomeProductBacklog,
            'descricao_product_backlog' => $this->descricaoProductBacklog,
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
                        'name' => 'cod_product_backlog',
                        'required' => false,
                            )
            ));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'cod_sprint',
                        'required' => false,
                            )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function toArray() {
        return get_object_vars($this);
    }

}
