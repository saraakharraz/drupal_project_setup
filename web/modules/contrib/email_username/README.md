# E-Mail as Username

## Contents of this file

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Maintainers](#maintainers)

## Introduction

This module enables the use of email addresses as the drupal account username.

### Functionality

The following functionality is provided:

- The `name` user field is not required anymore
- The `mail` user field is now required
- The `mail` user field is more thoroughly validated
- The `name` user field is set to the value of the `mail` field on presave.
- Existing users have their `name` set to the `mail` field value if they have
  an email set.

**Validation**:

In addition to the default validation, the following validations are run:

- RFC validation
- DNS validation (requires the `intl` extension)
- Spoof validation (requires the `intl` extension)

If the `intl` extension is not available, the last two validations are skipped.
Additionally the DNS and Spoof validations can be disabled via settings.

## Requirements

The core module requires Drupal 10.3 or 11.

## Installation

Install as you would normally install a contributed Drupal module. For further
information, see
[Installing Drupal Modules](https://www.drupal.org/docs/extending-drupal/installing-drupal-modules).

## Configuration

Validation can be configured in `settings.php`:

```php
// Disable validation.
$settings['email_username']['validate_dns'] = FALSE;
$settings['email_username']['validate_spoof'] = FALSE;
```

## Maintainers

Current maintainers:

- Christoph Niedermoser ([@nimoatwoodway](https://www.drupal.org/u/nimoatwoodway))
- Christian Foidl ([@chfoidl](https://www.drupal.org/u/chfoidl))
