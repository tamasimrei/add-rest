#!/bin/bash

PARENT=`dirname $0`/..

cd $PARENT

# stop on any errors
set -e

echo Running unit tests
XDEBUG_MODE=coverage bin/phpunit --configuration app/build/phpunit.xml

bin/phpcs -v

echo ''

echo Running PHP Mess Detector
bin/phpmd src/ text codesize,controversial,design,naming,unusedcode

echo ''

echo Running PHP Copy-Paste Detector
bin/phpcpd \
  --exclude vendor \
  --exclude build \
  --log-pmd=./app/build/phpcpd/results.xml \
  --min-lines=5 \
  --min-tokens=50 \
    src

echo ''

echo Running PDepend
bin/pdepend \
  --summary-xml=./app/build/pdepend/summary.xml \
  --jdepend-chart=./app/build/pdepend/jdepend.svg \
  --jdepend-xml=./app/build/pdepend/jdepend.xml \
  --overview-pyramid=./app/build/pdepend/pyramid.svg \
  --ignore=Tests \
  src

echo ''

echo Compiling code metrics
bin/phploc\
  --exclude vendor --exclude ./app/build\
  --count-tests\
  --log-xml ./app/build/phploc/result.xml\
  .

echo ''
echo Source QA done.
