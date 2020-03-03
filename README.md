# webshoptools

[![CircleCI](https://circleci.com/gh/greenpeace-cee/webshoptools.svg?style=svg)](https://circleci.com/gh/greenpeace-cee/webshoptools)

This CiviCRM extension provides some behind-the-scenes tooling for an activity-based webshop process.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.0+
* CiviCRM 5.19+

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl webshoptools@https://github.com/greenpeace-cee/webshoptools/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/greenpeace-cee/webshoptools.git
cv en webshoptools
```

## Usage

* Subject of "Webshop Order" activities is automatically generated based on the
  template `{order_type}[ {shirt_type}/{shirt_size}] {number_of_items}x`
