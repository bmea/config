# variables
prefix = /usr/local
exec_prefix = $(prefix)
bindir = $(exec_prefix)/bin
libdir = $(exec_prefix)/lib

INSTALL = install -D
INSTALL_PROGRAM = $(INSTALL)
INSTALL_DATA = $(INSTALL) -m 644

# vendor files
LIB_FILES = $(shell find lib -type f | sed 's/^lib\///')

# targets
all: lib

install:
	$(INSTALL_PROGRAM) bin/configurator.php $(DESTDIR)$(bindir)/configurator.php
	$(foreach f,$(LIB_FILES),$(INSTALL_DATA) lib/"$f" "$(DESTDIR)$(libdir)/$f";)

composer.phar:
	curl -s https://getcomposer.org/installer | php

composer.lock: composer.json | composer.phar
	rm -f composer.lock
	php composer.phar update

lib/configurator/vendor/autoload.php: composer.lock | composer.phar
	php composer.phar install

lib: lib/configurator/vendor/autoload.php

distclean:
	rm -fr lib

clean: distclean
	rm -f composer.phar
