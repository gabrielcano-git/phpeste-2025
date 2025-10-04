# Projeto XPTO - Guia de Contexto para IA

## 📋 Visão Geral do Projeto

O **Projeto XPTO** é uma plataforma de fidelidade desenvolvida em **PHP 8.3** com **CakePHP 2.x**. O sistema tem como objetivo aumentar as vendas das lojas de 10% a 20% (em até X dias) com desconto efetivo inferior a 2%.

## 🏗️ Arquitetura e Tecnologias

### Stack Principal
- **PHP**: 8.3+ (com strict typing obrigatório)
- **Framework**: CakePHP 2.x customizado
- **Banco de Dados**: MySQL/MariaDB
- **Cache**: Redis 7-alpine
- **Mensageria**: Apache Kafka com Zookeeper
- **Containerização**: Docker com docker-compose
- **Testes**: PHPUnit 9.5+

### Dependências Principais
```json
{
  "php": ">=8.3",
  "cakephp/cakephp": "dev-master as 2.10.24",
  "firebase/php-jwt": "^6.3",
  "ramsey/uuid": "^4.2",
  "sendgrid/sendgrid": "^8.1",
  "phpoffice/phpspreadsheet": "^1.29",
  "predis/predis": "^2.2",
  "sentry/sentry": "^4.6",
  "guzzlehttp/guzzle": "^7.8",
  "twilio/sdk": "^8.5",
  "monolog/monolog": "^3.9"
}
```

## 📁 Estrutura do Projeto

```
projeto-xpto/
├── app/                         # Aplicação CakePHP
│   ├── Config/                  # Configurações
│   │   ├── core.php             # Configurações principais
│   │   ├── database.php         # Configuração do banco
│   │   └── routes.php           # Rotas da aplicação
│   ├── Controller/              # Controladores
│   │   ├── Admin/               # Controllers administrativos
│   │   ├── Component/           # Componentes reutilizáveis
│   │   └── Integrations/        # Integrações externas
│   ├── Model/                   # Modelos de dados
│   │   ├── Behavior/            # Behaviors do CakePHP
│   │   ├── Datasource/          # Fontes de dados customizadas
│   │   └── Traits/              # Traits PHP
│   ├── Services/                # Camada de serviços
│   ├── Repository/              # Padrão Repository
│   ├── DTO/                     # Data Transfer Objects
│   ├── Utils/                   # Utilitários
│   ├── Plugin/                  # Plugins CakePHP
│   │   ├── Ads/                 # Plugin de anúncios
│   │   ├── AmazonS3/            # Integração S3
│   │   └── DebugKit/            # Debug toolkit
│   ├── View/                    # Views/Templates
│   ├── UnitTest/                # Testes unitários
│   └── webroot/                 # Assets públicos
├── lib/                         # Biblioteca CakePHP customizada
├── docker/                      # Configurações Docker
├── cypress/                     # Testes E2E
└── vendors/                     # Dependências Composer
```

## 🔧 Principais Funcionalidades

### 1. Sistema de Bonificação
- **Geração de Bônus**: Sistema automatizado de geração de bônus por vendas
- **Resgate de Bônus**: Multi-resgate com validação de margem máxima
- **Bonus Voucher**: Sistema de vale-bônus integrado
- **Campanhas**: Criação e gestão de campanhas promocionais

### 2. Gestão de Clientes
- **Customer Management**: Gestão completa de clientes e consumidores
- **Segmentação**: Sistema avançado de segmentação de clientes
- **RFV (Recência, Frequência, Valor)**: Análise comportamental
- **Enriquecimento de Dados**: Enriquecimento automático de dados de clientes

### 3. Integrações
- **E-commerce**: Integração com plataformas como Shopify, VTEX, Loja Integrada
- **Pagamentos**: PagSeguro, Vindi, Zoop
- **Comunicação**: SMS (Twilio), WhatsApp, E-mail (SendGrid)
- **CRM Externo**: Salesforce, Pipefy
- **PDV**: Múltiplas integrações de Ponto de Venda

### 4. Analytics e Relatórios
- **Dashboard Administrativo**: Painéis de controle completos
- **Relatórios Financeiros**: Análise de performance e ROI
- **Logs e Auditoria**: Sistema completo de logs
- **RedShift Integration**: Data warehouse para analytics

### 5. Automação
- **Campanhas Automáticas**: Campanhas baseadas em eventos
- **SMS/WhatsApp**: Envio automatizado de mensagens
- **NPS**: Sistema de Net Promoter Score automatizado
- **Reativação**: Campanhas de reativação de clientes

## 🎯 Principais Entidades

### Modelos Principais
- **Customer**: Lojas/clientes da plataforma
- **User**: Consumidores finais
- **Bonus**: Sistema de bônus
- **Campaign**: Campanhas promocionais
- **Brand**: Marcas e grupos econômicos
- **Master**: Sistema de gestão master
- **Transaction**: Transações financeiras

### Controllers Principais
- **AppController**: Controller base com funcionalidades comuns
- **CustomersController**: Gestão de clientes
- **BonusesController**: Gestão de bônus
- **CampaignsController**: Gestão de campanhas
- **UsersController**: Gestão de consumidores
- **ApiController**: APIs públicas

### Services
- **AdsBonusService**: Serviços de bônus publicitários
- **CampaignService**: Lógica de campanhas
- **LocationLookupService**: Serviços de geolocalização

## 🔐 Padrões de Desenvolvimento

### Convenções CakePHP 2.x
- **Naming**: PascalCase para classes, camelCase para métodos, snake_case para DB
- **Structure**: Singular para models, plural para controllers
- **Files**: Nome do arquivo = nome da classe

### Padrões de Código
- **Strict Typing**: Sempre usar `declare(strict_types=1);`
- **PSR-12**: Seguir padrões de código PSR-12
- **SOLID**: Aplicar princípios SOLID
- **Repository Pattern**: Usar para acesso a dados complexos
- **Service Layer**: Lógica de negócio em services

### Arquitetura
- **Controllers**: Finais e lightweight
- **Models**: Finais com behaviors para lógica comum
- **Services**: Finais e read-only
- **Error Handling**: Sistema robusto de exceções

## 🧪 Testes

### Estrutura de Testes
```
app/UnitTest/
├── DTO/                    # Testes de DTOs
├── Repository/             # Testes de repositórios
├── Services/              # Testes de serviços
└── Model/                 # Testes de modelos
```

### Executar Testes
```bash
# Todos os testes (dentro do container)
vendors/bin/phpunit --configuration phpunit.xml

# Teste específico
vendors/bin/phpunit --configuration phpunit.xml app/UnitTest/DTO/RtvDTOTest.php

# Atualizar autoload se necessário
composer dump-autoload
```

## 🐳 Ambiente de Desenvolvimento

### Docker Services
- **app**: PHP 8.3 com Xdebug
- **cache**: Redis para caching
- **kafka**: Mensageria
- **zookeeper**: Coordenação Kafka
- **kafka-ui**: Interface web para Kafka

### Setup Local
1. `docker compose down -v`
2. `docker compose build`
3. Criar `app/auth.json` com credenciais GitHub
4. `docker compose up -d`
5. `docker compose exec -it app sh`
6. `composer install` (na raiz e em app/)

### Xdebug
Configurado na porta 9003 com path mapping `/var/www/html` → `${workspaceFolder}`

## 📊 Integrações e APIs

### APIs Principais
- **API PDV V2**: Integração com pontos de venda
- **API E-commerce**: Integração com e-commerces
- **API Shopping Center**: Gestão de shopping centers
- **API Ads**: Sistema publicitário
- **API Services**: Serviços gerais

### Webhooks
- **VTEX**: E-commerce
- **Shopify**: E-commerce
- **PagSeguro**: Pagamentos
- **Vindi**: Assinaturas
- **Omie**: ERP

## 🔍 Pontos de Atenção

### Características Específicas
- Sistema **legacy** com CakePHP 2.x customizado
- **Multi-tenant** com diferentes configurações por cliente
- **Alto volume** de transações (10 bônus por segundo)
- **Integrações críticas** com múltiplos sistemas
- **Compliance** LGPD implementado

### Limitações Técnicas
- CakePHP 2.x (versão antiga, mas customizada)
- Algumas dependências podem estar desatualizadas
- Estrutura complexa devido ao crescimento orgânico
- Múltiplas integrações legadas

### Boas Práticas
- Sempre usar `App::uses()` para imports
- Seguir convenções de nomenclatura CakePHP
- Implementar testes para novas funcionalidades
- Usar services para lógica complexa
- Manter backward compatibility

## 📝 Notas Importantes

- **Idioma**: Sistema desenvolvido em Português Brasileiro
- **Timezone**: Configurado para horário brasileiro
- **Moeda**: Real brasileiro (BRL)
- **Compliance**: LGPD e outras regulamentações brasileiras
- **Escalabilidade**: Sistema preparado para alto volume de transações
