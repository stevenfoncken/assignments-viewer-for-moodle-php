# Assignments-Viewer for Moodle

[Report a Bug](https://github.com/stevenfoncken/assignments-viewer-for-moodle-php/issues/new?labels=bug&projects=&template=01_BUG-REPORT.yml&title=%5BBUG%5D+%3Ctitle%3E)
·
[Request a Feature](https://github.com/stevenfoncken/assignments-viewer-for-moodle-php/discussions/new?category=ideas)
·
[Ask a Question](https://github.com/stevenfoncken/assignments-viewer-for-moodle-php/discussions/new/choose)

![version: 1.1.0](https://img.shields.io/badge/version-1.1.0-green.svg?style=for-the-badge)
[![Minimum PHP Version: 8.3](http://img.shields.io/badge/php-%3E%3D%208.3-8892BF.svg?style=for-the-badge)](https://php.net)
[![license: MIT](https://img.shields.io/badge/license-MIT-yellow.svg?style=for-the-badge)](https://github.com/stevenfoncken/assignments-viewer-for-moodle-php/blob/master/LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/stevenfoncken/assignments-viewer-for-moodle-php.svg?style=for-the-badge)](https://packagist.org/packages/stevenfoncken/assignments-viewer-for-moodle-php)

A simple web application that lists the currently due assignments of a [Moodle™](https://moodle.org) user.

It accesses the Moodle instance via the Moodle Mobile Web Service API, which is also used by the official Moodle mobile app.

To be able to use it with a Moodle instance, the Moodle Mobile Web Services must explicitly be enabled by the instance.

**=> If the Moodle mobile app can be used, then this application can also be used.**


### 🤔 Why?

The student life, what a wonderful time, isn't it?

If only there weren't assignments to be done.

What started out as a procrastination side-task (we all know them, right? 🤫), became a nice application for listing currently due assignments (we all love them, don't we? 💚).


## 📖 Table of Contents

<details>
<summary>Click to expand</summary>

- [📖 Table of Contents](#-table-of-contents)
- [⛓ Features](#-features)
- [🚀 Getting Started](#-getting-started)
    - [Requirements](#requirements)
    - [Installation](#installation)
        - [Download or Clone the Project](#download-or-clone-the-project)
        - [Install Dependencies via Composer](#install-dependencies-via-composer)
        - [Install Frontend](#install-frontend)
    - [Config](#config)
        - [.env](#env)
- [🍿 Deployment](#-deployment)
- [🔨 Development](#-development)
    - [Tech Stack](#tech-stack)
    - [Working on FRONTEND](#working-on-frontend)
    - [Working on BACKEND](#working-on-backend)
- [Changelog](#changelog)
- [Help & Questions](#help--questions)
- [Contributing](#contributing)
- [👤 Author](#-author)
- [📎 Links](#-links)
- [💛 Support](#-support)
- [⚖️ Disclaimer](#%EF%B8%8F-disclaimer)
- [📃 License](#-license)
</details>


## ⛓ Features
- List all current due assignments for the given Moodle user.
- Different colors indicate the approaching due date:
  - Pink: 1 day, Red: 2 days, Yellow: 3 days.


## 🚀 Getting Started

### Requirements
- Git
- php >= 8.3
- Composer

### Installation

#### Download or Clone the Project

```shell
composer create-project stevenfoncken/assignments-viewer-for-moodle-php
```
or
```shell
git clone --depth 1 https://github.com/stevenfoncken/assignments-viewer-for-moodle-php.git
```

Now `cd` into the project directory.

---

#### Install Dependencies via Composer

Skip when create-project was used.

```shell
composer install
```

Note: Composer scripts are required due to the deploy-dir structure.

---

#### Install Frontend

```shell
yarn install

yarn build
```

---

### Config

#### .env

```shell
cp deploy/config/.env.dist deploy/config/.env
```

| Key                                         | Description                                                                |
|---------------------------------------------|----------------------------------------------------------------------------|
| MOODLE_BASE_URL                             | URL of the Moodle instance.                                                |
| MOODLE_USERNAME                             | Your Moodle username.                                                      |
| MOODLE_PASSWORD                             | Your Moodle password.                                                      |
| SETTING_HIDE_SUBMITTED_ASSIGNMENTS          | Hide submitted assignments in overview.                                    |
| SETTING_PAST_ASSIGNMENTS_DAYS_COUNT         | Number of days to display past assignments.                                |
| SETTING_ASSIGNMENTS_CACHE_EXPIRES_AFTER_SEC | Cache expiration date of the stored assignments data.                      |
| APP_TIMEZONE                                | [List of Supported Timezones](https://www.php.net/manual/en/timezones.php) |


## 🍿 Deployment

Deployment Root: (contents of) [`deploy/`](./deploy/) (e.g. /var/www/example_site/)

Document Root: [`docroot/`](./deploy/docroot/) (e.g. /var/www/example_site/docroot/)


## 🔨 Development

### Tech Stack

The Backend is written in PHP.

The Frontend is based on plain HTML & SCSS.
Package manager: yarn.
Bundler: webpack.

### Working on FRONTEND

Build config: [`build/frontend/`](./build/frontend/)

Source files: [`assets-src/`](./assets-src/)

Compiled files: [`deploy/docroot/dist/`](./deploy/docroot/dist/)

### Working on BACKEND

Source files: [`deploy/src/`](./deploy/src/)


## Changelog

Please see [CHANGELOG.md](./CHANGELOG.md) for more information on what has changed recently.


## Help & Questions

Start a new discussion in the [Discussions Tab](https://github.com/stevenfoncken/assignments-viewer-for-moodle-php/discussions).


## Contributing

... is welcome.

Just [fork the repository](https://docs.github.com/en/get-started/quickstart/fork-a-repo) and [create a pull request](https://docs.github.com/en/pull-requests/collaborating-with-pull-requests/proposing-changes-to-your-work-with-pull-requests/creating-a-pull-request).

For major changes, please first start a discussion in the [Discussions Tab](https://github.com/stevenfoncken/assignments-viewer-for-moodle-php/discussions) to discuss what you would like to change.

**IMPORTANT:** By submitting a patch, you agree to allow the project owner(s) to license your work under the terms of the [`MIT License`](./LICENSE).

**Thank you!**


## 👤 Author

`assignments-viewer-for-moodle-php` is primarily written and maintained by:

>🦜 Steven Foncken
>- Website: [stevenfoncken.de](https://www.stevenfoncken.de)
>- GitHub: [@stevenfoncken](https://www.github.com/stevenfoncken)
>- LinkedIn: [Steven Foncken (@stevenfoncken)](https://www.linkedin.com/in/stevenfoncken)


## 📎 Links
- https://docs.moodle.org/dev/Web_service_API_functions
- https://docs.moodle.org/dev/Creating_a_web_service_client


## 💛 Support

If this project was helpful for you or your organization, please consider supporting my work directly:

- ⭐️ [Star this project on GitHub](https://github.com/stevenfoncken/assignments-viewer-for-moodle-php)
- 🐙 [Follow me on GitHub](https://github.com/stevenfoncken)

Everything helps, thanks! 🙏


## ⚖️ Disclaimer

["Moodle"](https://moodle.com/trademarks) is a registered trademark of "Moodle Pty Ltd" and/or its (worldwide) subsidiaries.

This project or its author is in **no way** officially connected to, affiliated with, associated with, authorized by, built by, endorsed by, licensed by, maintained by, promoted by, or sponsored by "Moodle Pty Ltd" or any of its affiliates, licensors, (worldwide) subsidiaries, or other entities under its control.

All trademarks are the property of their respective owners.

This is an independent project that utilizes "Moodle"s Mobile Web Service API to fetch assignments data of the given user.

Before taking legal action, please contact this address: \<dev[at]stevenfoncken[dot]de\>

Use at your own risk.


## 📃 License

[assignments-viewer-for-moodle-php](https://github.com/stevenfoncken/assignments-viewer-for-moodle-php) is licensed under the `MIT License`.

See [LICENSE](./LICENSE) for details.

Copyright (c) 2021-present [Steven Foncken](https://github.com/stevenfoncken) \<dev[at]stevenfoncken[dot]de\>

<p align="right">^ <a href="#assignments-viewer-for-moodle">back to top</a> ^</p>
