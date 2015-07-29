dnl
dnl $Id$
dnl

PHP_ARG_ENABLE(json, whether to enable JavaScript Object Serialization support,
[  --disable-json          Disable JavaScript Object Serialization support (json.so)], yes)

PHP_ARG_WITH(jsonc, whether to rename module file to jsonc,
[  --with-jsonc            JSON: rename module file to jsonc.so], no, no)

PHP_ARG_WITH(libjson, libjson,
[  --with-libjson          JSON: use system json-c], no, no)

PHP_ARG_ENABLE(rdrand, whether to enable RDRAND Hardware RNG Hash Seed generation on supported x86/x64 platforms,
[  --disable-rdrand        Disable RDRAND Hardware RNG Hash Seed generation on supported x86/x64 platforms], yes, no)

if test "$PHP_JSON" != "no"; then
	AC_GNU_SOURCE
	AC_DEFINE([HAVE_JSON], 1 ,[whether to enable JavaScript Object Serialization support])
	AC_HEADER_STDC

	if test "$PHP_LIBJSON" != "no"; then
		AC_MSG_ERROR(Build with system libjson-c is no more supported)

		AC_PATH_PROG(PKG_CONFIG, pkg-config, no)
		AC_MSG_CHECKING(JSON-C version)
		if test -x "$PKG_CONFIG" && $PKG_CONFIG --exists json-c; then
			LIBJSON_INCLUDE=`$PKG_CONFIG json-c --cflags`
			LIBJSON_LIBRARY=`$PKG_CONFIG json-c --libs`
			LIBJSON_VERSION=`$PKG_CONFIG json-c --modversion`
		fi

		if test -z "$LIBJSON_VERSION"; then
			AC_MSG_RESULT(version not found)
			AC_MSG_ERROR(Please reinstall json-c version >= 0.11)
		else
			AC_MSG_RESULT(version=$LIBJSON_VERSION include=$LIBJSON_INCLUDE library=$LIBJSON_LIBRARY)
		fi

		PHP_CHECK_LIBRARY(json-c, json_tokener_new_ex,
		[
			AC_DEFINE_UNQUOTED(HAVE_LIBJSON, 1, [use system libjson-c])
		],[
			AC_MSG_ERROR([Sorry, Incompatible json-c library, requires version >= 0.11])
		],[
			$LIBJSON_LIBRARY
		])

		PHP_EVAL_INCLINE($LIBJSON_INCLUDE)
		PHP_EVAL_LIBLINE($LIBJSON_LIBRARY, JSONC_SHARED_LIBADD)
		PHP_EVAL_LIBLINE($LIBJSON_LIBRARY, JSON_SHARED_LIBADD)
	else
		AC_MSG_CHECKING([for working sscanf])
		AC_TRY_RUN([
#include <stdio.h>
#include <stdint.h>
#include <errno.h>
int main(int argc, char *argv[]){
long i;
errno=0;
return (sscanf("1234567890123456789012345","%ld",&i)==1 && errno==ERANGE && i==INT64_MAX ? 0 : 1);
		}],[
			AC_MSG_RESULT([yes])
			AC_DEFINE(HAS_SSCANF_ERANGE, 1, [Whether correctly return ERANGE])
		],[
			AC_MSG_RESULT([no, not working])
		],[
			AC_MSG_RESULT([no, not found])
		])
		AC_CHECK_HEADERS(fcntl.h limits.h strings.h syslog.h unistd.h [sys/param.h] stdarg.h inttypes.h locale.h endian.h)
		AC_CHECK_FUNCS(strcasecmp strdup strndup strerror snprintf vsnprintf vasprintf open vsyslog strncasecmp setlocale)

		PHP_LIBJSON_SOURCES="json-c/arraylist.c \
							json-c/debug.c \
							json-c/json_c_version.c \
							json-c/json_object.c \
							json-c/json_object_iterator.c \
							json-c/json_tokener.c \
							json-c/json_util.c \
							json-c/linkhash.c \
							json-c/random_seed.c \
							json-c/printbuf.c"
	fi

	if test "$PHP_RDRAND" != "no"; then
		AC_DEFINE(ENABLE_RDRAND, 1, [Enable RDRANR Hardware RNG Hash Seed])
	fi

	AC_MSG_CHECKING(JSON extension name:)
	if test "$PHP_JSONC" != "no"; then
		AC_MSG_RESULT(jsonc)
		PHP_NEW_EXTENSION(jsonc, json.c $PHP_LIBJSON_SOURCES, $ext_shared)
		PHP_SUBST(JSONC_SHARED_LIBADD)
	else
		AC_MSG_RESULT(json)
		PHP_NEW_EXTENSION(json, json.c $PHP_LIBJSON_SOURCES, $ext_shared)
		PHP_SUBST(JSON_SHARED_LIBADD)
	fi

	PHP_INSTALL_HEADERS([ext/json], [php_json.h])
fi
