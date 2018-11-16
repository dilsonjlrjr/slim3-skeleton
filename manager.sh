#!/bin/sh

PARAM_OPTION=$1
PARAM_CONTAINER=$2
SERVICE_WEBSERVER="webserver"


defineNameMachine()
{
    dirname=`pwd`
    result="${dirname%"${dirname##*[!/]}"}" # extglob-free multi-trailing-/ trim
    NAME_MACHINE=${result##*/}                    # remove everything before the last /

    echo $NAME_MACHINE"_"$SERVICE_WEBSERVER"_1"
}

buildContainer()
{
    defineNameMachine
    #docker-compose -f docker-compose-webserver.yml up --build -d 
    #docker exec -it slim3-skeleton_webserver_1 /composer-exec.sh    
}

if [ -z $PARAM_OPTION ];
then
    echo "manager: I need the name of the COMMAND.\n \
          Usage: sh manager.sh <COMMAND>\n \
          Command available:\n \
          \t- build-container \n \
          \t- stop-container \n \
          \t- test-unit \n\n\
          Example: sh manager.sh build-container\n"

    exit
fi

case $PARAM_OPTION in
    "build-container") 
        buildContainer
    ;;
    "test-unit") 
        echo 2 or 3
    ;;
    "stop-container") 
        echo default
    ;;
    *)
        echo "manager: Command not exist.\n \
          Usage: sh manager.sh <COMMAND>\n \
          Command available:\n \
          \t- build-container \n \
          \t- stop-container \n \
          \t- test-unit \n\n\
          Example: sh manager.sh build-container\n"
        exit
esac