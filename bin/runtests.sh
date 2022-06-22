#!/bin/sh

PARENT=`dirname $0`/..

${PARENT}/bin/phpspec run

${PARENT}/bin/phpunit --configuration ${PARENT}/app/build/phpunit.xml "$@"
