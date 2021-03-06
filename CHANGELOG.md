# Changelog

All notable changes to this package will be documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.2.0-beta] - 2020-09-09
## Updated
- Updated to support Laravel 8
## Fixed
- Fixed a bug where `ModelOperation::getModel()` couldn't return null
- Fixed a bug where `Operation::shouldSkip()` wasn't behaving correctly

## [2.1.0-beta] - 2020-04-10
## Added
- Added abstract operation for dealing with create & update events on models
- Added transactional operation for simplicity

## [2.0.1-beta] - 2020-03-05
### Fixed
- Fixed operation self class reference for the `Operation::start()` method.

## [2.0.0-beta] - 2020-03-03
### Changed
- Renamed `Operation::getAttributes()` to `Operation::getPropertiesAsAttributes()` to avoid name collisions and to be more descriptive.

## [1.0.0-beta] - 2020-03-03
### Updated
- Upgraded Laravel support to include 7.x 

### Added
- Add a user password validation rule
- Base abstract operation class
- Added castable for CarbonInterval and UUID

### Changed
- Moved the operations contract to a more sensible namespace

## [1.0.2-alpha] - 2020-01-19
### Changed
- Disabled the query grammar override for now

## [1.0.1-alpha] - 2020-01-17
### Removed
- Removed the builder expressions extensions because of bug with Laravel macros being invoked

## [1.0.0-alpha] - 2020-01-17
- Initial release

[Unreleased]: https://github.com/sprocketbox/laravel-toolkit/compare/v2.1.0-beta...develop
[2.1.0-beta]: https://github.com/sprocketbox/laravel-toolkit/compare/v2.0.1-beta...v2.1.0-beta
[2.0.1-beta]: https://github.com/sprocketbox/laravel-toolkit/compare/v2.0.0-beta...v2.0.1-beta
[2.0.0-beta]: https://github.com/sprocketbox/laravel-toolkit/compare/v1.0.0-beta...v2.0.0-beta
[1.0.0-beta]: https://github.com/sprocketbox/laravel-toolkit/compare/v1.0.1-alpha...v1.0.0-beta
[1.0.2-alpha]: https://github.com/sprocketbox/laravel-toolkit/compare/v1.0.1-alpha...v1.0.2-alpha
[1.0.1-alpha]: https://github.com/sprocketbox/laravel-toolkit/compare/v1.0.0-alpha...v1.0.1-alpha
[1.0.0-alpha]: https://github.com/sprocketbox/laravel-toolkit/releases/tag/v1.0.0-alpha