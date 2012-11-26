dnl
dnl $Id$
dnl

PHP_ARG_ENABLE(json, whether to enable JavaScript Object Serialization support,
[  --disable-json          Disable JavaScript Object Serialization support], yes)

PHP_ARG_WITH(libjson, libjson,
[  --with-libjson          JSON: use system json-c], no, no)

if test "$PHP_JSON" != "no"; then
  AC_DEFINE([HAVE_JSON], 1 ,[whether to enable JavaScript Object Serialization support])
  AC_HEADER_STDC

  if test "$PHP_LIBJSON" != "no"; then
	  AC_PATH_PROG(PKG_CONFIG, pkg-config, no)
	  AC_MSG_CHECKING(JSON-C version)
	  if test -x "$PKG_CONFIG" && $PKG_CONFIG --exists json; then
		LIBJSON_INCDIR=`$PKG_CONFIG json --variable includedir`
		LIBJSON_LIBDIR=`$PKG_CONFIG json --variable libdir`
		LIBJSON_VERSION=`$PKG_CONFIG json --modversion`
	  fi
	  if test -z "$LIBJSON_VERSION"; then
		  AC_MSG_RESULT(not found)
		  AC_MSG_ERROR(Please reinstall json-c.)
	  else
		  AC_MSG_RESULT($LIBJSON_VERSION)
	  fi

		PHP_CHECK_LIBRARY(json, json_object_iter_end,
		[
		  AC_DEFINE([HAVE_JSON], 1 ,[whether to enable JavaScript Object Serialization support])
		],[
		  AC_MSG_ERROR([Sorry, Incompatible json-c version, requires >= 0.10 with json_object_iterator.])
		],[
		  -L$LIBJSON_LIBDIR
		])
	  AC_DEFINE_UNQUOTED(LIBJSON_VERSION, "$LIBJSON_VERSION", [ ])

	  PHP_ADD_LIBRARY_WITH_PATH(json, $LIBJSON_LIBDIR, JSON_SHARED_LIBADD)
	  PHP_ADD_INCLUDE($LIBJSON_INCDIR)
	  
	  PHP_NEW_EXTENSION(json, json.c, $ext_shared)
  else
      AC_CHECK_HEADERS(fcntl.h limits.h strings.h syslog.h unistd.h [sys/param.h] stdarg.h inttypes.h)
      AC_CHECK_FUNCS(strndup strerror vsnprintf vasprintf open vsyslog strncasecmp)

	  PHP_LIBJSON_SOURCES="json-c/arraylist.c \
	                       json-c/debug.c \
	                       json-c/json_object.c \
	  					   json-c/json_object_iterator.c \
	  					   json-c/json_tokener.c \
	  					   json-c/json_util.c \
	  					   json-c/linkhash.c \
	  					   json-c/printbuf.c"
	  PHP_NEW_EXTENSION(json, json.c $PHP_LIBJSON_SOURCES, $ext_shared)
  fi
  
  PHP_INSTALL_HEADERS([ext/json], [php_json.h])
  PHP_SUBST(JSON_SHARED_LIBADD)
fi
