#!/bin/sh

git filter-branch --env-filter '

OLD_EMAIL="xiaolongnk@126.com"
OLD_NAME=("fox" "xiaolongou" "ouxiaolong" "xiaolongnk")
CORRECT_NAME="xiaolongnk"
CORRECT_EMAIL="xiaolongnk@126.com"


function containsElement () {
    local e
    for e in "${@:2}"; do [[ "$e" == "$1" ]] && return 0; done
        return 1
}


if [ "$GIT_COMMITTER_EMAIL" = "$OLD_EMAIL" ]
then
    export GIT_COMMITTER_NAME="$CORRECT_NAME"
    export GIT_COMMITTER_EMAIL="$CORRECT_EMAIL"
    export GIT_AUTHOR_NAME="$CORRECT_NAME"
    export GIT_AUTHOR_EMAIL="$CORRECT_EMAIL"
fi

if containsElement "$GIT_AUTHOR_NAME" "${OLD_NAME[@]}"
then
    export GIT_AUTHOR_NAME="$CORRECT_NAME"
    export GIT_AUTHOR_EMAIL="$CORRECT_EMAIL"
    export GIT_COMMITTER_NAME="$CORRECT_NAME"
    export GIT_COMMITTER_EMAIL="$CORRECT_EMAIL"
fi
' --tag-name-filter cat -- --branches --tags
