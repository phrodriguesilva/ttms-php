#!/bin/bash

# Função para exibir ajuda
show_help() {
    echo "Uso: ./docker-compose.sh [ambiente] [comando] [opções]"
    echo ""
    echo "Ambientes:"
    echo "  dev     - Ambiente de desenvolvimento"
    echo "  prod    - Ambiente de produção"
    echo ""
    echo "Comandos:"
    echo "  up      - Inicia os containers"
    echo "  down    - Para os containers"
    echo "  build   - Reconstrói os containers"
    echo "  logs    - Mostra os logs"
    echo ""
    echo "Opções:"
    echo "  -d      - Modo detached (para up)"
    echo ""
    echo "Exemplos:"
    echo "  ./docker-compose.sh dev up -d"
    echo "  ./docker-compose.sh prod build"
}

# Verifica se foi passado algum parâmetro
if [ $# -eq 0 ]; then
    show_help
    exit 1
fi

# Pega o ambiente e o comando
ENV=$1
shift
CMD=$1
shift

# Verifica o ambiente
case $ENV in
    dev)
        CONFIG="-f docker-compose.base.yml -f docker-compose.dev.yml"
        ;;
    prod)
        CONFIG="-f docker-compose.base.yml -f docker-compose.prod.yml"
        ;;
    *)
        echo "Ambiente inválido: $ENV"
        show_help
        exit 1
        ;;
esac

# Executa o comando
case $CMD in
    up|down|build|logs)
        docker-compose $CONFIG $CMD $@
        ;;
    *)
        echo "Comando inválido: $CMD"
        show_help
        exit 1
        ;;
esac
