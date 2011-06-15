
## What It Is

This library of classes offers basic utilities for other Lewis & Clark LiveWhale application modules.

## Installation

The easiest way to install this software is to use git to clone it into your livewhale/client folder as follows:

    $ cd /path/to/your/livewhale/client
    $ git clone git://github.com/lewisandclark/utilities.git

Git will then copy the most current version of the code into a utilities folder within livewhale/clients.

If you don't have or are unable to use git, you can also download a zip or tarball from github (use the downloads button) and extract it manually into the livewhale/client folder as utilities. (Don't change the folder name, it will make it non-functional for other modules.)

## Classes

This software includes several basic utilities.

### HttpStatusCodes

The HttpStatusCodes class is a simple static library of methods for returning HTTP status codes. The following methods are available:
    
#### 200s    
    
    HTTPStatusCodes::ok($body);

    HTTPStatusCodes::created($body);

    HTTPStatusCodes::accepted($body);

    HTTPStatusCodes::no_content(); // you can provide a body, but it is ignored

#### 300s

    HTTPStatusCodes::redirect($body);

    HTTPStatusCodes::found($body);

    HTTPStatusCodes::not_modified(); // you can provide a body, but it is ignored

    HTTPStatusCodes::temporary_redirect($body);

#### 400s

    HTTPStatusCodes::bad_request($body);

    HTTPStatusCodes::unauthorized($body);

    HTTPStatusCodes::forbidden($body);

    HTTPStatusCodes::not_found($body);

#### 500s

    HTTPStatusCodes::server_error($body);

    HTTPStatusCodes::service_unavailable($body);

### Inflector

The Inflector class is a simple static library of methods for handling text. These methods are somewhat ported from Rails via [http://www.akelos.com/docs/inflector.htm](http://www.akelos.com/docs/inflector.htm). However, they've been modified to add additional methods and bring all the routines into a consistent space within a PHP class. The following methods are available:

    Inflector::pluralize_if($string, $object);
      // returns a pluralized string if the count of the object is greater than one, otherwise the unaltered string

    Inflector::is_plural($string);
      // returns boolean if the string ends in a pluralized word

    Inflector::is_singular($string);
      // returns boolean if the string ends in a singularized word

    Inflector::pluralize($string);
      // returns a pluralized string

    Inflector::singularize($string);
      // returns a singularized string

    Inflector::to_sentence($array, $separator, $last_separator);
      // returns a string of the array elements joined with the separator between all but the last two elements
      // the default separator is ', ' and the default last_separator is ' and '

    Inflector::cardinalize($number);
      // returns the string cardinal number (zero, one, two, ... ten), otherwise the string of the number

    Inflector::ordinalize($number);
      // returns the string ordinal number (first, second, third, ... tenth), otherwise the string of the number

## Developers

If you have suggestions, contributions, errors, etc. please email me, or register an issue, or fork from the DEV branch and issue a pull request. If you add additional functionality, your pull request must have corresponding supporting documentation.
