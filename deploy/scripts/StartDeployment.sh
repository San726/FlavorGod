#!/bin/bash
# CodeDeploy will actually run this from the previous version,
# before updating appspec.yml or any files.
# It may be better not not use it in most cases.
#
. $(dirname $0)/common_functions.sh

# Start logging
echo -e "\n\n-------------------------------- " | tee -a $LOG_FILE
echo -e "\nDeployment started: " `date` | tee -a $LOG_FILE
echo "Event: $LIFECYCLE_EVENT" | tee -a $LOG_FILE
echo " - DEPLOYMENT_ID: $DEPLOYMENT_ID" | tee -a $LOG_FILE
echo " - APPLICATION_NAME: $APPLICATION_NAME" | tee -a $LOG_FILE
echo " - DEPLOYMENT_GROUP_NAME: $DEPLOYMENT_GROUP_NAME" | tee -a $LOG_FILE
echo " - ENV: $ENV" | tee -a $LOG_FILE
echo " - ENV_FILE_NAME: $ENV_FILE_NAME" | tee -a $LOG_FILE
echo " - whoami: `whoami`" | tee -a $LOG_FILE
echo " - pwd: `pwd`" | tee -a $LOG_FILE
