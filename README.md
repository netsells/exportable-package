# Exportable
[![Latest Version](https://img.shields.io/github/release/netsells/exportable.svg?style=flat-square)](https://github.com/netsells/exportable/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/netsells/exportable.svg?style=flat-square)](https://packagist.org/packages/netsells/exportable)

Allows easy exporting of data from Eloquent models

## Getting Started

Install `Exportable` using Composer.

```
$ composer require netsells/exportable
```

### Implementation

This implementation of Exportable makes exporting data from Eloquent models to CSV or PDF formats simple. Simply extend the `Netsells\Exportable\ExportableModel` base class included in the package for any Eloquent model that needs to use the export functionality.

```
use Netsells\Exportable\ExportableModel;

class User extends ExportableModel
```

#### ExportableModel ####
The base class for the exportable model implements and satisfies the `ExportableContract` interface that can be applied to other classes. The two traits that perform the exporting of data are imported here as well.

```
use Netsells\Exportable\Contracts\ExportableContract;
use Netsells\Exportable\Traits\ExportableCsv;
use Netsells\Exportable\Traits\ExportablePdf;

class ExportableModel extends Model implements ExportableContract
{
    use ExportablePdf;
    use ExportableCsv;
```

The two core methods for exporting data are as follows:

`public static function exportToPdf`

`public static function exportToCsv`

The remaining two methods in the class are used to build the layout closure used by Csvme to export the data to CSV format and retrieve constants safely should they be used to provide routes to config or views.

`public static function getLayoutClosure`

`public static function getConstant`


### Basic Usage ###

#### PDF ####

Exporting data to PDF format requires a view to format the output, the data to be exported and a list of headers. An example view is included with the package and custom views can easily be applied where desired.

```php
  $users = User::all()->toArray();
  $headers = [
      "first_name"    => "First Name",
      "last_name"     => "Last Name",
      "email"         => "Email",
      "phone"         => "Phone",
  ];

  $view = "exportable\\pdf";
  User::exportToPdf($view, $users, $headers);
```
#### CSV ####

Exporting data to CSV format simply needs the data and headers, if any, that are needed for the output. No special formatting is required since it is a CSV.

```php
  $users = User::all()->toArray();
  $headers = [
      "first_name"    => "First Name",
      "last_name"     => "Last Name",
      "email"         => "Email",
      "phone"         => "Phone",
  ];

  User::exportToCsv($users, $headers);
```

### Advanced Usage ###
Included in the package is a `exportable.php` file that contains the bare bones to set up data that can be used to set up the export to CSV or PDF formats. This can be modified to suit your requirements, with multiple sections for different exports.

```php
  return [
    'pdf' => [
        'headers' => [
            // Map headers for PDF export here
        ],
        // View used to construct PDF export
        'view' => 'exportable\pdf',
    ],
    'csv' => [
        'headers' => [
            // Map headers for CSV export here
        ],
    ]
  ];
```
##### Example #####
```php
  return [
    'user' => [
      'pdf' => [
          'headers' => [
            "first_name"    => "First Name",
            "last_name"     => "Last Name",
            "email"         => "Email",
            "phone"         => "Phone",
            "email"         => "Email",
          ],
          // View used to construct PDF export
          'view' => 'exportable\user_pdf',
      ],
    ],
    'admin' => [
      'pdf' => [
          'headers' => [
            "first_name"    => "First Name",
            "last_name"     => "Last Name",
            "email"         => "Email",
            "phone"         => "Phone",
            "email"         => "Email",
            "permission_level" => "Permissions",
          ],
          // View used to construct PDF export
          'view' => 'exportable\admin_pdf',
      ],
    ]  
  ];
```
For simplicity you can add the paths to each config as constants on the model.

```php
  class User extends ExportableModel
  {
      const ADMIN_PDF_CONFIG = 'exportable.admin.pdf';
      const USER_PDF_CONFIG = 'exportable.user.pdf';
```
Using the `getConstant` static method, the value of the constant can be retrieved. This method returns null if the constant is not found on the class. Using the value of the constant, the required config data can be used to export the data, as shown below.

```php
  // Confirm class constant defined
  if ($configPath = $class::getConstant('ADMIN_PDF_CONFIG')) {
      $config = Config::get($configPath);
      $headers = $config['headers'];
      $view = $config['view'];
      $users = User::all()->toArray();
      User::exportToPdf($view, $data, $headers);
  }
```


## Built With

* [Csvme](https://github.com/netsells/csvme) - An opinionated library that utilises the league/csv library
* [Dompdf](https://github.com/dompdf/dompdf) - Dompdf is an HTML to PDF converter

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
