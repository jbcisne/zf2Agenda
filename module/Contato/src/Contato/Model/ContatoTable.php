<?php

// namespace de localizacao do nosso model

namespace Contato\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;

class ContatoTable {

    protected $_tableGateway;

    /**
     * Contrutor com dependencia da classe TableGateway
     *
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway) {
        $this->_tableGateway = $tableGateway;
    }

    /**
     * Recuperar todos os elementos da tabela contatos
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll() {
        return $this->_tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id da tabela contatos
     *
     * @param type $id
     * @return \Model\Contato
     * @throws \Exception
     */
    public function find($id) {
        $id = (int) $id;
        $rowset = $this->_tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Não foi encontrado contado de id = {$id}");
        }

        return $row;
    }

}
