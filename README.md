[![Latest Stable Version](https://poser.pugx.org/fr3ddy/easytrans/v/stable)](https://packagist.org/packages/fr3ddy/easytrans)
[![Total Downloads](https://poser.pugx.org/fr3ddy/easytrans/downloads)](https://packagist.org/packages/fr3ddy/easytrans)
[![Latest Unstable Version](https://poser.pugx.org/fr3ddy/easytrans/v/unstable)](https://packagist.org/packages/fr3ddy/easytrans)
[![License](https://poser.pugx.org/fr3ddy/easytrans/license)](https://packagist.org/packages/fr3ddy/easytrans)
[![Monthly Downloads](https://poser.pugx.org/fr3ddy/easytrans/d/monthly)](https://packagist.org/packages/fr3ddy/easytrans)
[![Daily Downloads](https://poser.pugx.org/fr3ddy/easytrans/d/daily)](https://packagist.org/packages/fr3ddy/easytrans)

# Easytrans

!ALPHA RELEASE!

Easy to use Translationsupport for your multilanguale Laravel App.

Export Excel files, translate it and import it again.

It's as easy as it sounds...

Test it now!

# Installation
Require this package with composer
```
composer require fr3ddy/easytrans
```

Add service provider to your app/config.php providers array
```php
Fr3ddy\Easytrans\EasytransServiceProvider::class,
```

Add Excel service provider to your app/config.php providers array
```php
Maatwebsite\Excel\ExcelServiceProvider::class,
```

Add Alias to your aliases array in your app/config.php
```php
'Excel' => Maatwebsite\Excel\Facades\Excel::class,
```

Publish config with
```
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```
set "force_sheets_collection" = true (line 466)


# Usage
## Export
By using the following command in your project directory, an excel file will be generated in your storage/easytrans folder.
```
php artisan easytrans:export {lang}
```

Withing this excel file, you will find one sheet for each translation file existing for this language.
Feel free to remove any sheet, it will not be a problem when importing it again.


## Import
By using the following command in your project directoy, the excel file in the storage/easytrans folder will be imported. As the filename I am expecting {lang}.xls
```
php artisan easytrans:import {lang}
```

When importing, backup files are created, and new files are generated for all sheets in this excel based on the name of the sheet.
