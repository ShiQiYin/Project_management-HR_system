PROTECTED="development\|test\|master"

function app_version {
    NEW_VERSION="${1}"
    [ -z "${NEW_VERSION}" ] \
        && print_header "The current application version is ${GREEN}${APP_VERSION}${NC}" \
        && exit 0
    # Update version number
    assert_env "IN" "local"
    print_header "(1/2) Update the version number from ${GREEN}${APP_VERSION}${NC} to ${GREEN}${NEW_VERSION}${NC}"
    sed -i "s/APP_VERSION=.*/APP_VERSION=${NEW_VERSION}/g" "${APP_DIR}/.env"
    echo "OK"
    # Create a new tag
    print_header "(2/2) Create the ${GREEN}${NEW_VERSION}${NC} tag in Git"
    git tag "${NEW_VERSION}"
    echo "OK"
    echo
    exit 0
}

function app_branch {
    [ -z "${1}" ] && read -p "Branch Name: " NEW || NEW="${1}"
    [ -z "${NEW}" ] && throw_error "*" "Branch name cannot be empty!"
    # Get the current branch name
    CURRENT=$(git branch --show-current)
    # Check if the new branch exists
    print_header "(1/2) Switch to the ${GREEN}${NEW}${NC} branch"
    [ -z "$(git branch --list "${NEW}")" ] && git branch "${NEW}"
    git checkout "${NEW}"
    # Perform git pull (for protected branches only)
    [ ! -z $(echo "${NEW}" | grep "${PROTECTED}") ] \
        && print_header "(2/2) Pull changes from the remote repository" \
        && git pull
    # Remove the old branch (for non-protected branches only)
    ([ "${CURRENT}" != "${NEW}" ] && [ -z $(echo "${CURRENT}" | grep "${PROTECTED}") ]) \
        && print_header "(2/2) Wrap up" \
        && read -p "Do you want to remove the ${RED}${CURRENT}${NC} branch ([Y]/n): " DECISION \
        && [ "${DECISION}" == "Y" ] | [ -z "${DECISION}" ] && git branch -D "${CURRENT}"
    echo
    exit 0
}