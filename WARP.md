# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

Project overview

- Stack: PHP web app with vanilla JS/CSS. SCSS is compiled to CSS via the Sass CLI.
- Structure (high-level):
  - Root PHP app (public) with pages per program (bep, craft, redbull, sabores, tirate) and shared includes (include-*.php). Entry is index.php which authenticates and redirects to home.php and brand dashboards.
  - Assets in assets/: scss sources (assets/scss) compiled to assets/css, images, fonts, and a small JS file (assets/js/main.js) for form handling.
  - Backoffice under xrqEi2rpfA73XH9cruLMxt2oZ/: PHP classes in class/ (DB wrapper and domain classes like master, ingreso, registro), admin views, and a bundled phpMyAdmin copy in xrqEi2rpfA73XH9cruLMxt2oZ/mysql/.
  - Data ingestion: reader-*.php scripts parse CSVs into DB tables. A server-side cron script (run_task.sh) shows the production pipeline (gsutil to fetch CSVs, then PHP to process).

Common commands

- Install frontend tooling (for SCSS):
  - npm ci
  - If npm ci fails locally, npm install

- Build CSS (one-off):
  - npx sass assets/scss:assets/css
  - To build a compressed single file that matches the app’s link tag (main.min.css):
    - npx sass assets/scss/main.scss assets/css/main.min.css --style=compressed

- Watch SCSS during development:
  - npm run scss
  - This runs: sass --watch assets/scss:assets/css

- Start a local PHP server from the project root:
  - php -S localhost:8080
  - Note: class.DB.php switches DB settings when HTTP_HOST is localhost:8080 (expects a MySQL host named db with database conccursos). Adjust your environment accordingly when running locally.

- Trigger CSV ingestion manually (expects input CSVs to be present as used by the corresponding reader scripts):
  - php bep-reader.php
  - php bep-reader-detalle.php
  - php craft-reader.php
  - php craft-reader-detalle.php
  - php redbull-reader.php
  - php redbull-reader-detalle.php
  - php sabores-reader.php
  - php sabores-reader-detalle.php
  - php tirate-reader.php
  - php tirate-reader-detalle.php

Subproject: bundled phpMyAdmin (xrqEi2rpfA73XH9cruLMxt2oZ/mysql/)

- This is a vendored copy of phpMyAdmin 5.2.1 used for DB administration. It has its own toolchain and is not required for running the app.
- Commands (run inside xrqEi2rpfA73XH9cruLMxt2oZ/mysql/):
  - Install deps (use Yarn because yarn.lock is present):
    - yarn install
  - Build assets:
    - yarn build
  - Lint:
    - yarn css-lint
    - yarn js-lint
  - Test (Jest):
    - yarn test
    - Run a single test by name pattern:
      - yarn test -t "pattern"

Architecture and data flow

- Authentication/session: index.php uses master::autenticateSinIngreso() (xrqEi2rpfA73XH9cruLMxt2oZ/class/class.master.php) to initialize the session (LOGIN_*) and redirect. Domain classes are backed by a simple DB wrapper (class.DB.php) that sets MySQL connection parameters based on HTTP_HOST.
- Domain model (xrqEi2rpfA73XH9cruLMxt2oZ/class/):
  - master: user/master data and authentication helpers;
  - ingreso: tracks accesses/visits per user, district, zone;
  - registro: represents program participants and related queries;
  - inc.globals.php: project-wide helpers (date/number formatting, geo distance, etc.).
- UI and assets: assets/scss compiles to assets/css (both main.css and main.min.css exist). index.php references assets/css/main.min.css; update that file when changing SCSS (see compressed build command above). assets/js/main.js handles form submission and basic client-side validation.
- Data ingestion: reader-*.php scripts consume CSVs and persist into DB tables via the domain classes. The production cron (run_task.sh) shows how CSVs are fetched from GCS and processed with PHP 8.1.
- Admin/backoffice: xrqEi2rpfA73XH9cruLMxt2oZ/ contains admin views (informe-*.php, registro-*.php, etc.) that render analytics and management screens using the same class/ layer.

Repo-specific notes

- There is no repo-level test or lint configuration for the app code (no PHPUnit/PHPCS/Jest/Vitest at the root). Only the bundled phpMyAdmin subtree defines its own lint/tests.
- No CLAUDE.md, Cursor rules, Copilot instructions, or root README.md were found at the time of writing.
