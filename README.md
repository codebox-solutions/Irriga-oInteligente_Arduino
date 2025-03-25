# Irrigação Inteligente com Arduino

## Descrição
Este projeto é um sistema de irrigação inteligente que utiliza um Arduino para monitorar a temperatura, umidade do ar e umidade do solo, e controlar uma bomba de água automaticamente. O objetivo é garantir a irrigação eficiente de plantas e culturas, economizando água e melhorando a produtividade.

## Funcionalidades
- Monitoramento de temperatura e umidade do ar utilizando o sensor DHT11.
- Leitura da umidade do solo (simulada).
- Controle automático de uma bomba de água com base nos níveis de umidade do solo.
- Armazenamento dos dados dos sensores em um banco de dados MySQL.
- Visualização dos dados em gráficos interativos através de uma interface web.

## Utilização

### Hardware Necessário
- Arduino (qualquer modelo compatível)
- Sensor DHT11
- Bomba de água
- Conexão USB para o Arduino

### Software Necessário
- Arduino IDE
- Python 3.x
- MySQL

### Configuração

#### Arduino:
1. Conecte o sensor DHT11 ao pino digital 9 do Arduino.
2. Conecte a bomba de água ao pino digital 7 do Arduino.
3. Carregue o código `code.ino` no Arduino.

#### Python:
1. Instale as bibliotecas necessárias: `pyserial` e `mysql-connector-python`.
2. Execute o script `salvar_dados_mysql.py` para receber e armazenar os dados dos sensores no banco de dados MySQL.

#### PHP:
1. Configure um servidor web com suporte a PHP e MySQL.
2. Coloque o arquivo `index.php` no diretório do servidor web.
3. Acesse a interface web para visualizar os dados dos sensores em gráficos interativos.

## Como Funciona
O Arduino lê os valores de temperatura e umidade do ar do sensor DHT11 e simula a leitura da umidade do solo. Os dados são enviados via porta serial para um script Python que armazena essas informações em um banco de dados MySQL. Uma interface web em PHP exibe os dados em gráficos, permitindo a visualização e análise dos níveis de temperatura, umidade do ar e umidade do solo.

## Aplicações
- **Automação Agrícola:** Monitoramento e controle de irrigação em fazendas para melhorar a eficiência do uso da água e aumentar a produtividade das colheitas.
- **Jardinagem Doméstica:** Automação da rega de jardins residenciais para garantir que as plantas recebam a quantidade adequada de água.

## Palavras-chave
- Irrigação Inteligente
- Arduino
- DHT11
- Bomba de Água
- Automação Agrícola
- Banco de Dados MySQL
- PHP
- Python

## Contribuições
Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e enviar pull requests.
