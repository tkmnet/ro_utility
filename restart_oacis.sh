#!/bin/bash

cd `dirname $0`

function fixMongoDB() {
	#waiting for mongod boot
	until [ "$(mongo --eval 'printjson(db.serverStatus().ok)' | tail -1 | tr -d '\r')" == "1" ]
	do
		sleep 1
		echo "waiting for mongod boot..."
	done
	mongo --eval 'db.adminCommand( { setParameter: 1, failIndexKeyTooLong: false } )'
}


cd /home/oacis/oacis
bundle exec rake daemon:stop

fixMongoDB

bundle exec rake daemon:start

