<?php

// namespace de localizacao do nosso model

namespace Contato\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Sql\Select,
    Zend\Db\ResultSet\HydratingResultSet,
    Zend\Stdlib\Hydrator\Reflection,
    Zend\Paginator\Adapter\DbSelect,
    Zend\Paginator\Paginator;

class ContatoTable
{

    protected $_tableGateway;

    /**
     * Contrutor com dependencia da classe TableGateway
     *
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */
    public function __construct (TableGateway $tableGateway)
    {
        $this->_tableGateway = $tableGateway;
    }

    /**
     * Recuperar todos os elementos da tabela contatos
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll ()
    {
        return $this->_tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id da tabela contatos
     *
     * @param type $id
     * @return \Model\Contato
     * @throws \Exception
     */
    public function find ($id)
    {
        $id = (int) $id;
        $rowset = $this->_tableGateway->select(array('id' => $id));
        $row = $rowset->current();
//        if (!$row) {
//            throw new \Exception("Não foi encontrado contado de id = {$id}");
//        }

        return $row;
    }

    public function delete ($id)
    {
        return $this->_tableGateway->delete(array('id' => $id));

        # OU
//        $delete = $this->_tableGateway
//                       ->getSql()
//                       ->delete()
//                       ->where(array('id'=>$id));
//
//        return $this->_tableGateway->deleteWith($delete);
    }

    /**
     * Inserir um novo contato
     *
     * @param \Contato\Model\Contato $contato
     * @return 1/0
     */
    public function save (Contato $contato)
    {
        $timeNow = new \DateTime();

        $data = array(
            'nome' => $contato->nome,
            'telefone_principal' => $contato->telefone_principal,
            'telefone_secundario' => $contato->telefone_secundario,
            'data_criacao' => $timeNow->format('Y-m-d H:i:s'),
            'data_atualizacao' => $timeNow->format('Y-m-d H:i:s'), # data de criação igual a de atualização
        );

        return $this->_tableGateway->insert($data);
    }

    /**
     * Atualizar um contato existente
     *
     * @param \Contato\Model\Contato $contato
     * @throws \Exception
     */
    public function update (Contato $contato)
    {
        $timeNow = new \DateTime();

        $data = array(
            'nome' => $contato->nome,
            'telefone_principal' => $contato->telefone_principal,
            'telefone_secundario' => $contato->telefone_secundario,
            'data_atualizacao' => $timeNow->format('Y-m-d H:i:s'),
        );

        $id = (int) $contato->id;
        if ($this->find($id)) {
            $this->_tableGateway->update($data, array('id' => $id));
        } else {
            throw new \Exception("Contato #{$id} {$contato->nome} inexistente");
        }
    }

    /**
     * Localizar itens por paginação
     *
     * @param int $page
     * @param int $itemPerPage
     * @param string|array $order
     * @param string $like
     * @param int $itemPerPagitation
     * @return Paginator
     */
    public function fetchPaginator ($page = 1, $itemPerPage = 10, $order = 'nome ASC', $like = null, $itemPerPagitation = 5)
    {
        $objSelect = new Select('contatos');
        $select = $objSelect->order($order);
        if (isset($like)) {
            $select->where->like('id', "%{$like}%")
                   ->or->like('nome', "%{$like}%")
                   ->or->like('telefone_principal', "%{$like}%")
                   ->or->like('data_criacao', "%{$like}%")
            ;
        }
        $resultSet = new HydratingResultSet(new Reflection(), new Contato());
        $paginatorAdapter = new DbSelect(
                $select, $this->_tableGateway->getAdapter(), $resultSet
        );
        //php 5.4
//        return (new Paginator($paginatorAdapter))
//                ->setCurrentPageNumber((int) $page)
//                ->setItemCountPerPage((int) $itemPerPage)
//                ->setPageRange((int) $itemPerPagitation);
        $paginator = new Paginator($paginatorAdapter);
        return $paginator
                ->setCurrentPageNumber((int) $page)
                ->setItemCountPerPage((int) $itemPerPage)
                ->setPageRange((int) $itemPerPagitation);
    }
}
