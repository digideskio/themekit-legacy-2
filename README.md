## DataPress ThemeKit

#### 1. Launching the Website (MAMP)

* [Install MAMP Pro](https://www.mamp.info/en/downloads/).
Set up MAMP:
  * Disable Mac's built in Apache (turn off WebSharing, or any brew installation).
  * Set ports to be 80/443/3306
  * Under Hosts, add a host called `themekit`. Set the `DocumentRoot` to point to `wordpress/` in this repository.
  * Start servers.

Install the database:
* In MAMP, click the MySQL tab, and open phpMyAdmin to administrate the database.
* Click Users (at the top), then Add User.
* Create user:
  * Username: `themekit`
  * Host: Local (in the dropdown)
  * Password `themekit`
  * Check `Create database with same name and grant all privileges`.
* Click the new `themekit` database on the left.
* Click Import (at the top).
* Click Choose File, and select `db.mysql` from this repository.

Open [http://themekit](http://themekit) in your browser.
* Log in:
  * Username `themekit`
  * Password `themekit`

#### 2. Editing The Theme

The theme is located in `wordpress/wp-content/themes/custom`.

Before you start, set up Gulp:
    cd wordpress/wp-content/themes/custom
    npm install
    gulp

* Edit the theme in-place. There's no need to rename it.
* **Tip:** *Always* favour editing a [Bootstrap variable](http://getbootstrap.com/customize/) over defining a custom rule. It is more robust and future-proof.
  * eg. Set `@btn-font-weight: 300` instead of `.btn { font-weight: 300; }`

Project structure:

    wordpress/wp-content/themes/custom # → Root of your DataPress theme
    ├── ▸ assets                       # → Front-end assets (raw)
    │   ├── ▸ fonts                    # → Optional custom fonts
    │   ├── ▸ images                   # → Images
    │   ├── ▸ styles                   # → Main SASS stylesheets
    │   └── manifest.json              # → Gulp helper file
    ├── ▸ dist                         # → Front-end assets (compiled)
    │   ├── ▸ fonts                    # → Output from Gulp. Do not edit
    │   ├── ▸ images                   # → Output from Gulp. Do not edit
    │   ├── ▸ scripts                  # → Output from Gulp. Do not edit
    │   └── ▸ styles                   # → Output from Gulp. Do not edit
    ├── ▸ lib                          # → Inherited PHP/JS libraries
    │   ├── ▸ bootstrap-sass           # → Raw Bootstrap source code (Edit variables.scss)
    │   ├── ▸ fontawesome              # → See http://fontawesome.io
    │   ├── ▸ jquery                   # → See http://jquery.com
    │   ├── ▸ moment                   # → See http://momentjs.com
    │   ├── ▸ select2                  # → See https://select2.github.io
    │   ├── ▸ shortcodes               # → Custom PHP shortcodes for editors
    │   ├── assets.php                 # → WordPress' frontend assets config
    │   ├── breadcrumbs.php            # → Calculates breadcrumbs to appear
    │   ├── init.php                   # → Handles sidebar & nav extensions
    │   ├── nav.php                    # → Bootstrap nav menu in Wordpress
    │   ├── user.php                   # → Utils for user's context menu
    │   └── wrapper.php                # → (Roots/Sage) Wraps ever page render
    ├── ▸ snippets                     # → Page layout
    │   ├── ▸ page/                    # → HTML for breadcrumbs, footer etc
    │   ├── ▸ sidebars/                # → HTML for all sidebars
    │   ├── actionsbuttons.php         # → HTML for user context button
    │   ├── article-list.php           # → HTML for standard blog view
    │   ├── dataset-read-title.php     # → HTML for dataset header
    │   ├── dataset-search-result.php  # → HTML for dataset search & newsfeeds
    │   ├── facet.php                  # → HTML for search sidebar
    │   ├── modal-api-key.php          # → HTML for user API popup
    │   ├── pagination.php             # → HTML for scrolling through search
    │   └── polaroid.php               # → HTML for publisher/topic icons
    ├── 404.php                        # → Template for error pages
    ├── base.php                       # → Structural. Edit assets or snippets instead
    ├── bower.json                     # → Installs libraries in lib/
    ├── ckan-activity.php              # → Template for dataset activity streams
    ├── ckan-dataset-read.php          # → Template for /dataset/<name>
    ├── ckan-dataset-resource-read.php # → Tempalte for /dataset/<name>/resource/...
    ├── ckan-publisher-index.php       # → Template for /publisher/<name>
    ├── ckan-search.php                # → Template for /dataset
    ├── ckan-topic-index.php           # → Template for /topic/<name>
    ├── ckan-user-read.php             # → Template for /user
    ├── front-page.php                 # → Tempalte for /
    ├── functions.php                  # → Theme-specific utility functions
    ├── gulpfile.js                    # → Configures the /assets → /dist pipeline
    ├── index.php                      # → Template for /blog
    ├── package.json                   # → Used to install Gulp
    ├── page.php                       # → Template for general pages
    ├── screenshot.png                 # → Update with an icon for your theme
    ├── single.php                     # → Template for /blog/<blogpost>
    └── style.css                      # → Ignore, not used

--

#### FAQ

_What's in the database?_

A dummy version combining content from Leeds and London, with a list of Posts and Apps and a standard menu setup.

_Where are the CKAN pages generated?_

They are not. Dummy JSON files simulate the existence of the CKAN API, so the backend is effectively a stub built out of snapshots. Search strings are ignored, and only one dataset actually gets rendered no matter which one you select.
