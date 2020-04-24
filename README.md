# easy backup

**Super simple backup tool**

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

This tool makes **clever use** of rules, that are added in file and folder names. Specify what should be included in backup just where you are working: in file system. No need for updating include / exclude lists in an application each time you changed something. You can't forget and it's easy ;-)

> If you like visit my personal homepage: [walter-a-jablonowski.github.io](https://walter-a-jablonowski.github.io)


## How it works

See also config file below

"Last rule counts"

|         Files/folders using rules             |                  Result in backup                  |
| --------------------------------------------- | -------------------------------------------------- |
| /folder.bac/sub/sub1/myfile_1_1.txt           | myfile included because of '.bac'                  |
| /folder.bac/sub/sub5.nobac/myfile_2_1.txt     | no include of myfile because last rule is '.nobac' |
| /folder.bac/sub/sub1/myfile_1_2.nobac.txt     | also works for file names                          |
| /folder.bac/sub/sub5.nobac/myfile_2_2.bac.txt | myfile included because last rule is '.bac'        |

You need at leat one .bac in hierarchie for each source folder, cause default is "nobac". **You can change** ".bac" and ".nobac" in config, see below.


## Usage

1. Download
2. place source somewhere
3. cd there
4. cd /src `composer install`
5. Run sample like 9. with no arguments
6. See results in /demo

7. Edit backup config (sample_backup_conf.yml)
8. Rename it, put it where you like, edit config.php
9. Call like

   1. `[...]/run_backup.php` uses the config.yml if no args
   2. `[...]/run_backup.php?conf='/place/of/my/conf.yml'`
   3. or `php run_backup.php "'/place/of/my/conf.yml'"`
   4. include the "'"

3. You might want 2 use cronjobs or some scheduler

`conf` arg must/can be (any) valid PHP that builds a string. Use PHP defines like
`run_backup.php?conf=BASE_FOLDER.'app-data/backup/conf.yml'` (of course needs definition first).

Use of eval might look insecure, but this tool was made for internal use only. Run it on a secure
machine, then it *is* secure.


## Config file

See src/sample_backup_conf.yml

**Provides more features:**

```yaml
---

Running: true  # keep running or stop backup

Backup fld: "'/my/backup/fld/'"  # where 2 put backups in
                       # use valid PHP code including "'"

Source flds:  # a list of base folders that should be included in backup

  - "MY_FOLDER . 'my_fld/'"  # you can also use PHP defines
                             # must be valid PHP that builds a string
  
# default is "nobac" for source folders, you need at least one rule, see readme

General rules:  # always skip

  Skip: # use any part of /my/full/fld/fil.txt
    - /.backup
    - /.v-backup

# Change what is used for rules in file/folder names

Do backup: .bac
No backup: .nobac
```


## LICENSE

Copyright (C) Walter A. Jablonowski 2018, MIT [License](LICENSE)

This project is build upon PHP (license see [credits](credits.md)) and has no further dependencies.


[Privacy](https://walter-a-jablonowski.github.io/privacy.html) | [Legal](https://walter-a-jablonowski.github.io/imprint.html)


## Changelog

* [x] **2019-06** added readme, released code
* [x] **2018** development
