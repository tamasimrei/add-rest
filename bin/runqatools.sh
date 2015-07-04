#!/bin/bash

PARENT=`dirname $0`/..

# stop on any errors
set -e

echo Running unit tests
${PARENT}/vendor/bin/phpunit -c ${PARENT}/app/build/phpunit.xml

${PARENT}/vendor/bin/phpcs -v\
  --standard=PSR1,PSR2\
  --error-severity=1\
  --warning-severity=0\
  --report=full\
  --report-file=${PARENT}/app/build/phpcs/report.txt\
  --report-width=120\
  src

echo ''

echo Running PHP Mess Detector
${PARENT}/vendor/bin/phpmd\
  src/ text\
  codesize,controversial,design,naming,unusedcode

echo ''

echo Running PHP Copy-Paste Detector
${PARENT}/vendor/bin/phpcpd\
  --exclude vendor\
  --exclude build\
  --log-pmd=${PARENT}/app/build/phpcpd/results.xml\
  --min-lines=5\
  --min-tokens=50\
  --no-ansi\
  --no-interaction\
  src

echo ''

echo Running PDepend
${PARENT}/vendor/bin/pdepend\
  --summary-xml=${PARENT}/app/build/pdepend/summary.xml\
  --jdepend-chart=${PARENT}/app/build/pdepend/jdepend.svg\
  --jdepend-xml=${PARENT}/app/build/pdepend/jdepend.xml\
  --overview-pyramid=${PARENT}/app/build/pdepend/pyramid.svg\
  --ignore=AddRest/Tests src

echo ''

echo Compiling code metrics
${PARENT}/vendor/bin/phploc\
  --exclude vendor --exclude ${PARENT}/build\
  --count-tests\
  --log-xml ${PARENT}/app/build/phploc/result.xml\
  .

echo ''
echo Source QA done.
