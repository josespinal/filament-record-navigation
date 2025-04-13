# Changelog

All notable changes to `filament-record-navigation` will be documented in this file.

## v2.2.0 - 2025-04-13

### Added
- Added support for relation managers refresh when navigating between records
- Added new trait `HasRelationManagersWithRecordNavigation` for relation managers
- Implemented auto-reload for relation managers via Livewire events

### Changed
- Refactored record initialization to use existing Filament methods
- Improved handling of record changes to ensure relation managers stay in sync
- Optimized record loading process

**Full Changelog**: https://github.com/josespinal/filament-record-navigation/compare/v2.1.0...v2.2.0

## v2.1.0 - 2025-04-12

### Added
- Enhanced record navigation actions with session-based visibility
- Added data change tracking and confirmation dialog for unsaved changes
- Added CSS attributes for easier styling of navigation buttons

### Changed
- Renamed event listeners for consistency and clarity
- Updated properties to better reflect their purpose, including changing `isViewRecord` to `isViewPage`
- Improved documentation to clarify customization of unsaved changes confirmation message

### Dev
- Updated GitHub Actions workflow to include Filament 3.0 in test matrix

**Full Changelog**: https://github.com/josespinal/filament-record-navigation/compare/v2.0.4...v2.1.0

## v2.0.5 - 2025-04-12

### v2.0.5 - Laravel 12 Support

#### New Features
- Added support for Laravel 12

#### Changes
- Ensured compatibility with the latest Laravel version
- Improved stability and performance
- Updated dependencies for better compatibility

#### Notes

This release maintains backward compatibility with previous Laravel versions while adding support for Laravel 12. If you encounter any issues, please report them in the GitHub issue tracker.

## v2.0.4 - 2024-06-07

Replace redirection in nextRecord and previousRecord methods with direct record update. This provides a better UX as there are no visual flashing between record changes.

Removed PHPStan

**Full Changelog**: https://github.com/josespinal/filament-record-navigation/compare/v2.0.1...v2.0.4

## Different approach for record navigation - 2024-06-05

Replace redirection in nextRecord and previousRecord methods with direct record update. This provides a better UX as there are no visual flashing between record changes.

**Full Changelog**: https://github.com/josespinal/filament-record-navigation/compare/v1.0.1...v2.0.1