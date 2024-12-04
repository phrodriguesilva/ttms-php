-- Criar banco de dados se não existir
CREATE DATABASE IF NOT EXISTS ttms_dev;
CREATE DATABASE IF NOT EXISTS ttms_prod;

-- Garantir privilégios para o usuário ttms
GRANT ALL PRIVILEGES ON ttms_dev.* TO 'ttms'@'%';
GRANT ALL PRIVILEGES ON ttms_prod.* TO 'ttms'@'%';
FLUSH PRIVILEGES;
