<?php

namespace Contato\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Contato\Form\ContatoForm,
    Contato\Model\Contato;
    

class ContatosController extends AbstractActionController {

    protected $_contatoTable;
    
    /**
     * Metodo privado para obter instacia do Model ContatoTable
     *
     * @return \Contato\Model\ContatoTable
     */
    private function _getContatoTable() {
        // adicionar service ModelContato a variavel de classe
        if (!$this->_contatoTable){
            $this->_contatoTable = $this->getServiceLocator()->get('ContatoTable');
        }
        // return vairavel de classe com service ModelContato
        return $this->_contatoTable;
    }

    // GET /contatos
    public function indexAction() {
        return new ViewModel(array('contatos' => $this->_getContatoTable()->fetchAll()));
    }

    // GET /contatos/novo
    public function novoAction() {
        return [ 'formContato' => new ContatoForm() ];
    }

    // POST /contatos/adicionar
    public function adicionarAction() {
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
                return (new ViewModel())
                        ->setVariable('formContato', $contatoForm)
                        ->setTemplate('contato/contatos/novo');
            }
        }
    }

    // GET /contatos/detalhes/id
    public function detalhesAction() {
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
            $contato = $this->_getContatoTable()->find($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('contatos');
        }

        // dados eviados para detalhes.phtml
        return ['contato' => $contato];
    }

    // GET /contatos/editar/id
    public function editarAction() {
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
        return ['formContato' => $form];
    }

    // PUT /contatos/editar/id
    public function atualizarAction() {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            
            $contatoForm  = new ContatoForm();
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

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('contatos', array("action" => "detalhes", "id" => $contatoModel->id,));
            } else {
                // renderiza para action editar com o objeto form populado,
                // com isso os erros serão tratados pelo helpers view
                return (new ViewModel())
                            ->setVariable('formContato', $contatoForm)
                            ->setTemplate('contato/contatos/editar');
            }
        }
    }

    // DELETE /contatos/deletar/id
    public function deletarAction() {
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

}
