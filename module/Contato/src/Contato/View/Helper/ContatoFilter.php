<?php
namespace Contato\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Contato\Model\Contato;

class ContatoFilter extends AbstractHelper
{
    protected $_contato;
 
    public function __invoke(Contato $contato)
    {
        $this->_contato = $contato;
 
        return $this;
    }
 
    public function id()
    {
        return $this->view->escapeHtml($this->_contato->id);
    }
 
    public function nomeSobrenome()
    {
        $partes_nome = explode(" ", $this->nomeCompleto());
        $result = null;
 
        if (count($partes_nome) <= 2) {
            $result = join($partes_nome, " ");
        } else {
            $result = "{$partes_nome[0]} {$partes_nome[1]} ...";
        }
 
        return $this->view->escapeHtml($result);
    }
 
    public function nomeCompleto()
    {
        $result = ucwords(strtolower($this->_contato->nome));
 
        return $this->view->escapeHtml($result);
    }
 
    public function quantidadeTelefones()
    {
        $result = ((int) !empty($this->_contato->telefone_principal)) + ((int) !empty($this->_contato->telefone_secundario));
 
        return $this->view->escapeHtml($result);
    }
 
    public function dataCriacao()
    {
        $result = (new \DateTime($this->_contato->data_criacao))->format('d/m/Y - H:i');
 
        return $this->view->escapeHtml($result);
    }
 
    public function dataAtualizacao()
    {
        $result = (new \DateTime($this->_contato->data_atualizacao))->format('d/m/Y - H:i');
 
        return $this->view->escapeHtml($result);
    }
 
    public function telefonePrincipal()
    {
        $result = $this->_contato->telefone_principal ? $this->_contato->telefone_principal : 'Sem Registro';
 
        return $this->view->escapeHtml($result);
    }
 
    public function telefoneSecundario()
    {
        $result = $this->_contato->telefone_secundario ? $this->_contato->telefone_secundario : 'Sem Registro';
 
        return $this->view->escapeHtml($result);
    }
}