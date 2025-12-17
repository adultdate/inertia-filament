# Changelog

All notable changes to this project will be documented in this file.

## [1.0.2] - 2025-12-14

### Added
- **Custom CSS file** with animations, scrollbar styling, and hover effects
- **Comprehensive documentation** with theme integration guide
- **API usage examples** for programmatic conversation and message creation
- **Performance optimization** tips and database indexing recommendations
- **Best practices** section for production deployments
- **Troubleshooting guide** covering common issues and solutions
- **CSS asset publishing** support for better theme integration
- **Quick Start** section in README for fast setup

### Improved
- **Service provider** with automatic migration running via `runsMigrations()`
- **Message alignment** - user messages now correctly appear on right, others on left
- **File attachment handling** with proper null checks and validation
- **README structure** with detailed Table of Contents and organized sections
- **Installation instructions** including theme CSS integration steps
- **Documentation clarity** with code examples and configuration options

### Fixed
- **Message model** missing `InteractsWithMedia` trait causing attachment failures
- **Validation logic** was inverted in `validateMessage()` method
- **Duplicate style attributes** in message bubble rendering
- **Create conversation action** not rendering modal properly
- **Attachment processing** now safely handles null/empty values

---

## [1.0.1] - 2025-03-15
### Fixed
- **Inbox:** Inbox resources.
- **Messages:** Message resources.

---

## [1.0.0] - 2025-03-08
### Added
- Initial release of **Filament Messages**
- Features include:
  - User-to-User & Group Chats
  - Unread Message Badges
  - File Attachments
  - Configurable Refresh Interval
  - Timezone Support