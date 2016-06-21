# php-metrics-monitor

[![Build Status](https://travis-ci.org/tommy-muehle/php-metrics-monitor.svg?branch=master)](https://travis-ci.org/tommy-muehle/php-metrics-monitor)
[![Gitter](https://badges.gitter.im/tommy-muehle/php-metrics-monitor.svg)](https://gitter.im/tommy-muehle/php-metrics-monitor?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

The metrics-monitor is a simple tool to visualize metrics across various projects.
So you can see the trend on one monitor.

At the time it can visualize the the following metrics:

* (Line-)Coverage 
* to be continued ...

Further metrics are planned. Please look at the [roadmap](#roadmap) or feel free
to contact me.

## Demo

![demo](resources/memo.gif)

## <a name="install"></a> Install

### As Phar (Recommended for single-user)

You can install the monitor with these two simple commands:

```
$ curl -Os https://github.com/tommy-muehle/php-metrics-monitor/releases/download/1.0.0/memo.phar
$ chmod +x memo.phar
```

The only requirement is PHP >= 5.5.0

### From source (Recommended for multi-user)

In case that multiple users want an access to the monitor you should build up from source on
an accesssible system. For example you can create a vHost on the Jenkins CI.

The requirements are:
- PHP >= 5.5.0
- Running webserver such as Apache or nginx

To build the project do the following:

```
$ git clone https://github.com/tommy-muehle/php-metrics-monitor.git
$ cd php-metrics-monitor
$ composer install --no-dev
```

After these steps you can play with memo:
 
```
$ php ./bin/memo
``` 

To build your own [phar](http://php.net/manual/en/book.phar.php) do this in the project directory:

```
$ curl -LSs https://box-project.github.io/box2/installer.php | php
$ php box.phar build
```

Now you can found your own phar in the [build](build) directory.

## <a name="usage"></a> Usage

### Add entries

To add entries for further visualization run the following command:

```
$ php memo.phar add path/to/coverage.xml --slug=MYPROJ
```

The "slug" option are optional. The default is "GENERAL".

This task can also automatically done by a CI system such as Jenkins. Please look at the 
[wiki page](https://github.com/tommy-muehle/php-metrics-monitor/wiki/Integration-in-CI-system) to see integration examples.

### Show diagrams

To visualize the results simple run the following command:

```
$ php memo.phar run
```

After this you can access the GUI via browser. 
By default the address are *http://localhost:8000*.

If you want permanent access to the GUI then take a look at 
this [wiki page](https://github.com/tommy-muehle/php-metrics-monitor/wiki/Run-GUI-as-MacOS-daemon).

## <a name="security"></a> Security

You can download [Tommy's](https://github.com/tommy-muehle) public key and verify the 
signature (memo.phar.sig) of the memo.phar.

```
$ gpg --keyserver hkp://pgp.mit.edu --recv-keys 9BA742C3
$ gpg --verify memo.phar.sig memo.phar
```

## <a name="roadmap"></a> Roadmap

### [1.1.0](https://github.com/tommy-muehle/php-metrics-monitor/tree/release/1.1.0) (Planned release in mid-July)

- Add complexity as second diagram option 
- Refactor javascript parts

## Changelog

### [1.0.0]

- Initial release with coverage diagram option

## <a name="contribute"></a> Contributing

Please refer to [CONTRIBUTING.md](CONTRIBUTING.md) for information on how to contribute.
