[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://github.com/Fabriciope/TechNews/blob/main/LICENSE)

# TechNews
Este projeto é um site de artigos sobre tecnologia, onde os artigos são feitos pelos próprios usuários, criando assim uma comunidade de entusiastas.

## Índices
- [⚙️ Funcionalidades do site](#funcionalidades-do-site)
- [🛠 Tecnologias utilizadas](#tecnologias-utilizadas)
- [🏛️ Arquitetura da aplicação](#arquitetura-da-aplicação)
- [🔒 Segurança e proteção de dados](#segurança-e-proteção-de-dados)
- [📈 Escalabilidade e desempenho](#escalabilidade-e-desempenho)
- [🎲 Banco de dados](#banco-de-dados)
  
## Funcionalidades do site
### Cadastrar
  O usuário poderá se cadastrar na plataforma inserindo nome, sobrenome, e-mail e sua senha de acesso. Quando o usuário realizar o cadastro na plataforma, enviaremos um e-mail de confirmação para ele verificar sua conta. 
  
### Verificação de e-mail
  Ao se cadastrar, um e-mail será enviado para a conta registrada, para que o novo usuário possa verificar sua conta. Caso ele não faça a verificação ele poderá realizar o login normalmente, mas não vai poder acessar as principais funcionalidades do site como a adição de novos artigos e interação na comunidade como os comentários, mas caso ele queira verificar sua conta, ele pode fazer isto através da sua página de perfil.

### Entrar
 Caso o usuário já tenha um cadastro no site, ele poderá fazer o login com seu e-mail e senha. Na página de login o usuário também tem a opção de salvar o e-mail de entrada para que na próxima vez que ele for fazer o login o e-mail já esteja inserido, faltando somente a senha.
 
### Esquecer senha
 Se o usuário ao ir fazer o login não lembre de sua senha, ele pode solicitar a alteração da mesma, informando seu e-mail cadastrado, logo após isto, enviaremos um e-mail de alteração de senha. Ao clicar no link enviado pelo e-mail informado ele será redirecionado para a página de alteração, onde irá inserir e confirmar sua nova senha.

### Visualização e edição de perfil
 Os usuários vão poder visualizar os perfis de outros usuários e ver seus informações como: imagem de banner, foto de perfil, descrição e todos os artigos que ele já publicou na comunidade. Cada usuário cadastrado também terá sua página de perfil, onde ele poderá editar se nome, sobrenome, descrição, foto de perfil e o seu banner.

### Adição de artigos 
 Cada usuário cadastrado poderá criar artigos para publicar na plataforma, inserindo o título, subtítulo, uma imagem de capa, o link de algum vídeo do YouTube (opcional), e adicionar os parágrafos com seus respectivos títulos caso tenham. Para o usuário criar um novo artigo na plataforma, ele só pode fazer isto se a conta dele estiver verificada. Quando o artigo for criado ele ainda não será publicado, pois ficará na página do usuário dos artigos salvos para publicação, onde lá ele poderá editar, excluir ou publicar.
 
### Publicação de artigos
 Ao criar um novo artigo, ele não será publicado, mas ficará em uma página com todos os artigos criado pelo usuários que estão salvos para serem publicados, editados ou excluídos. Esta funcionalidades só estará disponível se a conta do usuário estiver verificada.
 
### Edição dos artigos
 Ao criar um artigo, o usuário pode edita-lo para alterar suas informações ou o conteúdo dos parágrafos caso ele queira. Esta funcionalidade estará disponível na página de artigos salvos para publicação ou na página do artigo já publicado, isso só aparecerá se o artigo for do respectivo usuário que o criou. Isto só será possível se a conta do mesmo estiver verificada.
 
### Exclusão dos artigos
 Ao criar um artigo, ele pode ser deletado por quem o criou, através da página dos artigos salvos para publicação do usuário ou na página do artigo já publicado, isso só aparecerá se o artigo for do respectivo usuário. Isto só será possível se a conta dele estiver verificada.
 
### Comentar
 Na página de cada artigo terá uma seção de comentários após a exibição de seu conteúdo e dos artigos relacionados, onde ele poderá fazer seu comentário sobre o artigo. Esta funcionalidade só estará disponível se o usuário estiver logado, se sua conta estiver verificada e se não tenha sido ele que publicou aquele artigo.
 
### Deletar comentário
 Ao comentar em algum artigo, o usuário que o fez poderá deleta-lo.
 
### Pesquisa de artigos 
 Na página dos artigos abaixo da seção dos artigos mais visualizados terá um campo de pesquisa, onde o usuário poderá pesquisar por termos que queira buscar.
 
### Paginação
 Todas as páginas onde possam ter uma grande quantidade de dados vindos do banco, é feita uma paginação para a organização dessas informações.
 
 

## Tecnologias utilizadas

### Front-End
- [HTML](https://developer.mozilla.org/pt-BR/docs/Web/HTML)
- [CSS](https://developer.mozilla.org/pt-BR/docs/Web/CSS)
- [JavaScript](https://developer.mozilla.org/pt-BR/docs/Web/JavaScript)
- [Font Awesome](https://fontawesome.com)

### Back-End
- [PHP](https://www.php.net)
- [MySQL](https://www.mysql.com)
- [Composer](https://getcomposer.org)
  - #### Bibliotecas utilizadas
    - **coffeecode/router :** responsável por fazer o sistema de rotas.
    -  **league/plates :** engine utilizada para fazer a renderização das views.
    -  **phpmailer/phpmailer :** utilizada para fazer o disparo de e-mails.
    -  **coffeecode/uploader :** responsável por fazer o upload dos arquivos da aplicação.
    -  **matthiasmullie/minify :** usado para gerar um arquivo minificado, tanto do css quanto do javascript.
    -  **nette/utils :** utilizado para fazer a paginação
      #### Todas as dependências utilizadas do composer foram abstraidas em uma classe separada para o seu uso, de forma desacoplada da aplicação, tendo assim mais segurança, mais flexibilidade na hora de usa-lo e não dependendo 100% daquele componente caso seja descontinuado, mesmo utilizado as ultimas versões destas bibliotecas.
      
      
## Arquitetura da aplicação

 Todo o sistema foi desenvolvido com uma base sólida no padrão de arquitetura MVC, onde toda a estrutura foi separada em models, views e controllers, tendo assim uma responsabilidade clara sobre cada camada, uma melhora na organização do código, manutenção simplificada e uma alta capacidade de escalabilidade do sistema como um todo, e assim atendendo demandas de um sistema muito mais complexo, que ao mesmo tempo nos proporciona um código limpo, coeso e de fácil leitura.
 
 Neste projeto, em um ambiente MVC, utilizei o design pattern Active Record, para fazer todas as interações com o banco de dados, que foi responsável por mapear objetos do modelo diretamente para tabelas do banco de dados, fornecendo uma camada de abstração que simplifica a interação com os dados. Trazendo uma série de benefícios, como transparência na persistência de dados, redução de código repetitivo e flexibilidade no acesso aos dados. Tendo assim um aumento na qualidade do código ao facilitar a manutenção em sistemas web baseados nesta arquitetura.
 
 Para gerenciar a conexão com o banco de dados foi utilizado o design pattern Singleton. Por mais que haja controvérsias à respeito do uso deste pattern, vi diversas vantagens para a sua utilização neste caso em específico, ao fazer a conexão com o banco de dados, pois garante uma única instância da conexão, economiza recursos da aplicação, por ter uma maior flexibilidade e ter o seu acesso de maneira global na aplicação, embora seu uso seja restrito somente ao Active Record, por ser uma classe que isola todas as interações com o banco de dados.

 
 ## Segurança e proteção de dados
  ### SQL injection
   Ataques de SQL injection ocorrem quando um invasor insere ou “injeta” um código SQL malicioso em uma aplicação web por meio de entradas de dados não confiáveis, podendo assim fazer qualquer tipo de ação à base de dados que está sendo atacada. Para proteger a minha aplicação desse tipo de ataque não fica muito difícil usando o PHP, pois toda comunicação com o banco de dados está sendo feita com o módulo PDO do PHP, que por padrão nos protege contra esse tipo de ataque, permitindo que trabalhemos com consultas parametrizadas ou prepared statements, que permitem a separação clara entre o código SQL e os dados fornecidos pelo usuário, além disto estamos validando e sanitizando todas as entradas de dados, garantindo que apenas informações válidas e seguras sejam aceitas. 
   
  ### XSS
   Ataques XSS (Cross-Site Scripting) é uma vulnerabilidade de segurança comum em aplicações web, que ocorrem quando um invasor consegue injetar e executar código malicioso na aplicação, geralmente escritos em javascript, que são executados no navegador do usuário final. Para proteger a sistema desse tipo de ataque, fiz a filtração, validação e sanitização de todos os dados de entrada, tanto na camada do servidor quanto na camada do cliente, removendo e escapando qualquer código HTML ou scripts indesejados.
 
  ### CSRF
   Ataques CSRF (Cross-Site Request Forgery) é um tipo de ataque onde o invasor explora a confiança do sistema em uma solicitação HTTP originada de um site confiável, enganando o usuário legítimo. Para proteger a aplicação desse tipo de ataque foi implementado um mecanismo de proteção baseado em tokens CSRF, onde em todo o formulário da aplicação é inserido um input hidden com o nome "csrf_token" e o valor com um número seguro gerado aleatoriamente e que também foi salvo na sessão do usuário, ao receber esta requisição no back-end da aplicação eu faço a verificação se o token enviado pelo formulário é o mesmo salvo na sessão, validando assim cada solicitação, para garantir que ela seja legítima e não seja proveniente de um ataque CSRF.
   
  ### Criptografia de senhas
   A criptografia de senhas é uma prática essencial para garantir a segurança das informações confidenciais dos usuários no sistema. Para garantir uma autenticação segura, quando o  usuário se cadastra no site ou quando ele faz a alteração da sua senha ao esquecer, antes de salvar as informações no banco de dados, fazemos a criptografia da senha, e sempre ao realizar o login, antes de fazer a validação da senha informada com a hash salvo no banco, verificamos se aquela senha criptografada precisa de um novo hash,  para verificar se a senha esta de acordo com as constantes globais definidas como padrão de criptografia na aplicação, se sim geramos outra criptografia desta senha e salvamos no banco.

   
## Escalabilidade e desempenho
 Este projeto foi desenvolvido utilizando as melhores práticas de programação da linguagem, e já utilizando todos os novos recursos a partir do PHP 8.0 para a otimização do código, como enums, constructor promotion property, named parameters e muito mais. Além disto a adoção da arquitetura MVC facilita o gerenciamento e a manutenção do código.

### Otimização das consutas ao banco de dados
 A utilização de técnicas eficientes para acesso ao banco de dados é fundamental para melhorar o desempenho da aplicação, para a otimização das consultas e pesquisas feitas pelo usuário aos artigos. Para isto, na criação do banco de dados, também foi criado um índice FULLTEXT à tabela dos artigos, nas colunas do titulo e subtitulo, tendo assim uma melhor consulta de dados ao fazer a busca, aproveitando recurso avançados para melhorar a experiência do usuário.

### Requisições assíncronas
 A maioria das as requisições POST do sistema são assíncronas, que quando combinado com a estrutura MVC traz inúmeros benefícios adicionais à aplicação que podem melhorar a eficiência e a experiência do usuário, como o desempenho aprimorado, pois requisições assíncronas permitem que o servidor atenda a um maior número de solicitações simultâneas, pois o servidor pode alocar seus recursos de forma mais eficiente, permitindo que ele dimensione verticalmente e suporte um aumento na carga de trabalho, podendo assim executar várias tarefas ao mesmo tempo, em vez de esperar pela resposta de cada requisição antes de prosseguir para a próxima.

## Banco de dados
 ### Abaixo esta o modelo relacional desenvolvido para este projeto:
 >⚠️ Para vizualizar o código dee criação do banco de dados, [clique aqui!👈](https://github.com/Fabriciope/TechNews/blob/main/sql-TechNews.sql).

  ![mer-db](https://github.com/Fabriciope/QuiroBrazil/assets/79289410/bb573c53-743a-4b8e-bb7d-d8eec55120e0)

---
<br>

### Contato: <a target="_black" href="mailto:fabricioalves.dev@gmail.com"> fabricioalves.dev@gmail.com <a>
