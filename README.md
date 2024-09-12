## Perguntas Técnicas

### Candidato: Eduardo Pazzini Zancanaro


### Sobre PHP / HTML / JS

#### 1. Sobre Doctrine2, assinale V para verdadeiro e F para falso:

    ( F ) Doctrine2 é um plugin cuja principal função é gerenciar a comunicação entre o cliente (navegador) e o servidor.
    
    ( F ) O método persist() armazena uma entidade na base de dados.
    
    ( V ) O método flush() realiza a sincronização das entidades gerenciadas pelo Doctrine2 com o banco de dados.
    
    ( F ) O método merge() é responsável exclusivamente por atualizar as informações de uma entidade.
    
    ( V ) Uma entidade é um objeto com uma identidade.
    
    ( V ) DQL (Doctrine Query Language) é uma linguagem utilizada para recuperar informações persistidas pelo gerenciamento de entidades.
    
    ( V ) Doctrine2 é um framework que possibilita a abstração da base de dados relacional, permitindo a manipulação dos dados através de OO.
    
    ( V ) Uma entidade “A” possui relacionamento com a entidade “B”, este relacionamento foi mapeado como “EAGER”. Desta forma ao recuperar a entidade “A”, as informações da entidade “B” serão automaticamente carregadas.


#### 2. Sobre Zend Framework 2, assinale V para verdadeiro e F para falso:

    ( V ) Zend/Form auxilia na criação e validação de formulários.
    
    ( F ) Módulos são utilizados apenas para separar áreas de um site (Ex. Painéis Administrativos).
    
    ( V ) Para ativar um módulo corretamente, basta abrir o arquivo “zf2/config/application.config.php” e adicionar o nome do módulo no array lá presente.
    
    ( F ) O primeiro arquivo a ser executado pela aplicação é o Module.php que fica no diretório /module/nomeDoModule/.
    
    ( F ) Toda Action de um Controller deve ter uma View com o mesmo nome.
    
    ( V ) Os serviços em invokables apenas definem o nome totalmente qualificado de uma classe sem construtor ou construtor sem argumentos.
    
    ( F ) View Helpers são utilizadas para executar tarefas complexas dentro do scripts da view. Um exemplo comum de bom uso é uma consulta pesada na base de dados.
    
    ( V ) Para que um Controller seja acessado, deve ser configurada uma rota para o mesmo através de configuração do módulo.


#### 3. Sobre JQuery, assinale V para verdadeiro e F para falso:

    ( V ) O seletor $(“div p”) seleciona todos os elementos <p> que sejam descendentes de um elemento <div>.
    
    ( F ) O seletor $(“div > p”) seleciona todos os elementos <p> que sejam descendentes de um elemento <div>.
    
    ( F ) O comando $(“.nome”).hide(); esconde um elemento cujo o id é nome.
    
    ( F ) O comando $(“#teste”).load(“www.url.com/conteudo”); carregará dentro do elemento com id teste o conteúdo retornado do request. Até mesmo scripts javascript externos que façam parte deste conteúdo serão importados.
    
    ( F ) O comando $(“p”).style(“background-color, “red”); Aplica fundo vermelho à todos os elementos <p>.
    
    ( V ) A maioria dos navegadores atuais suportam nativamente o uso do JQuery.
    
    ( F ) O seletor $(“:disabled”) retornará todos os elementos escondidos.
    
    ( F ) O comando $(“#tabela”).ready(function(){alert(“teste”);}) executará um alerta assim que o elemento com id tabela for carregado na página.


### Sobre NodeJs

    1. Como você lida com exceções e erros não tratados em um aplicativo Node.js
    R: Através do process.on('uncaughtException') e process.on('unhandledRejection') capturaria os erros e salvaria
    em log ou aviso para que fosse criado um tratamento.
---
    2. Descreva o ciclo de vida de um módulo em Node.js. Como você exporta e importa módulos?
    R: O módulo passa pelo seguinte ciclo de vida, assim que o modulo é requisitado, primeiro ele é carregado,
    executado (salva em cache as informações para não ser necessário realizar todo o ciclo novamente), assim 
    realizando a exportação das funções/objetos/valores para serem utilizados, caso ele seja chamado novamente será
    utilizado o cache. Para realizar a exportação é utilizado `export`, Ex.:
    export function showDrivers() { return this.drivers }
    Para realizar a importação pode ser utilizado `import {showDrivers} from './drivers.js'` 

--- 
    3. O que é o Event Loop no Node.js e qual é seu papel no processamento assíncrono?
    R: Event Loop é um mecanismo que possibilita a execução de forma assíncrona, onde o node.js sendo single thread,
    requisita para que ações do tipo I/O ou API sejam executados por outras partes do sistema, fazendo com que ele não 
    precise para de realizar a sua execução.

--- 
    4. Explique a diferença entre "require" e "import" no Node.js. Quando você usaria um em vez do outro?
    R: "require" realiza a importação ao carregar o módulo solicitado, já o “import” realiza de forma assíncrona.
---
    5. Como o Node.js lida com threads e concorrência?
    R: Apesar do node rodar em apenas uma thread, ele utiliza mecanismos para melhor desempenho e lidar com a 
    concorrência, ele utiliza o Event Loop, Custer e Worker Threads.  
---
    6. O que é o middleware no contexto do Node.js? Como você usaria middleware em um aplicativo Express.js?
    R: São funções que são executadas em uma requisição HTTP. Utilizando express,
    como, por exemplo, podemos adicionar uma validação de acesso, podendo ser global ou em rotas específicas. 
---
    7. O que é o Express.js e por que é amplamente usado no desenvolvimento Node.js
    R: Express é um framework desenvolvido para lidar com requisições HTTP, ele atua como um facilitador para o 
    desenvolvimento de APIs, contendo rotas e middlewares .
---
    8. Como você lida com a autenticação de usuários em um aplicativo Node.js?
    R: Utilizando JWT, onde o usuário realiza a requisição de Login para o aplicativo, e caso coincida as informações
    é retornando um json com token para que ele consiga realizar acesso a locais ou informações específicas.  
---
    9. Como você faria a comunicação entre 2 serviços Node rodando em Contêineres separados?
    R: Realizaria a conexão via Kafka ou RabbitMQ ou via requisições do tipo HTTP/REST.
---
    10. Qual biblioteca utiliza para conexão com API de terceiros?
    R: Axios
---
    11. Como você controlaria a disponibilidade de um serviço para que em casos de erros, o mesmo não pare?
    R: Aplicaria uma forma de "retry" na requisição/execução, para caso seja um problema momentâneo, caso ele realizasse um determinado número 
    de tentativas, o sistema iria se auto reiniciar mantendo as informações.




### Exercício Prático

Utilizando Zend Framework 2, Doctrine2, JQuery e outros recursos de sua preferência. Desenvolva um pequeno projeto que deve conter as seguintes telas:

    • CRUD de Veículos (listar, cadastrar, editar e remover)
        ◦ Placa (String);
            ▪ Obrigatório;
            ▪ Máximo 7 caracteres;
        ◦ Renavam (String):
            ▪ Máximo 30 caracteres;
        ◦ Modelo (String);
            ▪ Obrigatório;
            ▪ Máximo 20 caracteres;
        ◦ Marca (String);
            ▪ Obrigatório;
            ▪ Máximo 20 caracteres;
        ◦ Ano (Integer);
            ▪ Obrigatório;
        ◦ Cor (String);
            ▪ Obrigatório;
            ▪ Máximo 20 caracteres;

    • CRUD de Motoristas (listar, cadastrar, editar e remover);
        ◦ Nome (String);
            ▪ Obrigatório;
            ▪ Máximo 200 caracteres;
        ◦ RG (String);
            ▪ Obrigatório;
            ▪ Máximo 20 caracteres;
        ◦ CPF (String);
            ▪ Obrigatório;
            ▪ Máximo 11 caracteres;
        ◦ Telefone (String);
            ▪ Máximo 20 caracteres;
        ◦ Veículo
            ▪ Associação de relacionamento com Veículo da base;

##### BONUS: Criar uma tela com um mapa utilizando Google Maps e inserir dentro do mapa alguns Markers com InfoWindows contendo Placa do veículo e Nome do motorista (Dados fixos no código).

Para o CRUD, realizar a criação do BD e tabelas localmente e enviar os scripts SQL.


## Como Executar

### Instalação

1. Clone o repositório
```bash
  git clone https://github.com/oduardu/trafegus-teste-tecnico.git
```

2. Criar o arquivo .env e preencha com as inforamções necessárias
```bash
  cp .env.example .env
```

3. Suba o container do banco de dados
```bash
  docker-compose --env-file .env -f database/docker-compose.yml up -D
```

4. Instale as dependências
```bash
  cd trafegus-system; composer install
```

5. Crie o arquivo `doctrine_orm.local.php` em `config/autoload/` e preencha com as informações do banco de dados baseado no arquivo `doctrine_orm.local.php.dist`


6. Altere a sua API_GOOGLE_KEY (Api do google Maps) no arquivo `config/autoload/global.php`


7. Execute o php server
```bash
  php -S 0.0.0.0:8080 -t public/ public/index.php
``` 