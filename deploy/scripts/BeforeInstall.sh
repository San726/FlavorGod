#!/bin/bash

. $(dirname $0)/common_functions.sh

msg "Event: $LIFECYCLE_EVENT"

## Create required directories
    START_TIME=`date +%s%N`
    msg " - Create required directories ($(timer)s)"
    for dir in $REQUIRED_DIRS
    do
        START_TIME=`date +%s%N`
        if [ ! -d $dir ]; then
            #mkdir $ROOT_DIR
            msg " -- Directory Created: $dir ($(timer)s)"
        else
            msg " -- Directory Already Exists: $dir ($(timer)s)"
        fi
    done

## Create required files
    START_TIME=`date +%s%N`
    msg " - Create required files ($(timer)s)"
    for file in $REQUIRED_FILES
    do
        START_TIME=`date +%s%N`
        if [ ! -f $file ]; then
            #mkdir $ROOT_DIR
            msg " -- File Created: $file ($(timer)s)"
        else
            msg " -- File Already Exists: $file ($(timer)s)"
        fi
    done
