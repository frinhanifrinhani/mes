<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\ActionHelper;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class MESCpf extends AbstractPlugin {

    protected $size = 11;

    protected $modifiers = [
        [10, 9, 8, 7, 6, 5, 4, 3, 2],
        [11, 10, 9, 8, 7, 6, 5, 4, 3, 2]
    ];

    const CPF_INVALIDO = '';

    protected $_messageTemplates = array(self::CPF_INVALIDO => 'CPF "%value%" é inválido!');
 
    //Método que verifica e valida um cpf   
    public function isValid($value) {
        if (empty($value)) {
            return false;
        }

        $cpf = str_replace(".", "", str_replace("-", "", $value));
        //$this->_setValue($value);

        if (!is_numeric($cpf)) {
            $erro = true;
        } else {

            if (($cpf == '11111111111') || ($cpf == '22222222222') || ($cpf == '33333333333') ||
                    ($cpf == '44444444444') || ($cpf == '55555555555') || ($cpf == '66666666666') ||
                    ($cpf == '77777777777') || ($cpf == '88888888888') || ($cpf == '99999999999') ||
                    ($cpf == '00000000000')) {
                $erro = true;
            } else {
                // Digito verificador
                $dv_informado = substr($cpf, 9, 2);

                for ($i = 0; $i <= 8; $i++) {
                    $digito[$i] = substr($cpf, $i, 1);
                }

                // Calcula valor digito 10 (de verificacao)
                $posicao = 10;
                $soma = 0;

                for ($i = 0; $i <= 8; $i++) {
                    $soma = $soma + $digito[$i] * $posicao;
                    $posicao = $posicao - 1;
                }

                $digito[9] = $soma % 11;

                if ($digito[9] < 2) {
                    $digito[9] = 0;
                } else {
                    $digito[9] = 11 - $digito[9];
                }

                // Calcula valor digito 11 (de verificacao)
                $posicao = 11;
                $soma = 0;

                for ($i = 0; $i <= 9; $i++) {
                    $soma = $soma + $digito[$i] * $posicao;
                    $posicao = $posicao - 1;
                }

                $digito[10] = $soma % 11;

                if ($digito[10] < 2) {
                    $digito[10] = 0;
                } else {
                    $digito[10] = 11 - $digito[10];
                }

                // Verifica validade
                $dv = $digito[9] * 10 + $digito[10];

                if ($dv != $dv_informado) {
                    $erro = true;
                } else {
                    $erro = false;
                }
            }
        }

        if ($erro) {
            //$this->_error(self::CPF_INVALIDO);
            return false;
        }

        return true;
    }

}
