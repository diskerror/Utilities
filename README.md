# PHP Utilities

PHP utilities accessible by Composer. Tested with PHP version 5.4.

*cli.php* is a command line entry point for a Zend Framework 1 application with parallel ZF2 access. Handling of parameters has not been tested nor designed with any intent. Suggestions are welcome. It is based on a script found here: http://webdevbyjoss.blogspot.com/2010/09/running-zend-framework-application-from.html.

*Registry* is a singleton implementing *ArrayAccess* and object access with **LIFO**, Last-In-First-Out behavior.

*DateTime* and *Date* add convenience methods to the built-in PHP *DateTime* class.

*Coding Style* updated with https://github.com/FriendsOfPHP/PHP-CS-Fixer.
````
> php-cs-fixer fix --level=symfony --fixers=-parenthesis,-concat_without_spaces,-extra_empty_lines,-function_call_space,-indentation,-multiline_array_trailing_comma,-phpdoc_separation,multiline_spaces_before_semicolon,newline_after_open_tag,phpdoc_var_to_type <<file>>
````
"php-cs-fixer" leaves a combination of spaces and tabs which I change to tabs, and also this substitution is also made:
````
s/^(\s*)\}\s*else/\1\}\n\1else/g
````
