# Changelog

All notable changes to `filament-record-navigation` will be documented in this file.

## v2.1.0 - 2025-04-11

### Added
- Unsaved changes confirmation before record navigation
- Support for Laravel 12
- Browser history management for record navigation
- Proper Filament asset registration
- Enhanced event handling for navigation state

### Changed
- Updated dependencies to ensure compatibility with Laravel 12
- Migrated from `Filament\Pages\Actions\Action` to `Filament\Actions\Action`
- Improved navigation UX with proper URL updates

**Full Changelog**: https://github.com/josespinal/filament-record-navigation/compare/v2.0.4...v2.1.0

## v2.0.4 - 2024-06-07

Replace redirection in nextRecord and previousRecord methods with direct record update. This provides a better UX as there are no visual flashing between record changes.

Removed PHPStan

**Full Changelog**: https://github.com/josespinal/filament-record-navigation/compare/v2.0.1...v2.0.4

## Different approach for record navigation - 2024-06-05

Replace redirection in nextRecord and previousRecord methods with direct record update. This provides a better UX as there are no visual flashing between record changes.

**Full Changelog**: https://github.com/josespinal/filament-record-navigation/compare/v1.0.1...v2.0.1
