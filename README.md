## LezWatch.TV Docs Plugin

Custom plugin for LezWatch.TV Docs

## Description

The LezWatch.TV Docs plugin contains custom code for use with the site. Instead of having everything hardcoded into the theme, or shoved in a shared MU Plugin, it was moved to it's own plugin. This allows it to be updated outside of the theme and deploy new features as needed.

The code was written by Tracy Levesque and Mika Epstein, with assistance from [Yikes Inc.](YikesInc.com)

## Features

* Custom Post Types: Administration, API Docs, Style Guide
* Table of Contents

## Development

Update code like you normally would. If you don't want to push it anywhere, make a local branch. Always remember, merge to **development** first. If that works, do a pull request to **master** and when it's done, it'll update properly.

### Deployment

Pushes to branches are automatically deployed via Codeship as follows:

* Master: [docs.lezwatchtv.com](https://docs.lezwatchtv.com)
