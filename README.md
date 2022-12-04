<h1 align="center">studentenfutter</h1>
<p align="center"><b>🥗 Web app for student cookbook "studentenfutter"</b></p>

<br>
<br>

<p align="center">
  <img width="650" src="showcase.png">
</p>

<p align="center">
  <a href="https://studentenfutter.app">
    <img align="center" width="133" src="https://raw.githubusercontent.com/webmaxru/progressive-web-apps-logo/c43088c1809fbf5c45c04904db95d195ad7dc893/assets/svg/PWA-dark-en.svg" alt="Launch studentenfutter as web app" />
  </a>
  <a href="https://play.google.com/store/apps/details?id=app.studentenfutter.twa">
    <img align="center" width="150" src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png"  alt="Get studentenfutter on Google Play" />
  </a>
  <a href="https://apps.microsoft.com/store/detail/studentenfutter/9N3WQMQTT6HD">
    <img align="center" width="108" src="https://get.microsoft.com/images/en-us%20dark.svg" alt="Get studentenfutter from the Microsoft Store" />
  </a>
</p>

<br>
<br>

## Instructions

#### Clone the repo

`> git clone --recurse-submodules https://github.com/jonaskuske/studentenfutter`

> If you clone the repo without `--recurse-submodules`, run `git submodule update --init --recursive` in the project dir.

#### Install dependencies

`> npm install`

#### Development

`> npm start` (requires PHP >= 7.2 with `curl`, `ctype`, `mbstring` and `gd` extensions)

> Then visit [`localhost:8000`](http://localhost:8000) (or [`localhost:8000/panel`](http://localhost:8000/panel) for the admin panel) 👍🏻

#### Build for production

`> npm run build`

<br>

---

Built with [Kirby CMS](https://getkirby.com), [TailwindCSS](https://tailwindcss.com) and [Alpine.js](https://github.com/alpinejs/alpine)
.
