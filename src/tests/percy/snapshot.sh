# # first verify that at least 1 and at most 2 arguments are passed to the script
# if [ $# -lt 1 ] || [ $# -gt 2 ]; then
#     echo "Usage: $0 <environment1> [environment2]"
#     echo "If single reference environment is provided, it will be updated."
#     echo "If two environments are provided, the first will be visually compared to the second."
#     exit 1
# fi

# # now verify that both arguments are either local, dev, stg, or prd
# if [ $1 != "local" ] && [ $1 != "dev" ] && [ $1 != "stg" ] && [ $1 != "prd" ]; then
#     echo "The first argument must be either local, dev, stg, or prd"
#     exit 1
# fi

# # if a second argument was passed, verify that it is either local, dev, stg, or prd
# if [ $# -eq 2 ]; then
#     if [ $2 != "dev" ] && [ $2 != "stg" ] && [ $2 != "prd" ]; then
#         echo "The second argument must be either dev, stg, or prd"
#         exit 1
#     fi
# fi

# # now that we have verified that the arguments are correct, we can proceed with the rest of the script
# # don't store client error logs at Browserstack:
# export PERCY_CLIENT_ERROR_LOGS=false

# # if only 1 argument was passed, simply update the reference environment
# if [ $# -eq 1 ]; then
#     echo -e "\033[1;32mUpdating reference environment $1\033[0m"
#     PERCY_BRANCH=$1 percy exec -- node percy.js
# fi

# # if 2 arguments were passed, visually diff the two environments
# if [ $# -eq 2 ]; then
#     echo -e "\033[1;32mComparing $1 to reference environment $2\033[0m"
#     PERCY_BRANCH=$1 PERCY_TARGET_BRANCH=$2 percy exec -- node percy.js
# fi
PERCY_BRANCH=local PERCY_TARGET_BRANCH=prd percy exec -- node percy.js