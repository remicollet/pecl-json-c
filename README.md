pecl-json-c
===========

[![Build Status](https://travis-ci.org/remicollet/pecl-json-c.svg?branch=master)](https://travis-ci.org/remicollet/pecl-json-c)


JSON-C wrapper

This is the sources repository for http://pecl.php.net/package/jsonc

This extension  was created to be a drop-in alternative to the standard
**PHP 5** json extension, because of the licensing concerns over the JSON parser
code used as part of the standard PHP json extension.
See [PHP bug #63520](https://bugs.php.net/63520)

As **PHP 7** have a new ext/json extension, which is free,
this extension will not be made comptible, and won't be
available for PHP 7.

json_encode is the same than current PHP one.

json_decode use the json-c library and is mostly compatible.

A new option JSON_PARSER_NOTSTRICT allow to reduce parser strictness
- integer could start with zero
- string can be single or double-quoted
- comments are allowed in json string/files (Using /* */ or // until end of line)
- ignore trailing char after data
- no check for invalid UTF-8 characters

Also provide a new incremental parser object:

	$parser = new JsonIncrementalParser();
	$fic = fopen("somefile.json", "r");
	do {
		$buf = fgets($fic);
		$ret = $parser->parse($buf);
	} while ($buf && ($ret==JsonIncrementalParser::JSON_PARSER_CONTINUE));
	$result = $parser->get();

or, even simpler:

	$ret = $parser->parseFile("somefile.json");
	$result = $parser->get();

Debian DEB available, since Jessie for PHP 5.5
- http://packages.debian.org/jessie/php5-json

Fedora RPM are available in official repo, since Fedora 19
- https://apps.fedoraproject.org/packages/php-pecl-jsonc

Ubuntu DEB available, since Saucy for PHP 5.5
- http://packages.ubuntu.com/saucy/php5-json

Fedora RPM are available in remi repo
- http://blog.famillecollet.com/post/2013/06/04/php-pecl-json-1.3.0-en

Windows build are available
- http://windows.php.net/downloads/pecl/releases/jsonc/
- http://windows.php.net/downloads/pecl/deps/

Merged PR in upstream json-c library (release pending)
- number must not have leading zeroes
  https://github.com/json-c/json-c/pull/90
- string must be double-quoted
- no comment in strict mode
- no trailing char after data
  https://github.com/json-c/json-c/pull/94

Pending PR in upstream json-c library
- none

> The world will not be destroyed by those who do evil,
> but by those who watch them without doing anything.
> -- Albert Einstein
