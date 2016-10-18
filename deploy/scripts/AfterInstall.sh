#!/bin/bash
# This tells bash that it should exit the script if any statement returns a non-true return value.
# set -e

. $(dirname $0)/common_functions.sh

msg "Event: $LIFECYCLE_EVENT"

cd $BUILD_DIR

## Copy current vendor directory to save time.
    START_TIME=`date +%s%N`
    function copy_vendor {
        if [ -d "$CURRENT_DIR/vendor" ]; then
            cp -rpf $CURRENT_DIR/vendor $BUILD_DIR/
        fi
    }
    if copy_vendor ; then
        msg " - Copy Current Vendor ($(timer)s)"
    else
        error_exit " - Copy Current Vendor Failed ($(timer)s)"
    fi

## Update Composer
    START_TIME=`date +%s%N`
    function composer_selfupdate {
        sudo composer self-update
    }
    if composer_selfupdate ; then
        msg " - Composer Self-Update ($(timer)s)"
    else
        error_exit " - Composer Self-Update Failed ($(timer)s)"
    fi

## Install Composer Packages
    START_TIME=`date +%s%N`
    function composer_install {
        composer install
    }
    if composer_install ; then
        msg " - Composer Install ($(timer)s)"
    else
        error_exit " - Composer Install Failed ($(timer)s)"
    fi

## Copy current node_modules directory to save time.
    START_TIME=`date +%s%N`
    function copy_node_modules {
        if [ -d "$CURRENT_DIR/node_modules" ]; then
            cp -rpf $CURRENT_DIR/node_modules $BUILD_DIR/
        fi
    }
    if copy_node_modules ; then
        msg " - Copy Current Node Modules ($(timer)s)"
    else
        error_exit " - Copy Current Node Modules Failed ($(timer)s)"
    fi

# Install NPM packages
    START_TIME=`date +%s%N`
    function npm_install {
        npm install

        npm rebuild node-sass
    }
    if npm_install ; then
        msg " - NPM Install ($(timer)s)"
    else
        error_exit " - NPM Install Failed ($(timer)s)"
    fi

# Build Front end assets
    START_TIME=`date +%s%N`
    function gulp_build {
        # Suppress gulp notifications.
        sed -i "/export DISABLE_NOTIFIER.*/d" ~/.bash_aliases
        echo "export DISABLE_NOTIFIER=true;" >> ~/.bash_aliases
        source ~/.bashrc
        # Run gulp
        gulp
    }
    if gulp_build ; then
        msg " - Gulp Build ($(timer)s)"
    else
        error_exit " - Gulp Build Failed ($(timer)s)"
    fi

## Symlink logs to shared dir.
    START_TIME=`date +%s%N`
    function symlink_logs {
        rm -Rf $BUILD_DIR/storage/logs
        ln -fsn $SHARED_LOGS_DIR $BUILD_DIR/storage/logs
    }
    if symlink_logs ; then
        msg " - Symlink Logs ($(timer)s)"
    else
        error_exit " - Symlink Logs Failed ($(timer)s)"
    fi

## copy .env files.
    START_TIME=`date +%s%N`
    function copy_env {
        rm $SHARED_ENV_DIR/.env
        aws s3 cp s3://flavorgod-storage/env/$ENV/.env $SHARED_ENV_DIR/
        ln -sf $SHARED_ENV_DIR/.env $BUILD_DIR/.env
    }
    if copy_env ; then
        msg " - Copy ENV file: $ENV/$ENV_FILE_NAME ($(timer)s)"
    else
        error_exit " - Copy ENV file Failed ($(timer)s)"
    fi

## Create release file
    START_TIME=`date +%s%N`
    function create_release_file {
        RELEASE_FILE=$BUILD_DIR/.release
        aws codepipeline get-pipeline-state --name=$ELB_LIST \
        | php -r 'echo json_decode(file_get_contents("php://stdin"))->stageStates[0]->actionStates[0]->currentRevision->revisionId;' \
        > $RELEASE_FILE
    }
    if create_release_file ; then
        msg " - Create Release File ($(timer)s)"
    else
        error_exit " - Create Release File Failed ($(timer)s)"
    fi

## Move build to revisions dir
    START_TIME=`date +%s%N`
    REVISION="$ROOT_DIR/revisions/$(date +%Y%m%d_%H%M%S)"
    function create_revision {
        mv $ROOT_DIR/build $REVISION
        mkdir $ROOT_DIR/build
    }
    if create_revision ; then
        msg " - Create Revision: $REVISION ($(timer)s)"
    else
        error_exit " - Create Revision Failed ($(timer)s)"
    fi

################################################
## START CODE THAT WOULD BREAK CURRENT
################################################

## SET environment
    # START_TIME=`date +%s%N`
    # function set_env {
    #     # PHP-FPM
    #         # sudo sed -i "/env\[APP_ENV\].*/d" /etc/php5/fpm/php-fpm.conf
    #         # echo "env[APP_ENV]=$ENV" | sudo tee -a /etc/php5/fpm/php-fpm.conf
    #     # PHP-CLI
    #         # sudo sed -i "/env\[APP_ENV\].*/d" /etc/php5/cli/php.ini
    #         # echo "env[APP_ENV]=$ENV" | sudo tee -a /etc/php5/cli/php.ini
    #     # ubuntu's bash aliases (helps artisan commands)
    #         # sed -i "/export APP_ENV.*/d" ~/.bash_aliases # remove if exists
    #         # echo "export APP_ENV=$ENV" >> ~/.bash_aliases # add to end.
    #     # This disables notifications from gulp (which throws errors), which are unnecessary in prod.
    #         sed -i "/export DISABLE_NOTIFIER.*/d" ~/.bash_aliases # remove if exists
    #         echo "export DISABLE_NOTIFIER=true;" >> ~/.bash_aliases # add to end.
    #     # Update session.
    #     source ~/.bashrc
    # }
    # if set_env ; then
    #     msg " - Set ENV: $ENV ($(timer)s)"
    # else
    #     error_exit " - Set ENV Failed ($(timer)s)"
    # fi

## SET NewRelic app name to match env.
    START_TIME=`date +%s%N`
    function set_newrelic_app_name {
        sudo sed -i "s/newrelic.appname = .*/newrelic.appname = \"$NEWRELIC_APPNAME\"/" $NEWRELIC_CONFIG_FILE
    }
    if set_newrelic_app_name ; then
        msg " - Set NewRelic appname: $NEWRELIC_APPNAME ($(timer)s)"
    else
        error_exit " - Set NewRelic appname Failed ($(timer)s)"
    fi

## Update current site symlink
    START_TIME=`date +%s%N`
    function symlink_current {
        ln -fsn $REVISION $ROOT_DIR/current
    }
    if symlink_current ; then
        msg " - Update Current Symlink to: $REVISION ($(timer)s)"
    else
        error_exit " - Update Current Symlink Failed ($(timer)s)"
    fi

## Remove all app-specific cronjob if they exist
    START_TIME=`date +%s%N`
    msg " - Remove old cronjobs ($(timer)s)"
    for f in $SYS_CRON_DIR/app_*
    do
        START_TIME=`date +%s%N`
        F_BASE=$(basename $f)
        if [ -f "$SYS_CRON_DIR/$F_BASE" ]; then
            rm -f "$SYS_CRON_DIR/$F_BASE"
            msg " -- Cron Removed: $F_BASE ($(timer)s)"
        else
            msg " -- Cron Not Found: $F_BASE ($(timer)s)"
        fi
    done

## Install common cronjobs
    START_TIME=`date +%s%N`
    msg " - Install common cronjobs ($(timer)s)"
    for f in `find $NEW_CRON_DIR -maxdepth 1 -type f -name '*'`
    do
        START_TIME=`date +%s%N`
        F_BASE=$(basename $f)
        sudo cp $f $SYS_CRON_DIR/app_$F_BASE
        if [ -f "$SYS_CRON_DIR/app_$F_BASE" ]; then
            msg " -- Cron Installed: $F_BASE ($(timer)s)"
        else
            error_exit " -- Cron Not Installed: $F_BASE ($(timer)s)"
        fi
    done

## Install env-specific cronjobs
    START_TIME=`date +%s%N`
    msg " - Install env-specific cronjobs ($(timer)s)"
    for f in `find $NEW_CRON_DIR/$ENV -maxdepth 1 -type f -name '*'`
    do
        START_TIME=`date +%s%N`
        F_BASE=$(basename $f)
        sudo cp $f $SYS_CRON_DIR/app_$F_BASE
        if [ -f "$SYS_CRON_DIR/app_$F_BASE" ]; then
            msg " -- Cron Installed: $F_BASE ($(timer)s)"
        else
            error_exit " -- Cron Not Installed: $F_BASE ($(timer)s)"
        fi
    done

## Update papertrail logging
    START_TIME=`date +%s%N`
    function update_papertrail_config {
        count=0

        sudo cp -pf $NEW_PAPERTRAIL_DIR/$ENV/$NEW_PAPERTRAIL_FILE $SYS_PAPERTRAIL_FILE
        # sudo service remote_syslog restart
        sudo service remote_syslog stop
        sudo service remote_syslog start
        # wait for it to come back up
        sleep 2
        # threshold is 2 because grep itself will show up
        while [[ $(ps -ef | grep "remote_syslog -c" | wc -l) < 2 ]]; do
            if [ $count -ge $WAITER_ATTEMPTS ]; then
                # timed out
                # return 1
                return 0 # succeed anyway for now.
            fi
            sleep $WAITER_INTERVAL
            count=$(($count + 1))
        done

        return 0
    }
    if update_papertrail_config ; then
        msg " - Update Papertrail Config ($(timer)s)"
    else
        error_exit " - Update Papertrail Config Failed ($(timer)s)"
    fi

## Update supervisor'd scripts
    START_TIME=`date +%s%N`
    msg " - Update Supervisor Config:"
    function update_supervisor_config {
        # Stop supervisor processes
        sudo supervisorctl stop all
        # Update files
        sudo rm -rfv $SYS_SUPERVISOR_DIR/*
        if [ ! -d $NEW_SUPERVISOR_DIR/$ENV ]; then
            msg " -- No files found in: $NEW_SUPERVISOR_DIR/$ENV ($(timer)s)"
        else
            for f in `find $NEW_SUPERVISOR_DIR/$ENV -maxdepth 1 -type f -name '*'`
            do
                START_TIME=`date +%s%N`
                F_BASE=$(basename $f)
                sudo cp $f $SYS_SUPERVISOR_DIR/$F_BASE
                if [ -f "$SYS_SUPERVISOR_DIR/$F_BASE" ]; then
                    msg " -- Copied: $F_BASE ($(timer)s)"
                else
                    error_exit " -- Not Copied: $F_BASE ($(timer)s)"
                fi
            done
            START_TIME=`date +%s%N`
            # reload config (processes should be set to autostart)
            if sudo supervisorctl reload; then
                msg " -- Reload Supervisor ($(timer)s)"
            else
                error_exit " -- Reload Supervisor Failed ($(timer)s)"
            fi
        fi
    }
    if update_supervisor_config ; then
        echo # do nothing
    else
        error_exit " - Update Supervisor Config Failed ($(timer)s)"
    fi

## Restart all PHP-FPM processes
    START_TIME=`date +%s%N`
    function restart_php {
        sudo service php5-fpm restart
    }
    if restart_php ; then
        msg " - Restart php5-fpm ($(timer)s)"
    else
        error_exit " - Restart php5-fpm Failed ($(timer)s)"
    fi
