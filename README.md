# Obsolete
This project is obsolete. Current coding style and wisdom don't use registries or singletons that are defined here. Other features will be moved to other projects.

## PHP Utilities

PHP utilities tested with PHP version 5.4–5.6, 7.1.

*Stack* is an implemention of *ArrayAccess* with object access with **LIFO**, Last-In-First-Out behavior.

*Registry* is a singleton extending *Stack* with behavior similar to Zend_Registry.

*DateTime* and *Date* add convenience methods to the built-in PHP *DateTime* class. This includes the __toString method that returns a date-time string formatted for the default MySQL date-time format, and also adds handling of DateTime for MongoDB.

*Sprintf* adds format specifiers useful for creating MySQL statements.

*Singleton* uses *Registry* to store the "singleton" instances so this can be an abstract parent class.

*Curl* wraps the PHP curl functions.

### Composer
```
> composer require diskerror/utilities
```
