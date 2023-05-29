# Utilities

# ==================================================
# Initialization
# ==================================================
# Enable colours for STDOUT terminal
if test -t 1; then
    ncolors=$(tput colors)
    if test -n "$ncolors" && test "$ncolors" -ge 8; then
        BOLD="$(tput bold)"
        YELLOW="$(tput setaf 3)"
        GREEN="$(tput setaf 2)"
        RED="$(tput setaf 1)"
        NC="$(tput sgr0)"
    fi
fi

CALLER_DIR=$(pwd)
APP_DIR=$(cd -- "${SCRIPT_DIR}/.." &>/dev/null && pwd)

# Verify operating system
case "$(uname -s)" in
    MINGW*)     MACHINE="Windows";;
    Linux*)     MACHINE=linux;;
    Darwin*)    MACHINE=mac;;
    *)          MACHINE="UNKNOWN"
esac

if [ "$MACHINE" == "mac" ]; then
    rsync -u "${SCRIPT_DIR}/resources/git-hooks/"* "${APP_DIR}/.git/hooks/"
else
    cp -uf "${SCRIPT_DIR}/resources/git-hooks/"* "${APP_DIR}/.git/hooks/"
fi

[ -f "${APP_DIR}/.env" ] && source "${APP_DIR}/.env"

# ==================================================
# Helper Functions
# ==================================================
function print_header {
    MESSAGE="${1}"
    echo
    printf '%*s\n' "${COLUMNS:-$(tput cols)}" '' | tr ' ' -
    echo $MESSAGE
    printf '%*s\n' "${COLUMNS:-$(tput cols)}" '' | tr ' ' -
    echo
}

function assert_env {
    STATE="${1}"
    ENV=$(echo "${2}" | tr "[:upper:]" "[:lower:]")
    LIST=("IN" "NOT IN")
    EXISTS=$(echo "${STATE}" | grep -w "${LIST}")
    [ -z "${EXISTS}" ] && throw_error "*" "Unsupported operator! (${STATE})"
    ([ "${STATE}" == "IN" ] && [ "${ENV}" != "${APP_ENV}" ]) && throw_error "*" "Not supported in the current environment!"
    ([ "${STATE}" == "NOT IN" ] && [ "${ENV}" == "${APP_ENV}" ]) && throw_error "*" "Not supported in the current environment!"
}

function throw_error {
    case "${1}" in
        arg) [ -z "${2}" ] && MESSAGE="Unsupported argument!" || MESSAGE="Unsupported argument! (${2})";;
        *) [ -z "${2}" ] && MESSAGE="Unknown error!" || MESSAGE="${2}";;
    esac
    echo "${RED}Error${NC}: ${MESSAGE}"
    echo
    exit 1
}

# ==================================================
# Libraries
# ==================================================
source "${SCRIPT_DIR}/resources/sh/operation.sh"
source "${SCRIPT_DIR}/resources/sh/version.sh"
