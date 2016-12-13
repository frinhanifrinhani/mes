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



class Usuario //implements InputFilterAwareInterface 
{

    public $codUsuario;
    public $usuario;
    public $senha;
    public $statusUsuario;
    public $codParticipante;
    public $dataCadastroUsuario; 
    protected $inputFilter;
    
    function exchangeArray($data)
    {
        $this->codUsuario = (isset($data['cod_usuario'])) ? $data['cod_usuario'] : null;
        $this->usuario = (isset($data['usuario'])) ? $data['usuario'] : null;
        $this->statusUsuario = (isset($data['status_usuario'])) ? $data['status_usuario'] : null;
        $this->codParticipante = (isset($data['cod_participante'])) ? $data['cod_participante'] : null;
        $this->dataCadastroUsuario = (isset($data['data_cadastro_usuario'])) ? $data['data_cadastro_usuario'] : null;

    }
    
    public function getArrayCopy()
    {
        return array(
            'cod_usuario' => $this->codUsuario,
            'usuario' => $this->usuario,
            'senha' => $this->senha,
            'status_usuario' => $this->statusUsuario,
            'cod_articipante' => $this->codParticipante,
            'data_cadastro_usuario' => $this->dataCadastroUsuario,
        );
    }
    
//     public function setInputFilter(InputFilterInterface $inputFilter) {
//        throw new \Exception("Sem uso!");
//    }
//
//    public function getInputFilter() {
//    
//    }
    
}
