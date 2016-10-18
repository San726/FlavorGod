#!/bin/bash

. $(dirname $0)/common_functions.sh

msg "Event: $LIFECYCLE_EVENT"

## Clear App Cache
# php artisan cache:clear
    START_TIME=`date +%s%N`
    function clear_app_cache {
        php $CURRENT_DIR/artisan cache:clear --env=$ENV
    }
    if clear_app_cache ; then
        msg " - Clear App Cache ($(timer)s)"
    else
        error_exit " - Clear App Cache Failed ($(timer)s)"
    fi

# Take application out of maintenance mode
    START_TIME=`date +%s%N`
    if [ -f "$CURRENT_DIR/artisan" ]
    then
        # file found."
        php $CURRENT_DIR/artisan up
        # sleep 10 # wait 10 seconds to let ELB pass health check?
        msg " - Artisan Up ($(timer)s)"
    else
        error_exit " - Artisan Up Failed ($(timer)s)"
    fi
