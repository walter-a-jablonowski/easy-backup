# easy-backup

**Super simple backup tool**

This tool makes **clever use** of rules, that are added in file and folder names. Specify what should be included in backup just where you are working: in file system. No need for updating include / exclude lists in an application each time you changed something.


## How it works

"Last rule counts"

|         Files/folders using rules             |                  Result in backup                  |
| --------------------------------------------- | -------------------------------------------------- |
| /folder.bac/sub/sub1/myfile_1_1.txt           | myfile included because of '.bac'                  |
| /folder.bac/sub/sub5.nobac/myfile_2_1.txt     | no include of myfile because last rule is '.nobac' |
| /folder.bac/sub/sub1/myfile_1_2.nobac.txt     | also works for file names                          |
| /folder.bac/sub/sub5.nobac/myfile_2_2.bac.txt | myfile included because last rule is '.bac'        |

You need at leat one .bac somewhere in hierarchie for each source folder. You can change this in config (see below).


## Usage

1. `composer install`
2. Run demo: see results in /demo
3. Edit config.yml


## Config file

**src/config.yml**

```yaml
running:    true               # stop backup
backupFld:  "../demo/backup/"
sourceFlds:                    # list of source folders

  - "../demo/source/"

skip:                          # use any part of /my/full/fld/fil.txt
  - "/.backup"
  - "/.v-backup"

doBackup: ".bac"
noBackup: ".nobac"
```


## Changelog

* [x] **2025-04** - Simplified
* [x] **2019-06** - Added readme, released code
* [x] **2018** - Development


## LICENSE

Copyright (C) Walter A. Jablonowski 2018-2025, MIT [License](LICENSE)

This project is build upon PHP (license see [credits](credits.md)) and has no further dependencies.


[Privacy](https://walter-a-jablonowski.github.io/privacy.html) | [Legal](https://walter-a-jablonowski.github.io/imprint.html)
