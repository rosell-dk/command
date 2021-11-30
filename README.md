# Exec

[![Build Status](https://github.com/rosell-dk/exec-with-fallback/actions/workflows/php.yml/badge.svg)](https://github.com/rosell-dk/exec-with-fallback/actions/workflows/php.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/rosell-dk/exec-with-fallback/blob/master/LICENSE)


Execute command with *exec()*, *open_proc()* or whatever available

If `exec()` is available, it simply uses that method. Otherwise:
If `open_proc()` is available, it uses that to emulate an exec call.
If `passthru()` is available, it uses that to emulate an exec call.

## Usage:

Simply swap out your current *exec()* calls with *ExecWithFallback::exec()* in order to get a more resilient exec(). The signatures are exactly the same and they handle errors the same way.

Here is an example, where we swap *exec()* calls with *ExecWithFallback::exec()*.
```php
use ExecWithFallback\ExecWithFallback;
$result = ExecWithFallback::exec('echo "hi"', $output, $result_code);
// $output (array) now holds the output
// $result_code (int) now holds the result code
// $return (string | false) is now false in case of failure or the last line of the output
```

## Background
Some hosts ([at least one](https://wordpress.org/support/topic/php-8-and-exec-disabled-leads-to-fatal-error/#post-15103963)) disallows *exec()*, but allows *open_proc()*. In case you have no control over the serve and want you code to run on as many hosts as possible, you can swap out your *exec()* calls with this library. At least, that is the aim. It is not there yet!

## Implementation
Essentially, ExecWithFallback\exec() does this:
```php
if (function_exists('exec')) {
  // call exec()
} elseif (function_exists('proc_open')) {
  // use proc_open to emulate exec()
} elseif (function_exists('passthru')) {
  // use passthru to emulate exec()
} else {
  // call exec() - in order to throw exact same exception / error as exec() would do
}
```


## Current state: near stable
It is now tested across many platforms and PHP versions. Not tested in 5.6 yet, though.
I want to add a few more methods for mimicing exec().
Also, in case that a method returns false (soft failure), we should go on to the next instead of returning false
