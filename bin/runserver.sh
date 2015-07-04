#!/bin/sh

PARENT=`dirname $0`/..

php --server localhost:8080 -t ${PARENT}/web/
