<?php

// SQL language highlighter

// Delimiters
$delim = '[\s\;\:\.\,\+\*\/\=\<\>\(\)\[\]\{\}\|\~\!]';

// Keywords/functions list
$keywords = 'ABSOLUTE|ACTION|ADA|ADD|ALL|ALLOCATE|ALTER|AND|ANY|ARE|AS|ASC|ASSERTION|AT|AUTHORIZATION|BEGIN|BETWEEN|BIGINT|BIT|BIT_LENGTH|BOTH|BY|CASCADE|CASCADED|CASE|CAST|CATALOG|CHAR|CHAR_LENGTH|CHARACTER|CHARACTER_LENGTH|CHECK|CLOSE|COALESCE|COLLATE|COLLATION|COLUMN|COMMIT|CONNECT|CONNECTION|CONSTRAINT|CONSTRAINTS|CONTINUE|CORRESPONDING|CREATE|CROSS|CURRENT|CURRENT_DATE|CURRENT_TIME|CURRENT_TIMESTAMP|CURRENT_USER|CURSOR|DATE|DAY|DEALLOCATE|DEC|DECIMAL|DECLARE|DEFAULT|DEFERRABLE|DEFERRED|DELETE|DESC|DESCRIBE|DESCRIPTOR|DIAGNOSTICS|DISCONNECT|DISTINCT|DOMAIN|DOUBLE|DROP|ELSE|END|END-EXEC|ESCAPE|EXCEPT|EXCEPTION|EXEC|EXECUTE|EXISTS|EXTERNAL|EXTRACT|FALSE|FETCH|FIRST|FLOAT|FOR|FOREIGN|FORTRAN|FOUND|FROM|FULL|GET|GLOBAL|GO|GOTO|GRANT|GROUP|HAVING|HOUR|IDENTITY|IMMEDIATE|IN|INCLUDE|INDEX|INDICATOR|INITIALLY|INNER|INPUT|INSENSITIVE|INSERT|INT|INTEGER|INTERSECT|INTERVAL|INTO|IS|ISOLATION|JOIN|KEY|LANGUAGE|LAST|LEADING|LEFT|LEVEL|LIKE|LOCAL|LOOP|MATCH|MINUTE|MODULE|MONTH|NAMES|NATIONAL|NATURAL|NCHAR|NEXT|NO|NONE|NOT|NULL|NULLIF|NUMERIC|OCTET_LENGTH|OF|ON|ONLY|OPEN|OPTION|OR|ORDER|OUTER|OUTPUT|OVERLAPS|PAD|PARTIAL|PASCAL|POSITION|PRECISION|PREPARE|PRESERVE|PRIMARY|PRIOR|PRIVILEGES|PROCEDURE|PUBLIC|READ|REAL|REFERENCES|RELATIVE|RESTRICT|REVOKE|RIGHT|ROLLBACK|ROWS|SCHEMA|SCROLL|SECOND|SECTION|SELECT|SESSION|SESSION_USER|SET|SIZE|SMALLINT|SOME|SPACE|SQL|SQLCA|SQLSTATE|SQLWARNING|SUBSTRING|SYSTEM_USER|TABLE|TEMPORARY|THEN|TIME|TIMESTAMP|TIMEZONE_HOUR|TIMEZONE_MINUTE|TO|TRAILING|TRANSACTION|TRANSLATION|TRIM|TRUE|UNION|UNIQUE|UNKNOWN|UPDATE|USAGE|USING|VALUE|VALUES|VARCHAR|VARYING|VIEW|WHEN|WHENEVER|WHERE|WITH|WORK|WRITE|YEAR|ZONE|add|all|alter|and|any|as|asc|authorization|backup|begin|between|body|break|browse|bulk|by|cascade|case|check|checkpoint|close|clustered|coalesce|column|commit|committed|compute|confirm|constraint|contains|containstable|continue|controlrow|create|cross|current|current_date|current_time|current_timestamp|current_user|cursor|database|dbcc|deallocate|declare|default|delete|deny|desc|disk|distinct|distributed|double|drop|dummy|dynamic|else|encryption|end|errlvl|errorexit|escape|except|exec|exit|fast_forward|file|fillfactor|floppy|for|foreign|forward_only|freetext|freetexttable|from|full|function|goto|grant|group|having|holdlock|identity|identity_insert|identitycol|if|in|index|insensitive|insert|instead|intersect|into|is|isolation|join|key|keyset|kill|left|level|like|lineno|load|mirrorexit|national|nocheck|nonclustered|not|null|nullif|of|off|offsets|on|once|only|open|opendatasource|openquery|openrowset|optimistic|option|or|order|outer|over|package|percent|perm|permanent|pipe|plan|precision|prepare|primary|print|privileges|proc|procedure|processexit|public|raiserror|read|read_only|readtext|reconfigure|references|repeatable|replication|restore|restrict|return|returns|revoke|right|rollback|row|rowcount|rowguidecol|rule|save|schema|schemabinding|scroll_locks|select|serializable|session_user|set|setuser|shutdown|some|sql_variant|static|statistics|system_user|table|tape|temp|temporary|textsize|then|to|top|tran|transaction|trigger|truncate|tsequal|type_warning|uncommitted|union|unique|update|updatetext|use|values|varying|view|waitfor|when|where|while|with|work|writetext|xml|replace  |REVERSE  |AFTER|BEFORE|DO|GEN_ID|GENERATOR|PAGE_SIZE|PASSWORD|RETURNING_VALUES|SUSPEND|TERM|VARIABLE||CHAR|CHARINDEX|DIFFERENCE|IDENT_CURRENT|LEFT|LEN|LOWER|LTRIM|NCHAR|PATINDEX|PATINDEX|QUOTENAME|REPLICATE|RIGHT|RTRIM|SCOPE_IDENTITY|SOUNDEX|SPACE|STR|STUFF|SUBSTRING|TEXTPTR|TEXTVALID|UNICODE|UPPER|abs|acos|all|and|any|ascii|asin|atan|atn2|case|cast|ceiling|convert|cos|current_timestamp|current_user|cursor_status|datalenght|date|dateadd|datediff|datename|datepart|decode|degrees|exp|floor|getdate|identity|log|log10|object_id|object_name|objectproperty|odbc|openquery|openrowset|parsename|power|rand|readtext|sin|updatetext|writetext|AVG|CONVERT|COUNT|LOWER|MAX|MIN|SQLCODE|SQLERROR|SUM|TRANSLATE|UPPER|USER|dump|LIMIT';

$skipwords = '[0-9]*';

// Functions list
$functions = '\$[[:alnum:]]+';

// TAB -> 4 spaces
$text = preg_replace("#\t#s","    ", $text );

// lexeme extraction
$text = "\001".preg_replace("#($delim)+#s","\001$0\001", $text )."\001";

// html escape
$text = preg_replace("#&#s","&amp;", $text );
$text = preg_replace("#<#s","&lt;", $text );
$text = preg_replace("#>#s","&gt;", $text );
$text = preg_replace("#\n#s","\002", $text );    // newline
$text = preg_replace("#\s#s","&nbsp;", $text );  // spaces
$text = preg_replace("#\002#s","<br />\n", $text );    // newline

// Highlighting

// String constants
$text = preg_replace("#\".*?\"#s", '<span style="color:#006666">$0</span>', $text );

// Keywords & functions
$text = preg_replace("#\001($functions)\001#si", '<span style="color:#770055">$1</span>', $text );
$text = preg_replace("#\001($skipwords)\001#si", '<span style="color:green"><b>$1</b></span>', $text );
$text = preg_replace("#\001($keywords)\001#si" , '<span style="color:blue">$1</span>', $text );

// Comments
$text = preg_replace('#(\-\-.*)$#m', "<span style=\"color:#888888\"><em>$1</em></span>", $text );

// Remove lexeme delimiter
$text = preg_replace("#\001#s",'', $text );

echo "<!--no"."typo--><pre class=\"code\">".$text."</pre><!--/no"."typo-->";

?>