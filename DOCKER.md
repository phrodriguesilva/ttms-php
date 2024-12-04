# Documentação do Ambiente Docker

## Estrutura do Projeto

O projeto está estruturado para suportar ambientes de desenvolvimento e produção, cada um com suas próprias configurações e otimizações. A separação é feita através de arquivos `docker-compose` distintos e um arquivo base compartilhado.

## Arquivos de Configuração

1. **docker-compose.base.yml**: Contém configurações comuns a ambos os ambientes, como definições de rede e volumes persistentes para `mysql` e `redis`.

2. **docker-compose.dev.yml**: Configurações específicas para o ambiente de desenvolvimento, incluindo:
   - Servidor de desenvolvimento Vite com hot reload para o frontend.
   - Xdebug e logs detalhados para o backend.
   - MailHog para testes de email.
   - Banco de dados `mysql` e cache `redis` dedicados ao desenvolvimento.

3. **docker-compose.prod.yml**: Configurações específicas para o ambiente de produção, incluindo:
   - SSL e segurança configurados para o Nginx.
   - Otimizações de performance para o backend (OpCache).
   - Banco de dados `mysql` e cache `redis` dedicados à produção.

4. **docker/nginx/dev.conf** e **docker/nginx/prod.conf**: Configurações do Nginx para desenvolvimento e produção, respectivamente.

## Scripts de Gerenciamento

- **docker-compose.sh**: Script para facilitar o gerenciamento dos ambientes. Permite iniciar, parar, construir e visualizar logs dos containers de forma simplificada.

## Uso dos Ambientes

### Desenvolvimento

1. Torne o script executável:
   ```bash
   chmod +x docker-compose.sh
   ```

2. Inicie o ambiente de desenvolvimento:
   ```bash
   ./docker-compose.sh dev up -d
   ```

   - O frontend estará disponível em `http://localhost:8000` com hot reload.
   - O backend estará disponível em `http://localhost:8000/api`.

### Produção

1. Configure as variáveis de ambiente necessárias. Por exemplo, para a senha do banco de dados:
   ```bash
   export DB_PASSWORD=sua_senha_segura
   ```

2. Inicie o ambiente de produção:
   ```bash
   ./docker-compose.sh prod up -d
   ```

   - O frontend estará disponível em `https://ttms.com`.
   - O backend estará disponível em `https://ttms.com/api`.

## Considerações de Segurança

- **Senhas e Variáveis de Ambiente**: As senhas e outras informações sensíveis são passadas como variáveis de ambiente, garantindo que não fiquem expostas no código fonte.
- **SSL**: Certificados SSL são usados para proteger a comunicação em produção.
- **Headers de Segurança**: Configurados no Nginx para proteger contra vulnerabilidades comuns.

## Conclusão

Esta estrutura permite um desenvolvimento ágil e seguro, com ambientes claramente separados e configurados para suas respectivas necessidades. Para qualquer dúvida ou ajuste, consulte os arquivos de configuração e o script de gerenciamento.
