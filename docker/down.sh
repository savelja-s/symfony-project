#!/usr/bin/env bash
cd "`dirname \"$0\"`"
#Stop docker and remove containers
docker-compose down -v || exit