# Sistema de Agendamento de Sala de Reuniões

## Instalação e Criação do Banco de Dados

Para iniciar o uso do Sistema de Agendamento de Sala de Reuniões, siga os passos abaixo:

1. **Instalação do ambiente de desenvolvimento:**
   - Baixe e instale o XAMPP (ou outro ambiente similar que inclua Apache, MySQL e PHP).
   - Ative o servidor Apache e o MySQL no XAMPP.

## Estrutura do Banco de Dados

O banco de dados do Sistema de Agendamento de Sala de Reuniões foi projetado para atender aos requisitos funcionais e não funcionais do sistema. A estrutura do banco de dados foi escolhida com base nos seguintes aspectos:

1.1 **Entidades Principais:**
   - O banco de dados possui duas entidades principais: "salas_reunioes" e "agendamentos".
   - A tabela "salas_reunioes" armazena informações sobre as salas de reuniões disponíveis, como nome, capacidade, recursos disponíveis e status de disponibilidade.
   - A tabela "agendamentos" registra os agendamentos feitos pelos usuários, incluindo informações sobre a sala agendada, data, horário, organizador, assunto da reunião e número de participantes.

1.2 **Relacionamento entre Entidades:**
   - Existe um relacionamento de "um para muitos" entre as entidades "salas_reunioes" e "agendamentos". Isso significa que uma sala de reuniões pode ter vários agendamentos, mas um agendamento pertence a apenas uma sala de reuniões. Esse relacionamento é representado pela chave estrangeira "sala_id" na tabela "agendamentos", que faz referência à chave primária "id" na tabela "salas_reunioes".

1.3 **Flexibilidade e Eficiência:**
   - A estrutura do banco de dados foi projetada para ser flexível o suficiente para lidar com as operações de gerenciamento de salas de reuniões e agendamentos de forma eficiente.
   - Utilizamos tipos de dados adequados para armazenar informações como datas, horários e textos, garantindo integridade e consistência dos dados.

1.4 **Persistência e Confiabilidade:**
   - Os dados do sistema são armazenados em um banco de dados MySQL ou MariaDB para garantir persistência e confiabilidade.
   - As operações de CRUD (Create, Read, Update, Delete) são suportadas para as entidades "salas_reunioes" e "agendamentos", permitindo que os usuários gerenciem efetivamente as informações do sistema.

Essa estrutura de banco de dados foi escolhida para atender aos requisitos de funcionalidade, eficiência e confiabilidade do Sistema de Agendamento de Sala de Reuniões.


2. **Criação do banco de dados:**
   - Acesse o phpMyAdmin pelo navegador, geralmente através de `http://localhost/phpmyadmin`.
   - Faça login com as credenciais padrão do MySQL.
   - Na interface do phpMyAdmin, clique na aba "SQL".
   - Cole e execute os seguintes códigos SQL para criar o banco de dados e as tabelas necessárias:

___
   ```sql
   CREATE DATABASE IF NOT EXISTS agendamento;

   USE agendamento;

   CREATE TABLE salas_reunioes (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nome VARCHAR(100),
       capacidade INT,
       recursos_disponiveis VARCHAR(255),
       status VARCHAR(20)
   );

   CREATE TABLE agendamentos (
       id INT AUTO_INCREMENT PRIMARY KEY,
       sala_id INT,
       data DATE,
       horario TIME,
       horario_final TIME,
       tempo_utilizacao INT,
       organizador VARCHAR(100),
       assunto VARCHAR(255),
       num_participantes INT,
       FOREIGN KEY (sala_id) REFERENCES salas_reunioes(id)
   );
```

___   
Por favor, verifique se os passos estão corretos de acordo com o seu ambiente e banco de dados.

## Arquivo `conexao.php`

O arquivo `conexao.php` é responsável por conectar o sistema ao banco de dados MySQL utilizado pelo sistema de agendamento de salas de reuniões. Ele contém o código PHP necessário para estabelecer essa conexão.

### Localização e Estrutura do Arquivo:

Este arquivo deve ser criado dentro da pasta do projeto do sistema de agendamento, que geralmente é armazenado dentro do diretório `htdocs` do XAMPP. A pasta pode ser denominada como `sistemaagendamento` para facilitar a organização.

### Ambiente de Desenvolvimento:

Para codificar e editar os arquivos do sistema de agendamento, é recomendado utilizar um editor de texto ou um ambiente de desenvolvimento integrado (IDE) como o Visual Studio Code (VSCode). O VSCode é uma ferramenta popular e gratuita que oferece recursos avançados para desenvolvimento web.

### Acesso ao Arquivo:

Para acessar o arquivo `conexao.php`, basta navegar até a pasta do projeto dentro do diretório `htdocs` do XAMPP usando o explorador de arquivos do seu sistema operacional. Em seguida, você pode abrir o arquivo utilizando o VSCode ou qualquer editor de texto de sua preferência.

Para acessar o arquivo `conexao.php` no navegador, basta abrir o link 
```
http://localhost/sistemaagendamento/conexao.php
```
no navegador, e tirar o comentário 
```php
} else {
    // echo "Conexão bem-sucedida!";
}
```
para ver se a conexão foi bem feita ou não

### Funcionalidade:

Este arquivo estabelece uma conexão com o banco de dados MySQL utilizando as informações de servidor, nome de usuário, senha e nome do banco de dados.
- Se a conexão for bem-sucedida, ele retorna uma instância da classe `mysqli` que representa a conexão.
- Se a conexão falhar, ele exibe uma mensagem de erro e encerra a execução do script.

Este arquivo geralmente é incluído em outros scripts PHP que necessitem de acesso ao banco de dados, centralizando as informações de conexão e facilitando a manutenção do sistema.

Não são realizadas operações de consulta, inserção, atualização ou exclusão de dados neste arquivo. Ele apenas configura a conexão com o banco de dados para ser utilizada em outros scripts PHP do sistema.

 
# Demais arquivos
A partir de agora, vamos falar dos outros arquivos, para acessar, agora, você pode abrir, com seu apache ativado, o link 
```
http://localhost/sistemaagendamento
```
e ir acompanhando no navegador, pois temos o header, no entanto, para acessar um arquivo especifico, basta colocar o /nome_do_arquivo.pho

## Arquivo `gestao.php`

O arquivo `gestao.php` é responsável pela gestão das salas de reuniões, permitindo o cadastro de novas salas e a visualização das salas já cadastradas. Abaixo está uma explicação detalhada do código:

### Funcionalidades Principais:

1. **Conexão com o Banco de Dados:**
   - O arquivo inclui o arquivo `conexao.php`, que contém o código para estabelecer a conexão com o banco de dados MySQL.

2. **Cadastro de Nova Sala:**
   - Quando o formulário de cadastro de nova sala é submetido (`$_SERVER["REQUEST_METHOD"] == "POST"`), os dados são coletados e inseridos no banco de dados.
   - Os campos `nome`, `capacidade` e `recursos` são obtidos do formulário e inseridos na tabela `salas_reunioes`.

3. **Exclusão de Sala:**
   - Se o parâmetro GET `excluir` for verdadeiro e o parâmetro GET `id` estiver definido, uma solicitação de exclusão de sala é processada.
   - A sala com o ID correspondente é removida da tabela `salas_reunioes`.

4. **Listagem de Salas Cadastradas:**
   - Uma consulta SQL é realizada para selecionar todas as salas cadastradas na tabela `salas_reunioes`.
   - As informações das salas são exibidas em uma tabela HTML, mostrando o nome, capacidade, recursos disponíveis, status e opções para editar ou excluir cada sala.

5. **Navegação entre Páginas:**
   - O arquivo inclui uma barra de navegação Bootstrap com links para as páginas inicial (`index.php`), de agendamento (`agendamento.php`) e de gestão (`gestao.php`).

### Destaques:

- Utilização de PHP para interagir com o banco de dados e processar as solicitações de cadastro e exclusão de salas.
- Integração com Bootstrap para aprimorar a interface do usuário e tornar o design responsivo.
- Utilização de consultas SQL para recuperar e exibir as salas cadastradas de forma dinâmica na tabela HTML.

Este arquivo é fundamental para a gestão das salas de reuniões no sistema de agendamento, permitindo que os usuários cadastrem novas salas e realizem operações de manutenção sobre as salas já existentes.
## Arquivo `gestaoeditar.php`

O arquivo `gestaoeditar.php` é responsável pela edição das informações de uma sala de reuniões existente. Abaixo está uma explicação detalhada do código:

### Funcionalidades Principais:

1. **Conexão com o Banco de Dados:**
   - O arquivo inclui o arquivo `conexao.php`, que contém o código para estabelecer a conexão com o banco de dados MySQL.

2. **Recuperação das Informações da Sala:**
   - O parâmetro GET `id` é verificado para garantir que seja um valor numérico válido.
   - Se o parâmetro `id` for válido, uma consulta SQL é executada para recuperar as informações da sala com o ID correspondente da tabela `salas_reunioes`.
   - Se uma sala com o ID especificado existir, as informações são armazenadas em variáveis para preencher os campos do formulário de edição. Caso contrário, o usuário é redirecionado de volta para a página de gestão (`gestao.php`).

3. **Atualização das Informações da Sala:**
   - Quando o formulário de edição de sala é submetido (`$_SERVER["REQUEST_METHOD"] == "POST"`), os dados atualizados são coletados e atualizados no banco de dados.
   - Os campos `nome`, `capacidade` e `recursos` são obtidos do formulário e atualizados na tabela `salas_reunioes` para a sala correspondente.

4. **Navegação entre Páginas:**
   - O arquivo inclui uma barra de navegação Bootstrap com links para as páginas inicial (`index.php`), de agendamento (`agendamento.php`) e de gestão (`gestao.php`).

### Destaques:

- Utilização de PHP para interagir com o banco de dados e processar as solicitações de atualização de informações da sala.
- Integração com Bootstrap para aprimorar a interface do usuário e tornar o design responsivo.
- Utilização de consultas SQL para recuperar e atualizar as informações da sala selecionada.

Este arquivo permite que os usuários editem as informações de uma sala de reuniões existente, fornecendo uma interface simples e intuitiva para gerenciar as salas cadastradas no sistema de agendamento.

## Arquivo `agendamento.php`

O arquivo `agendamento.php` é responsável por permitir que os usuários agendem salas de reuniões disponíveis. Abaixo está uma explicação detalhada do código:

### Funcionalidades Principais:

1. **Conexão com o Banco de Dados:**
   - O arquivo inclui o arquivo `conexao.php`, que contém o código para estabelecer a conexão com o banco de dados MySQL.

2. **Agendamento de Salas:**
   - Quando o formulário de agendamento é submetido (`$_SERVER["REQUEST_METHOD"] == "POST"`), os dados do formulário são coletados e verificados.
   - Uma consulta SQL é realizada para verificar se a sala está disponível para o horário selecionado. Se a sala já estiver agendada para esse horário, uma mensagem de alerta é exibida.
   - Se a sala estiver disponível, o agendamento é inserido na tabela `agendamentos`.

3. **Listagem de Agendamentos:**
   - Os agendamentos feitos são recuperados do banco de dados e exibidos em uma tabela.
   - As informações exibidas incluem o nome do organizador, assunto da reunião, data, horário, tempo de utilização, número de participantes e número da sala.
   - Para cada agendamento, há um botão "Excluir" que permite ao usuário cancelar o agendamento correspondente.

4. **Navegação entre Páginas:**
   - O arquivo inclui uma barra de navegação Bootstrap com links para as páginas inicial (`index.php`), de agendamento (`agendamento.php`) e de gestão (`gestao.php`).

### Destaques:

- Utilização de PHP para interagir com o banco de dados e processar os agendamentos de salas.
- Utilização de consultas SQL para verificar a disponibilidade da sala e recuperar os agendamentos feitos.
- Exibição de mensagens de alerta em caso de sala já agendada para o horário selecionado.

Este arquivo fornece aos usuários uma interface para agendar salas de reuniões disponíveis e visualizar os agendamentos existentes.

## Arquivo `excluir_agendamento.php`

O arquivo `excluir_agendamento.php` é responsável por excluir um agendamento de reunião existente. Abaixo está uma explicação detalhada do código:

### Funcionalidades Principais:

1. **Conexão com o Banco de Dados:**
   - O arquivo inclui o arquivo `conexao.php`, que contém o código para estabelecer a conexão com o banco de dados MySQL.

2. **Exclusão do Agendamento:**
   - O arquivo verifica se foi fornecido um parâmetro GET `id`, que representa o ID do agendamento a ser excluído.
   - Se o parâmetro `id` for fornecido, uma consulta SQL é executada para excluir o agendamento correspondente da tabela `agendamentos`.
   - Após a exclusão bem-sucedida, o usuário é redirecionado de volta para a página de agendamento (`agendamento.php`).

3. **Feedback de Erro:**
   - Se o parâmetro `id` não for fornecido, uma mensagem de erro é exibida informando que o ID do agendamento não foi fornecido.

### Destaques:

- Utilização de PHP para interagir com o banco de dados e excluir agendamentos de reuniões.
- Utilização de consultas SQL para excluir registros da tabela `agendamentos`.
- Redirecionamento do usuário de volta para a página de agendamento após a exclusão bem-sucedida.

Este arquivo fornece uma funcionalidade essencial para o sistema de agendamento, permitindo aos usuários cancelar agendamentos de reuniões existentes.
## Arquivo `index.php`

O arquivo `index.php` é a página inicial do sistema de agendamento de salas de reuniões. Abaixo está uma explicação detalhada do código:

### Funcionalidades Principais:

1. **Conexão com o Banco de Dados:**
   - O arquivo inclui o arquivo `conexao.php`, que contém o código para estabelecer a conexão com o banco de dados MySQL.

2. **Visão Geral das Salas:**
   - O arquivo executa uma consulta SQL para recuperar todas as salas de reuniões existentes na tabela `salas_reunioes`.
   - As informações das salas (nome e status) são exibidas em uma tabela na página inicial.
   - Se não houver salas disponíveis, uma mensagem indicando isso é exibida na tabela.

3. **Links de Navegação:**
   - Links de navegação são fornecidos para direcionar o usuário para as páginas de agendamento (`agendamento.php`) e gestão de salas (`gestao.php`).

### Destaques:

- Utilização de PHP para interagir com o banco de dados e recuperar informações das salas de reuniões.
- Utilização de consultas SQL para recuperar dados da tabela `salas_reunioes`.
- Exibição das informações das salas em uma tabela na página inicial.
- Links de navegação para facilitar a navegação do usuário para outras partes do sistema.

Este arquivo fornece uma visão geral das salas de reuniões disponíveis no sistema, permitindo aos usuários acessar rapidamente outras funcionalidades do sistema.

