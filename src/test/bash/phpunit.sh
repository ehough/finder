#!/bin/bash

cd $TRAVIS_BUILD_DIR

OUTPUT="$(phpunit -c src/test/resources/phpunit.xml.dist)"

echo "$OUTPUT"

`echo "$OUTPUT" | grep -q "FAILURE"`

if [ $? -eq 1 ]
then

    exit 0

else

    exit 1

fi