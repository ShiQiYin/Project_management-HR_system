APP_CONTAINER_ID= # See "_set_app_ctr_id"

function app_up {
    while getopts "f" OPTION
    do
        case "${OPTION}" in
            f) MIGRATE_FRESH=1;;
        esac
    done

    cd "${APP_DIR}"
    _set_app_ctr_id

    # Steps 1-3 are executed only once per container lifecycle
    if [ -z "${APP_CONTAINER_ID}" ]; then
        print_header "(1/4) Start up ${GREEN}${APP_NAME}${NC}"
        [ -z $(docker image ls ${APP_IMAGE} -q) ] && docker compose build "application"
        [ "${DB_CONTAINER}" == "true" ] && CONFIG=docker-compose.yml || CONFIG=docker-compose-no-db.yml
        docker compose -f "${CONFIG}" up -d

        print_header "(2/4) Update dependencies"
        COMMAND="composer install"
        _exec_in_app "${COMMAND}"

        print_header "(3/4) Compile assets"
        COMMAND="yarn install; echo; yarn run build"
        _exec_in_app "${COMMAND}"
    fi;

    # Subsequent "app up" only affects the database
    print_header "(4/4) Update database"
    COMMAND="php artisan migrate"
    [ ! -z ${MIGRATE_FRESH} ] && COMMAND="${COMMAND}:fresh"
    _exec_in_app "${COMMAND} --seed"
    exit 0
}

function app_down {
    cd "${APP_DIR}"
    print_header "(1/1) Bring down ${GREEN}${APP_NAME}${NC}"
    docker compose -f "docker-compose.yml" down
    echo
    exit 0
}

function app_test {
    assert_env "IN" "local"
    print_header "Run unit test"

    cd "${APP_DIR}"
    LOG_FILE="storage/logs/unit-test.log"
    COMMAND="php artisan test --parallel --verbose"
    _exec_in_app "${COMMAND}" | tee "${LOG_FILE}"
    [ $(cat "${LOG_FILE}" | wc -l) -eq 0 ] && throw_error "*" "Failed to capture the test result!"
    [ ! -z "$(grep -iE "error|failure" "${LOG_FILE}")" ] && throw_error "*" "Unit testing has failed!"
    exit 0
}

function app_exec {
    COMMAND="${@}"
    _exec_in_app "${COMMAND}"
    exit 0
}

# ====================================================================================================
# Helper Functions ===================================================================================

function _set_app_ctr_id {
    [ -z "${APP_CONTAINER_ID}" ] && APP_CONTAINER_ID=$(docker ps -f "name=app" -q)
}

function _exec_in_app {
    COMMAND="${1}"
    _set_app_ctr_id
    [ -z "${APP_CONTAINER_ID}" ] && throw_error "*" "Application container is not found!"
    SCRIPT="cd /var/www/html; ${COMMAND}"
    docker exec -t "${APP_CONTAINER_ID}" bash -c "${SCRIPT}"
}