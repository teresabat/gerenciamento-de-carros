# Car Management Dashboard

## Visão Geral

Este é um projeto de dashboard para gerenciamento de carros. O sistema permite que os administradores adicionem, atualizem e excluam registros de carros, enquanto os visitantes podem apenas visualizar os registros. Além disso, há uma funcionalidade de pesquisa para filtrar carros pelo modelo.

## Funcionalidades

- **Admin:**
  - Adicionar novos carros.
  - Atualizar informações dos carros existentes.
  - Excluir carros.
  - Pesquisar carros pelo modelo.
- **Visitante:**
  - Visualizar lista de carros.
  - Pesquisar carros pelo modelo.

## Tecnologias Utilizadas

- **Frontend:**
  - HTML5
  - CSS3 (com Bootstrap para estilização)
- **Backend:**
  - PHP
  - MySQL
- **Sessões e Autenticação:**
  - PHP Sessions
  - Hashing de senhas com `password_hash` e `password_verify`

## Estrutura do Projeto

````
├── assets
│ └── style-create.css
│ └── style-dashboard.css
│ └── style-update.css
│ └── global.css
├── css
│ └── bootstrap.css
├── db.php
├── index.html
├── dashboard.php
├── create_car.php
├── update_car.php
├── delete_car.php
├── login.php
├── logout.php
├── register.php
└── README.md
````


## Configuração do Banco de Dados

Crie um banco de dados MySQL e uma tabela chamada `users` com a seguinte estrutura:

```sql
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','visitor') NOT NULL DEFAULT 'visitor',
  PRIMARY KEY (`id`)
);

CREATE TABLE `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `ano` int(4) NOT NULL,
  PRIMARY KEY (`id`)
);
````

## Instalação
1. Clone o repositório
````
git clone https://github.com/usuario/car-management-dashboard.git
````
2. Navegue até o diretório do projeto
````
cd car-management-dashboard
````
3. Configure a conexão com o banco de dados no arquivo `db.php`:
````
<?php
$conn = new mysqli('localhost', 'username', 'password', 'database_name');

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
````
4. Importe as tableas SQL para o seu banco de dados.
5. Inicie o servicor local (por ex, o xampp) e acesse a index no seu navegador

