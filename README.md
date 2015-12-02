# PHP Utilities

PHP utilities tested with PHP version 5.4.

*Registry* is a singleton implementing *ArrayAccess* and object access with **LIFO**, Last-In-First-Out behavior.

*DateTime* and *Date* add convenience methods to the built-in PHP *DateTime* class. This includes the __toString method that returns a date-time string formatted for the default MySQL date-time format.

*Sprintf* adds format specifiers useful for creating MySQL statements.

*Singleton* uses *Registry* to store the "singleton" instances so this can be an abstract parent class.

*Curl* wraps the PHP curl functions.

##Composer
```
> composer require diskerror/utilities
```
