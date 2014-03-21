<?php
namespace Contato\Model;

class Contato
{
    public $id;
    public $nome;
    public $telefone_principal;
    public $telefone_secundario;
    public $data_criacao;
    public $data_atualizacao;

    public function exchangeArray($data)
    {
        $this->id                   = (empty($data['id']))                 ? null : $data['id'];
        $this->nome                 = (empty($data['nome']))               ? null : $data['nome'];
        $this->telefone_principal   = (empty($data['telefone_principal'])) ? null : $data['telefone_principal'];
        $this->telefone_secundario  = (empty($data['telefone_secundario']))? null : $data['telefone_secundario'];
        $this->data_criacao         = (empty($data['data_criacao']))       ? null : $data['data_criacao'];
        $this->data_atualizacao     = (empty($data['data_atualizacao']))   ? null : $data['data_atualizacao'];
    }
}