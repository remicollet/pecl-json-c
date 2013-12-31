pecl-json-c
===========

JSON-C wrapper

This is the sources repository for http://pecl.php.net/package/jsonc

Should be a drop-in alternative to PHP json extension.

json_encode is the same than current PHP one.

json_decode use the json-c library and is mostly compatible.
- > 64 bits integer are always parsed as integer (never float or string)
- 33 to 64 bits bits integer are parsed as float (or string) on 32 bits build

A new option JSON_PARSER_NOTSTRICT allow to reduce parser strictness
- integer could start with zero
- string can be single or double-quoted
- comments are allowed in json string/files (Using /* */ or // until end of line)
- ignore trailing char after data

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

Debian DEB available in Jessie for PHP 5.5
- http://packages.debian.org/jessie/php5-json

Fedora 19 RPM are available in official repo
- https://apps.fedoraproject.org/packages/php-pecl-jsonc

Ubuntu DEB available in Saucy for PHP 5.5
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
