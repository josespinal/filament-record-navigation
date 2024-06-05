# Filament Record Navigation Plugin

## Introduction

The **Filament Record Navigation Plugin** allows seamless navigation through records in a Filament resource's view. With this plugin, you can add "Next" and "Previous" buttons to navigate through records efficiently.

## Installation

### Step 1: Require the package via Composer:

```bash
composer require josespinal/filament-record-navigation
```

The package will automatically register itself.

## Usage

### Use the Trait in Your Filament Resource Page

In your Filament resource's `EditRecord` page, use the `HasRecordNavigation` trait to add the navigation functionality. And add the action where you want, for example, the header with `getHeaderActions`:

```php
namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\EditRecord;
use JoseEspinal\RecordNavigation\Traits\HasRecordNavigation;

class EditPost extends EditRecord
{
    use HasRecordNavigation;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge(parent::getActions(), $this->getNavigationActions());
    }
}
```

### Use with existing actions
If you have existing actions, merge them with the navigation actions, like so:

```php
protected function getHeaderActions(): array
{
    $existingActions = [
        // Your existing actions here...
    ];

    return array_merge($existingActions, $this->getNavigationActions());
}
```

### Store Record IDs in Session

In your resource's `ListRecords` page, include the `HasRecordsList` trait as follows:

```php
namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ListRecords;
use JoseEspinal\RecordNavigation\Traits\HasRecordsList;

class ListPosts extends ListRecords
{
    use HasRecordsList;

    protected static string $resource = PostResource::class;
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jose Espinal](https://github.com/josespinal)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
