# Sistema de Logs

Este projeto é uma API em Laravel para registrar logs de qualquer sistema de gestão. Ele utiliza Docker para o ambiente de desenvolvimento e MySQL como banco de dados. Utilizei o Redis para enfileiramento dos logs.

## Funcionalidades

- Receber logs via uma rota HTTP
- Processar logs em uma fila para melhor desempenho
- Persistir logs no banco de dados MySQL

## Requisitos

- Docker
- Docker Compose

## Instalação

1. Clone o repositório:

    ```bash
    git clone https://github.com/limanetomcz/fusca.git
    cd fusca

2. Executando o composer:
    ```bash
    docker run --rm     -u "$(id -u):$(id -g)"     -v "$(pwd):/var/www/html"     -w /var/www/html     laravelsail/php82-composer:latest     composer install --ignore-platform-reqs

3. Levantando os containers
    
    ```bash
    ./vendor/bin/sail up -d

## Gravar Logs

Para gravar logs, envie uma requisição POST para a rota /api/logs com os seguintes dados no corpo da requisição:   

{
  "operation": "Indique qual é a DML (insert, delete, update)",
  "old_data":  "Preencha com os dados antes da alteração",
  "new_data":  "Preencha com os dados atualizados",
  "author":    "informe o identificador do usuário no sistema de gestão",
  "ip":        "informe o ip do author",
  "table":     "nome da tabela onde os dados estão sendo manipulados"
}


## Exemplo de uso com curl:

curl -X POST http://localhost/api/logs \
    -H "Content-Type: application/json" \
    -d '{
        "operation": "update",
        "old_data":  "{"nome: jose"}",
        "new_data":  "{"nome: JOSE"}",
        "author":    "JOSE.ANTONIO",
        "ip":        "192.68.0.2",
        "table":     "tb_usuario"
    }'

## Contribuição

Faça um fork do projeto.
Crie uma branch para sua feature (git checkout -b minha-feature).
Commit suas mudanças (git commit -am 'Adiciona minha feature').
Envie para a branch (git push origin minha-feature).
Crie um novo Pull Request.    
Entre em contato: lima@praticasti.com.br

## Licença
Este projeto está licenciado sob a MIT License.

Adapte o conteúdo conforme necessário para refletir com precisão as especificidades do seu projeto.
