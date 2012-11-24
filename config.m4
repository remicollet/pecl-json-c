dnl
dnl $Id$
dnl

PHP_ARG_ENABLE(json, whether to enable JavaScript Object Serialization support,
[  --disable-json          Disable JavaScript Object Serialization support], yes)

if test "$PHP_JSON" != "no"; then
  AC_DEFINE([HAVE_JSON], 1 ,[whether to enable JavaScript Object Serialization support])
  AC_HEADER_STDC

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
  PHP_INSTALL_HEADERS([ext/json], [php_json.h])
  PHP_SUBST(JSON_SHARED_LIBADD)
fi
