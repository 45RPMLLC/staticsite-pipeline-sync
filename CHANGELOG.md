# Static Site Pipeline Sync Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 2.0.1 - 2019-11-01
### Changed
- Updated composer.json to fix a syntax issue

## 2.0.0 - 2019-10-31
### Added
- BuildController class
- Utiliy class
- _settings and _utility twig templates

### Changed
- Plugin behavior to trigger CodeBuild instead of CodePipeline
- Plugin menu location from sidebar navigation to Utilities menu navigation
- Model properties and added build project related properties
- Syntax to follow PHP7.2 and Craft code guidelines
- Translation file to match replacement placeholders inside classes
- config.php to reflect new available properties inside the model
- CSS rules and added new selectors
- JS file to trigger ajax requests from the new plugin interface  
 
### Removed
- CpController class
- home and settings twig templates

## 1.0.0 - 2019-05-31
### Added
- Initial release