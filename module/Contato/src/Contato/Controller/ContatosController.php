<?php

namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Contato\Form\ContatoForm,
    Contato\Model\Contato;

class ContatosController extends AbstractActionController
{

    protected $_contatoTable;
    private $_prefixCacheName = 'nome_cache_contato_';

    /**
     * Metodo privado para obter instacia do Model ContatoTable
     *
     * @return \Contato\Model\ContatoTable
     */
    private function _getContatoTable ()
    {
        // adicionar service ModelContato a variavel de classe
        if (!$this->_contatoTable) {
            $this->_contatoTable = $this->getServiceLocator()->get('ContatoTable');
        }
        // return vairavel de classe com service ModelContato
        return $this->_contatoTable;
    }

    // GET /contatos
    public function indexAction ()
    {
        // colocar parametros da url em um array
        $paramsUrl = array(
            'pagina_atual'  => $this->params()->fromQuery('pagina', 1),
            'itens_pagina'  => $this->params()->fromQuery('itens_pagina', 10),
            'coluna_nome'   => $this->params()->fromQuery('coluna_nome', 'nome'),
            'coluna_sort'   => $this->params()->fromQuery('coluna_sort', 'ASC'),
            'search'        => $this->params()->fromQuery('search', null),
        );

        // configuar método de paginação
        $pagination = $this->_getContatoTable()->fetchPaginator(
            /* $pagina */           $paramsUrl['pagina_atual'],
            /* $itensPagina */      $paramsUrl['itens_pagina'],
            /* $ordem */            "{$paramsUrl['coluna_nome']} {$paramsUrl['coluna_sort']}",
            /* $search */           $paramsUrl['search'],
            /* $itensPaginacao */   5
        );

//        return new ViewModel(['contatos' => $pagination] + $paramsUrl);
        return new ViewModel(array('contatos' => $pagination) + $paramsUrl);
    }

    // GET /contatos/novo
    public function novoAction ()
    {
//        return [ 'formContato' => new ContatoForm()];
        return array( 'formContato' => new ContatoForm());
    }

    // POST /contatos/adicionar
    public function adicionarAction ()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            //instancia do formulario
            $contatoForm = new ContatoForm();
            //instancia model com regras de filtro e validação
            $contatoModel = new Contato();
            //passa para o form as regras de filtros e validações contidas
            //na entity Contato
            $contatoForm->setInputFilter($contatoModel->getInputFilter());
            //passa para o obj form os dados vindos do post
            $contatoForm->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($contatoForm->isValid()) {
                // aqui vai a lógica para adicionar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela adição
                $contatoModel->exchangeArray($contatoForm->getData());
                // 2 - inserir dados no banco pelo model
                $this->_getContatoTable()->save($contatoModel);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                        ->addSuccessMessage("Contato criado com sucesso");

                // redirecionar para action index no controller contatos
                return $this->redirect()->toRoute('contatos');
            } else {
                // renderiza para action novo com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                // php 5.4
//                return (new ViewModel())
//                                ->setVariable('formContato', $contatoForm)
//                                ->setTemplate('contato/contatos/novo');


                $view = new ViewModel();
                return $view
                                ->setVariable('formContato', $contatoForm)
                                ->setTemplate('contato/contatos/novo');
            }
        }
    }

    // GET /contatos/detalhes/id
    public function detalhesAction ()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Contato não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }

        try {
            // lógica cache objeto contatos
            $nome_cache_contato_id = $this->_prefixCacheName . $id;

            if (!$this->cache()->hasItem($nome_cache_contato_id)) {
                $contato = $this->_getContatoTable()->find($id);

                $this->cache()->setItem($nome_cache_contato_id, $contato);
            } else {
                $contato = $this->cache()->getItem($nome_cache_contato_id);
            }

        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }

        // dados eviados para detalhes.phtml
        $viewModel = new ViewModel();
        return $viewModel
                    //garante que action possa ser chamada via post e ajax
                    ->setTerminal($this->getRequest()->isXmlHttpRequest())
                    ->setVariable('contato', $contato)
        ;
    }

    // GET /contatos/editar/id
    public function editarAction ()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem de erro
            $this->flashMessenger()->addMessage("Contato não encotrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }

        try {
            $contato = (array) $this->_getContatoTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }

        // objeto form contato vazio
        $form = new ContatoForm();
        // popula objeto form contato com objeto model contato
        $form->setData($contato);

        // dados eviados para editar.phtml
//        return ['formContato' => $form];
        return array('formContato' => $form);
    }

    // PUT /contatos/editar/id
    public function atualizarAction ()
    {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {

            $contatoForm = new ContatoForm();
            $contatoModel = new Contato();

            $contatoForm->setInputFilter($contatoModel->getInputFilter())
                    ->setData($request->getPost());

            // verifica se o formulário segue a validação proposta
            if ($contatoForm->isValid()) {
                // aqui vai a lógica para editar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela atualização
                $contatoModel->exchangeArray($contatoForm->getData());
                // 2 - editar dados no banco pelo model
                $this->_getContatoTable()->update($contatoModel);
                // adicionar mensagem de sucesso
                $this->flashMessenger()
                        ->addSuccessMessage("Contato editado com sucesso");

                $nome_cache_contato_id = $this->_prefixCacheName . $contatoModel->id;
                if ($this->cache()->hasItem($nome_cache_contato_id)) {
                    $this->cache()->removeItem($nome_cache_contato_id);
                }

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('contatos', array("action" => "detalhes", "id" => $contatoModel->id,));
            } else {
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                // php5.4
//                return (new ViewModel())
//                                ->setVariable('formContato', $contatoForm)
//                                ->setTemplate('contato/contatos/editar');
                $view = new ViewModel();
                return $view
                                ->setVariable('formContato', $contatoForm)
                                ->setTemplate('contato/contatos/editar');
            }
        }
    }

    // DELETE /contatos/deletar/id
    public function deletarAction ()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);
        $contato = $this->_getContatoTable()->find($id);

        if (!$contato) {
            // adicionar mensagem de erro
            $this->flashMessenger()
                    ->addMessage("Não foi encontrado contado de id = {$id}");
        } else {
            try {
                $this->_getContatoTable()->delete($contato->id);

                // adicionar mensagem de sucesso
                $this->flashMessenger()
                        ->addSuccessMessage("Contato <b>{$contato->nome}</b> deletado com sucesso");
            } catch (\Exception $exc) {
                // adicionar mensagem
                $this->flashMessenger()->addErrorMessage($exc->getMessage());
            }
        }

        // redirecionar para action index
        return $this->redirect()->toRoute('contatos');
    }

    // GET /contatos/search?query=[nome]
    public function searchAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            $result = $this->_getContatoTable()->search($nome);
        } else  {
            $result = array();   // ou []
        }

        return new \Zend\View\Model\JsonModel($result);
    }

}
