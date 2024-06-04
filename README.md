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

In your Filament resource's `EditRecord` page, use the `HasRecordNavigation` trait to add the navigation functionality. And add the action where you want, for example the header:

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

In your resource's `ListRecords` page, store the record IDs in the session to enable navigation. Make sure it's called "filament_record_navigation_ids":

```php
namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getTableQuery(): ?Builder
    {
        $query = parent::getTableQuery();

        // Store record IDs in session
        session(['filament_record_navigation_ids' => $query->pluck('id')->toArray()]);

        return $query;
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jose Espinal](https://github.com/josespinal)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
