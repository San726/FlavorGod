#!/bin/bash
# - CodeDeploy will actually run this from the previous version,
#    before updating appspec.yml or any files.
# - It also does not run when an ASG launches a new instance.
#
# It may be better not not use it in most cases.
#
. $(dirname $0)/common_functions.sh

# Start logging
    msg "\n\n-------------------------------- "
    msg "\nDeployment started: `date`"
    msg " - DEPLOYMENT_ID: $DEPLOYMENT_ID"
    msg " - APPLICATION_NAME: $APPLICATION_NAME"
    msg " - DEPLOYMENT_GROUP_NAME: $DEPLOYMENT_GROUP_NAME"
    msg " - ENV: $ENV"
    msg " - ENV_FILE_NAME: $ENV_FILE_NAME"
    msg " - whoami: `whoami`"
    msg " - pwd: `pwd`"
    msg "Event: $LIFECYCLE_EVENT"

## Deregister from ELB(s)
    START_TIME=`date +%s%N`
    function deregister_from_elb {
        debug_msg "Running AWS CLI with region: $(get_instance_region)"

        # get this instance's ID
        INSTANCE_ID=$(get_instance_id)
        if [ $? != 0 -o -z "$INSTANCE_ID" ]; then
            error_exit "Unable to get this instance's ID; cannot continue."
        fi

        # Get current time
        debug_msg "Started $(basename $0) at $(/bin/date "+%F %T")"
        start_sec=$(/bin/date +%s.%N)

        debug_msg "Checking if instance $INSTANCE_ID is part of an AutoScaling group"
        asg=$(autoscaling_group_name $INSTANCE_ID)
        if [ $? == 0 -a -n "$asg" ]; then
            debug_msg "Found AutoScaling group for instance $INSTANCE_ID: $asg"

            debug_msg "Checking that installed CLI version is at least at version required for AutoScaling Standby"
            check_cli_version
            if [ $? != 0 ]; then
                error_exit "CLI must be at least version ${MIN_CLI_X}.${MIN_CLI_Y}.${MIN_CLI_Z} to work with AutoScaling Standby"
            fi

            debug_msg "Attempting to put instance into Standby"
            autoscaling_enter_standby $INSTANCE_ID $asg
            if [ $? != 0 ]; then
                error_exit "Failed to move instance into standby"
            else
                debug_msg "Instance is in standby"
                # exit 0
                return
            fi
        fi

        debug_msg "Instance is not part of an ASG, continuing..."

        debug_msg "Checking that user set at least one load balancer"
        if test -z "$ELB_LIST"; then
            error_exit "Must have at least one load balancer to deregister from"
        fi

        # Loop through all LBs the user set, and attempt to deregister this instance from them.
        for elb in $ELB_LIST; do
            debug_msg "Checking validity of load balancer named '$elb'"
            validate_elb $INSTANCE_ID $elb
            if [ $? != 0 ]; then
                debug_msg "Error validating $elb; cannot continue with this LB"
                continue
            fi

            debug_msg "Deregistering $INSTANCE_ID from $elb"
            deregister_instance $INSTANCE_ID $elb

            if [ $? != 0 ]; then
                error_exit "Failed to deregister instance $INSTANCE_ID from ELB $elb"
            fi
        done

        # Wait for all Deregistrations to finish
        debug_msg "Waiting for instance to de-register from its load balancers"
        for elb in $ELB_LIST; do
            wait_for_state "elb" $INSTANCE_ID "OutOfService" $elb
            if [ $? != 0 ]; then
                error_exit "Failed waiting for $INSTANCE_ID to leave $elb"
            fi
        done

        debug_msg "Finished $(basename $0) at $(/bin/date "+%F %T")"

        end_sec=$(/bin/date +%s.%N)
        elapsed_seconds=$(echo "$end_sec - $start_sec" | /usr/bin/bc)

        debug_msg "Elapsed time: $elapsed_seconds"

    }
    if deregister_from_elb ; then
        msg " - Deregister from ELB(s) Successful ($(timer)s)"
    else
        error_exit " - Deregister from ELB(s) Failed ($(timer)s)"
    fi

## Put application into maintenance mode
    START_TIME=`date +%s%N`
    if [ -f "$CURRENT_DIR/artisan" ]
    then
        php $CURRENT_DIR/artisan down
        # sleep 10 # wait 10 seconds to let connections/workers drain?
        msg " - Artisan Down ($(timer)s)"
    else
        error_exit " - Artisan Down Failed ($(timer)s)"
    fi
