HH_CLIENT=/usr/local/bin/hh_client

check:check-web check-src

check-web:
	$(HH_CLIENT) restart web
	$(HH_CLIENT) check web
check-src:
	$(HH_CLIENT) restart src
	$(HH_CLIENT) check src
