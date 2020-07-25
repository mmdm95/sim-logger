#Simplicity Logger
A library to log your activities

##Install
**composer**
```php 
composer require mmdm\sim-logger
```

Or you can simply download zip file from github and extract it,
 then put file to your project library and use it like other libraries.

##How to use
```php
// for instance a logger object
$logger = new Logger(new FileHandler($directory_to_store_logs));

// now use logger functions, for instance debug method
$logger->debug('this is a debug message');
```

Or instantiate `Logger` with other optional constructor parameters

####Description

```php
$logger = new Logger([$handler[, $format[, $date_format]]]);
```
`$handler` is a type of `IHandler` and an `IHandler` is an interface
 to extend logger for other kind of handlers and not just file handling.
 
 Also you can set handler after initializing the logger with 
 method `handler(IHandler $handler)`.

To extend `IHandler` you must implement these functions
```php
class CustomHandler implements IHandler
{
    /**
     * CunstomHandler constructor.
     */
    public function __construct()
    {
        // do initialize your needed things
    }

    /**
     * @return IHandler
     */
    public function init(): IHandler
    {
        // to whatever need for handler initialization
        
        return $this;
    }

    /**
     * @param string $message
     * @param array $data
     * @return bool
     */
    public function write(string $message, array $data = []): bool
    {
        // write $message with your log handler
        // $data have all parameters as key => value pairs
        
        // return true if write was OK or false if it wasn't
    }
}
```

`$format` is to format message that need to be written.
 Default value is `{level}: {date} - {message}`

`$format_date` is to format date of log. Default value is `Y-m-d H:i:s`.

##Available functions

There are many functions to log your message. The order of importance 
of them are:

EMERGENCY - highest level priority

ALERT

CRITICAL

ERROR

WARNING

NOTICE

INFO

DEBUG - lowest level priority

```php
// log emergency
$logger->emergency($message);

// log alert
$logger->alert($message);

// log critical
$logger->critical($message);

// log error
$logger->error($message);

// log warning
$logger->warning($message);

// log notice
$logger->notice($message);

// log info
$logger->info($message);

// log debug
$logger->debug($message);

// or you can use log function to log any level you want,
// including previous functions
$logger->log($message, LOGGER::DEBUG);
// or
$logger->log($message, 'custom level');
```

If you additional data to log, then you should use 
`extraParameters($parameter)` method and modify logger format to 
show your parameter in log message with `format($format)` method.

```php
$logger->extraParameters([
'other_parameter' => $valueOfParameter
])->format('{level} - {other_parameter} - {message}');

// now we can use log methods
$logger->log('a log message', 'custom level');
```

If you need to change date format, then you can use `dateFormat($format)` 
method

```php
$logger->dateFormat('Y/m/d H:i');
```

If you want have a better experience with date, you should enter 
your timezone through `setTimezone($timezone)` method.

The timezone will show with date for more information.

exp. 2020-07-25 09:46:19 (America/New_York)

```php
$logger->setTimezone('America/New_York');
```

#License
Under MIT license.
