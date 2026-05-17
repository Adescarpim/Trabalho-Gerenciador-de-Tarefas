Projeto Criado por Ademir José Wilsek Scarpim

GERENCIADOR DE TAREFAS COLABORATIVO

Projeto desenvolvido em PHP nativo com:
- PHP Orientado a Objetos
- MySQL
- PDO
- MVC simples
- GET e POST
- Sessões e Cookies
- HTML semântico
- CSS simples

COMO RODAR NO XAMPP:

1. Copie a pasta gerenciador_tarefas_mysql para dentro da pasta htdocs do XAMPP.
2. Abra o XAMPP e inicie Apache e MySQL.
3. Acesse o phpMyAdmin.
4. Importe o arquivo banco.sql.
5. No navegador, acesse:
   http://localhost/gerenciador_tarefas_mysql

CONFIGURAÇÃO DO BANCO:
O arquivo de conexão está em:
dal/Conn.php

Configuração padrão:
host: localhost
banco: gerenciador_tarefas
usuario: root
senha: vazia

CASO SUA SENHA DO MYSQL SEJA DIFERENTE:
Altere a variável $password dentro de dal/Conn.php.
