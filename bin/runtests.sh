#!/bin/sh

PARENT=`dirname $0`/..

${PARENT}/bin/phpunit --configuration ${PARENT}/app/build/phpunit.xml "$@"
