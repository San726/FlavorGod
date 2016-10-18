#!/bin/bash

. $(dirname $0)/common_functions.sh

msg "Event: $LIFECYCLE_EVENT"

## Check that the index responds with 200
    START_TIME=`date +%s%N`
    REMOTE_IP=$(curl --silent https://api.ipify.org)
    RESULT=$(curl -s -o /dev/null -w "%{http_code}" $REMOTE_IP)
    if [ $RESULT == 200 ]; then
        msg " - Check $REMOTE_IP: $RESULT ($(timer)s)"
    else
        error_exit " - Check $REMOTE_IP Failed ($RESULT) ($(timer)s)"
    fi

# ## Check for other services?
# ## Cron jobs
# ## Supervisor scripts
# ## Check environment.

################################################
## START CLEAN UP
################################################

## Delete all but the most recent 3 revisions.
    START_TIME=`date +%s%N`
    function cleanup_revisions {
        ls -t -d -1 $ROOT_DIR/revisions/* | tail -n +4 | sudo xargs rm -Rf
    }
    if cleanup_revisions ; then
        msg " - Cleanup Revisions ($(timer)s)"
    else
        error_exit " - Cleanup Revisions Failed ($(timer)s)"
    fi


################################################
## START Register with ELB (go live!)
################################################

    START_TIME=`date +%s%N`
    function register_with_elb {

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

            debug_msg "Attempting to move instance out of Standby"
            autoscaling_exit_standby $INSTANCE_ID $asg
            if [ $? != 0 ]; then
                error_exit "Failed to move instance out of standby"
            else
                debug_msg "Instance is no longer in Standby"
                # exit 0
                return
            fi
        fi

        debug_msg "Instance is not part of an ASG, continuing..."

        debug_msg "Checking that user set at least one load balancer"
        if test -z "$ELB_LIST"; then
            error_exit "Must have at least one load balancer to deregister from"
        fi

        # Loop through all LBs the user set, and attempt to register this instance to them.
        for elb in $ELB_LIST; do
            debug_msg "Checking validity of load balancer named '$elb'"
            validate_elb $INSTANCE_ID $elb
            if [ $? != 0 ]; then
                debug_msg "Error validating $elb; cannot continue with this LB"
                continue
            fi

            debug_msg "Registering $INSTANCE_ID to $elb"
            register_instance $INSTANCE_ID $elb

            if [ $? != 0 ]; then
                error_exit "Failed to register instance $INSTANCE_ID from ELB $elb"
            fi
        done

        # Wait for all Registrations to finish
        debug_msg "Waiting for instance to register to its load balancers"
        for elb in $ELB_LIST; do
            wait_for_state "elb" $INSTANCE_ID "InService" $elb
            if [ $? != 0 ]; then
                error_exit "Failed waiting for $INSTANCE_ID to return to $elb"
            fi
        done

        debug_msg "Finished $(basename $0) at $(/bin/date "+%F %T")"

        end_sec=$(/bin/date +%s.%N)
        elapsed_seconds=$(echo "$end_sec - $start_sec" | /usr/bin/bc)

        debug_msg "Elapsed time: $elapsed_seconds"

    }
    if register_with_elb ; then
        msg " - Register with ELB(s) ($(timer)s)"
    else
        error_exit " - Register with ELB(s) Failed ($(timer)s)"
    fi


msg "Deployment Successful: `date`"
exit 0
