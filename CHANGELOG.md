# Changelog

All notable changes to `filament-record-navigation` will be documented in this file.

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

### Added
- Added support for Laravel 12

### Changed
- Ensured compatibility with the latest Laravel version
- Improved stability and performance
- Updated dependencies for better compatibility

## v2.0.4 - 2024-06-07

Replace redirection in nextRecord and previousRecord methods with direct record update. This provides a better UX as there are no visual flashing between record changes.

Removed PHPStan

**Full Changelog**: https://github.com/josespinal/filament-record-navigation/compare/v2.0.1...v2.0.4

## Different approach for record navigation - 2024-06-05

Replace redirection in nextRecord and previousRecord methods with direct record update. This provides a better UX as there are no visual flashing between record changes.

**Full Changelog**: https://github.com/josespinal/filament-record-navigation/compare/v1.0.1...v2.0.1