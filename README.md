# SharIF Judge

[SharIF Judge](https://github.com/ifunpar/Sharif-Judge) is a free and open source online judge for C, C++, Java and
Python programming courses. SharIF Judge is a fork of the original [Sharif Judge](https://github.com/mjnaderi/Sharif-Judge) beautifully created by [@mjnaderi](https://github.com/mjnaderi). This forked version contain many improvements, mostly due to the needs by our faculty at [@ifunpar](https://github.com/ifunpar).

The web interface is written in PHP (CodeIgniter framework) and the main backend is written in BASH.

Python in SharIF Judge is not sandboxed yet. Just a low level of security is provided for python.
If you want to use SharIF Judge for python, USE IT AT YOUR OWN RISK or provide sandboxing yourself.

The full documentation is at https://github.com/ifunpar/Sharif-Judge/tree/docs

Download the latest release from https://github.com/ifunpar/Sharif-Judge/releases

## Features
  * Multiple user roles (admin, head instructor, instructor, student)
  * Sandboxing _(not yet for python)_
  * Cheat detection (similar codes detection) using [Moss](http://theory.stanford.edu/~aiken/moss/)
  * Custom rule for grading late submissions
  * Submission queue
  * Download results in excel file
  * Download submitted codes in zip file
  * _"Output Comparison"_ and _"Tester Code"_ methods for checking output correctness
  * Add multiple users
  * Problem Descriptions (PDF/Markdown/HTML)
  * Rejudge
  * Scoreboard
  * Notifications
  * Lock Student's Display Name
  * Archived Assignment
  * Hall of Fame 
  * 24-hour Logs
  * ...

## Requirements

For running SharIF Judge, a Linux server with following requirements is needed:

  * Webserver running PHP version 5.3 or later with `mysqli` extension
  * PHP CLI (PHP command line interface, i.e. `php` shell command)
  * MySql or PostgreSql database
  * PHP must have permission to run shell commands using [`shell_exec()`](http://www.php.net/manual/en/function.shell-exec.php) php function (specially `shell_exec("php");`)
  * Tools for compiling and running submitted codes (`gcc`, `g++`, `javac`, `java`, `python2` and `python3` commands)
  * It is better to have `perl` installed for more precise time and memory limit and imposing size limit on output of submitted code.
  * Composer dependency manager
  * intl and mbstring PHP extension

## Installation

  1. Download the latest release from [download page](https://github.com/ifunpar/Sharif-Judge/releases) and unpack downloaded file in your directory.
  2. Go to `SharIF-JudgeCI4` and do `composer install`
  4. Create a MySql or PostgreSql database for SharIF Judge. Do not install any database connection package for C/C++, Java or Python.
  5. Copy `app/Config/Secrets.example.php` to `app/Config/Secrets.php` and update the file according to your RADIUS and SMTP configuration.
  6. Copy `env` to `.env` and update database and app URL configurations
  7. Make `writables/cache` directory writable to PHP
  8. Open the main page of SharIF Judge in a web browser and follow the installation process.
  9. Log in with your admin account.
  10. **[IMPORTANT]** Move folders `tester` and `assignments` somewhere outside your public directory. Then save their full path in `Settings` page. **These two folders must be writable by PHP.** Submitted files will be stored in `assignments` folder. So it should be somewhere not publicly accessible.
  11. **[IMPORTANT]** [Secure SharIF Judge](https://github.com/ifunpar/Sharif-Judge/blob/docs/v1.4/security.md)

## After Installation

  * Read the [documentation](https://github.com/ifunpar/Sharif-Judge/tree/docs)

## License

GPL v3
