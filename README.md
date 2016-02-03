# m2-training-orm

### Installation

```sh
$ composer config repositories.koncz-m2-trainig-orm git git@github.com:ksz2013/m2-training-orm.git
$ composer require koncz/m2-training-orm:dev-master
```

Manually:

Copy the zip into app/code/Training/Orm directory


#### After installation by either means, enable the extension by running following commands:

```sh
$ php bin/magento module:enable Training_Orm --clear-static-content
$ php bin/magento setup:upgrade
```