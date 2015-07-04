#!/bin/sh

PARENT=`dirname $0`/..

${PARENT}/vendor/bin/phpunit --configuration ${PARENT}/app/build/phpunit.xml "$@"
