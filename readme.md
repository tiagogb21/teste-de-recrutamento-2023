
# Teste de Recrutamento @cansei_vendi

O presente teste tem como objetivo selecionar um candidato ideal para trabalhar como Desenvolvedor FullStack na empresa [@cansei_vendi](https://canseivendi.com.br), o teste é uma representação da Área do Vendedor do site.

O seu objetivo é estudar e compreender o projeto, e assim implementar o que é proposto nesse documento.

## Arquitetura do Projeto

O projeto está arquitetado utilizando as estrutura **MVC**(Model-View-Controller).

### Árvore da Estrutura

- ### App

	- ### Controllers

		A camada **Controller** é responsável pela intermediação das requisições enviadas pelos *clients* com as respostas enviadas pela **Model**, processando os dados baseado no modelo de negócio.

	- ### Models

		A camada **Model** tem a responsabilidade de gerenciar e controlar a forma como os dados irão se comportar por meio das funções, lógica e regras de negócios.

	- ### Views

		A camada **View** é responsável por apresentar as informações recebidas pela **Controller** de forma visual para o usuário final.

	- ### Helpers

		A Camada **Helper** contém classes responsáveis por fornecer códigos para auxiliar as outras entidades, prevenindo também códigos repetitivos.

## Recomendações para configurar o Projeto
- Realize um `fork` do [repositório oficial](https://github.com/canseivendi/teste-de-recrutamento-2023) que contém o projeto
- Copie o arquivo `.env.example` para `.env`, nesse arquivo você precisa configurar os dados de autenticação do banco de dados.
- Utilize uma configuração de URL Amigável, dependendo do tipo de servidor web que estiver utilizando
	- Apache:
		```apacheconf
		RewriteEngine On

		RewriteBase /

		RewriteCond %{THE_REQUEST} \ /+([^\?\ ]+)\.html
		RewriteRule ^([^?]*) index.php?_route_=%1 [L,QSA]

		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteCond %{REQUEST_URI} !.*\.(ico|gif|jpg|jpeg|png|js|css)
		RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]
		```
	- Nginx:
		```nginx
		location / {
                try_files $uri @recrutamento;
        }

        location @recrutamento {
                rewrite ^/(.+)$ /index.php?_route_=$1 last;
        }
		```
- É necessário instalar todas as dependências do projeto utilizando o `composer`.
- Você irá encontrar o arquivo `sql` na raíz do projeto pelo nome `database.sql`, use-o para importar o **Banco de Dados**.
- O servidor WEB deve apontar para a pasta `/public` como diretório principal.

## Ferramenta Super

A ferramenta de Interface de Linha de Comando **Super** serve para te auxiliar na criação de algumas entidades.

Se você precisar criar alguma entidade dentro de pastas ou subpastas, você pode seguir o seguinte padrão: `"Folder/SubFolder/EntityName"`.

- Controller
	```bash
	php super create:controller "ControllerName"
	```
	
- Model
	```bash
	php super create:model "ModelName"
	```
	
- View
	```bash
	php super create:view "ViewName"
	```

- Helper
	```bash
	php super create:helper "HelperName"
	```

## Tarefas

Precisamos finalizar com urgência a **Área do Vendedor** do site, essa área é muito importante, porquê é através dela que os nossos **Clientes Vendedores** irão conseguir se manter informado sobre os seus produtos!

Desenvolvemos uma base da **Área do Vendedor**, mas ainda falta implementar algumas tarefas. 

Precisamos da sua ajuda para finalizar isso com urgência! 🆘🙏🏼 

### Sistema de Autenticação

Nosso sistema não tem uma forma de se autenticar, só percebemos isso agora 😰!
É muito importante um **Sistema de Autenticação** nesse sistema, já que ele contém muitos dados sensíveis.

Você precisa desenvolver um **Sistema de Login e Cadastro**.

### Contas Bancárias

Na área de Contas Bancárias, faltam algumas coisas para serem finalizadas. Nesse momento somente o *layout* da **Listagem** e do **Formulário de Cadastro** parecem estar completos. Lembre-se que os dados estão *"mockados"*, o que faz necessário a integração com o **Banco de Dados**.

Você precisa desenvolver as funcionalidades restantes:
- Cadastro
	-  O formulário já está pronto, porém ele não está funcionando!
- Deletar
	- Uma conta bancária só pode ser deletada, se ela não foi utilizada em nenhuma transferência!
- Editar
	- Uma conta bancária só pode ser editada, se ela não foi utilizada em nenhuma transferência!

### Adicionar Transferência

Parecido com o caso de Cadastro das Contas Bancárias, a **Listagem** e o formulário para **Adicionar Transferência** também já estão prontos, porém não estão funcionando corretamente!

Você precisa finalizar a **Listagem** e o formulário de **Adicionar Transferência**.

Vale lembrar que, quando o cliente solicitar uma transferência, é necessário adicionar no **Histórico** essa solicitação de transferência.

### Header e  Footer

Nosso site está sem Cabeçalho e Rodapé 😱! Isso é muito grave!

Você precisa desenvolver um **Header e Footer**.

Você pode usar como base o site oficial do [@cansei_vendi](https://canseivendi.com.br), mas não precisa ser exatamente igual e nem com todos os links.

### Bug nos Saldos

Há um bug no cálculo dos Saldos, fazendo com que os Saldos exibidos sejam incorretos.

Você precisa resolver esse **Bug nos Saldos**, antes que um cliente reclame 😖!

### Filtros de Data do Histórico

Tentei filtrar o histórico e nada aconteceu 😬!

Os **Filtros de Data do Histórico** não estão completos, somente os campos foram adicionados, porém sem função nenhuma!

Quando o cliente utilizar os filtros de data, a página **não pode ser recarregada** por completo para exibir os dados!

Você precisa finalizar o sistema de **Filtros de Data do Histórico**.

## Finalização
Ao finalizar as tarefas, envie um e-mail para [andreluis@canseivendi.com.br](mailto:andreluis@canseivendi.com.br), contendo seu **nome**, **número de celular** e o **link do repositório** que contém o projeto.

Lembrando que é ideal que o repositório esteja no [**GitHub**](https://github.com/) e em modo público.

Após a correção da sua solução, entraremos em contato para encaminhar a avaliação!

Boa sorte 🍀

