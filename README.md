# Filament Record Navigation Plugin

## Introduction

The **Filament Record Navigation Plugin** allows seamless navigation through records in a Filament resource's view. With this plugin, you can add "Next" and "Previous" buttons to navigate through records efficiently. It includes features like unsaved changes detection, browser history management, and proper URL updates.

https://github.com/josespinal/filament-record-navigation/assets/10059/fbb09144-b0b5-411d-85a8-1d94eedcad01

## Features

- Navigate between records with "Next" and "Previous" buttons
- Unsaved changes detection with confirmation dialog
- Browser history management for proper navigation state
- Seamless URL updates without page refresh
- Automatic relation managers refresh when navigating between records
- Support for Laravel 10, 11, and 12
- Compatible with Filament v3.x

## Installation

### Step 1: Require the package via Composer:

```bash
composer require josespinal/filament-record-navigation
```

The package will automatically register itself.

### Step 2: Publish Filament Assets

After installation, you need to publish and build the Filament assets:

```bash
php artisan filament:assets
```

For production environments, make sure to run:

```bash
php artisan filament:assets --optimize
```

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

### Enable Relation Managers Refresh

To automatically refresh relation managers when navigating between records, use the `HasRelationManagersWithRecordNavigation` trait in your relation managers:

```php
namespace App\Filament\Resources\PostResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use JoseEspinal\RecordNavigation\Traits\HasRelationManagersWithRecordNavigation;

class CommentsRelationManager extends RelationManager
{
    use HasRelationManagersWithRecordNavigation;

    protected static string $relationship = 'comments';
    
    // Rest of your relation manager code...
}
```

### Unsaved Changes Detection

The plugin automatically detects unsaved changes in your forms and will prompt for confirmation before navigating away. This helps prevent accidental data loss when navigating between records.

No additional configuration is needed - this feature works out of the box.

#### Customizing the Confirmation Message

By default, this uses Filament's translation key `filament-panels::unsaved-changes-alert.body`. You can customize this message by publishing Filament's translations and modifying the corresponding translation string.

Remember to rebuild your assets after making changes.

## Browser Support

The plugin uses modern browser features for enhanced navigation:
- History API for proper browser history management
- URL updates without page refresh
- Works with all modern browsers (Chrome, Firefox, Safari, Edge)

## Changelog

Please see [CHANGELOG](https://github.com/josespinal/filament-record-navigation/blob/main/CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jose Espinal](https://github.com/josespinal)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
