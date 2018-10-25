<?php

namespace MarceloGumercinoCosta\ConsultaCnpj;

use Exception;

/**
 * <p>##### CLASSE RESPONSAVEL POR REALIZAR A CONSULTA CADASTRAL DE CNPJ NA RECEITA FEDERAL ########</p> *
 *
 */
class ConsultaCnpj {

    private $urlReceita;
    private $param;
    private $cnpj;
    private $data;

    public function __construct() {
        $this->urlReceita = "https://www.receitaws.com.br/v1/cnpj/";
    }

    /**
     * Remove máscara de um texto
     *
     * @param  string $texto
     * @return string (Texto sem a mascara)
     */
    protected static function unmask($texto) {
        return preg_replace('/[\-\|\(\)\/\.\: ]/', '', $texto);
    }

    /**
     * Metodo para verificar se um CNPJ é válido
     *
     * @param  string $cnpj
     * @return boolean
     */
    public static function isCnpj($cnpj) {
        $valid = true;
        $cnpj = str_pad(self::unmask($cnpj), 14, '0', STR_PAD_LEFT);

        if (!ctype_digit($cnpj))
            return false;

        for ($x = 0; $x < 10; $x++) {
            if ($cnpj == str_repeat($x, 14)) {
                $valid = false;
            }
        }

        if ($valid) {
            if (strlen($cnpj) != 14) {
                throw new Exception("Erro - CNPJ incorreto");
            } else {
                for ($t = 12; $t < 14; $t++) {
                    $d = 0;
                    $c = 0;
                    for ($m = $t - 7; $m >= 2; $m--, $c++) {
                        $d += $cnpj{$c} * $m;
                    }
                    for ($m = 9; $m >= 2; $m--, $c++) {
                        $d += $cnpj{$c} * $m;
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cnpj{$c} != $d) {
                        $valid = false;
                        break;
                    }
                }
            }
        }

        return $valid;
    }

    /**

     * 
     * @param string $cnpj
     * <b>Informe um valor do tipo string numerica</b>
     * 
     */
    public function checkCnpj($cnpj) {
        if ($this->isCnpj($cnpj)) {
            $this->cnpj = $this->unmask($cnpj);
            $this->param = $this->urlReceita . $this->cnpj;
            $verificaCNPJ = get_object_vars($this->setUrl());
            if (count($verificaCNPJ) == 2) {
                throw new Exception("Erro - " . $verificaCNPJ['message']);
            } 
            $this->data = $verificaCNPJ;
            $this->data['cnpj'] = $cnpj;
        }
    }

    private function setUrl() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_result = curl_exec($ch);
        $retorno = json_decode($curl_result);
        curl_close($ch);
        if (!$retorno) {
            return json_decode(json_encode(array("status" => "ERROR", "message" => $curl_result)));
        }
        return $retorno;
    }

    public function dataSituacao() {
        return $this->data["data_situacao"];
    }

    public function complemento() {
        return $this->data["complemento"];
    }

    public function nome() {
        return $this->data["nome"];
    }

    public function uf() {
        return $this->data["uf"];
    }

    public function telefone() {
        return $this->data["telefone"];
    }

    public function email() {
        return $this->data["email"];
    }

    public function situacao() {
        return $this->data["situacao"];
    }

    public function bairro() {
        return $this->data["bairro"];
    }

    public function logradouro() {
        return $this->data["logradouro"];
    }

    public function numero() {
        return $this->data["numero"];
    }

    public function cep() {
        return $this->data["cep"];
    }

    public function municipio() {
        return $this->data["municipio"];
    }

    public function abertura() {
        return $this->data["abertura"];
    }

    public function naturezaJuridica() {
        return $this->data["natureza_juridica"];
    }

    public function fantasia() {
        return $this->data["fantasia"];
    }

    public function cnpj() {
        return $this->data["cnpj"];
    }

    public function ultimaAtualizacao() {
        return $this->data["ultima_atualizacao"];
    }

    public function status() {
        return $this->data["status"];
    }

    public function tipo() {
        return $this->data["tipo"];
    }

    public function efr() {
        return $this->data["efr"];
    }

    public function motivoSituacao() {
        return $this->data["motivo_situacao"];
    }

    public function situacaoEspecial() {
        return $this->data["situacao_especial"];
    }

    public function dataSituacaoEspecial() {
        return $this->data["data_situacao_especial"];
    }

    public function capitalSocial() {
        return $this->data["capital_social"];
    }

    public function atividadePrincipal() {
        return $this->data["atividade_principal"];
    }

    public function qsa() {
        return $this->data["qsa"];
    }

    public function atividadesSecundarias() {
        return $this->data["atividades_secundarias"];
    }

}
