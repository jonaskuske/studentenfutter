<br>

# studentenfutter

<br>

## Instructions

#### Clone the repo

`> git clone --recurse-submodules https://github.com/jonaskuske/studentenfutter`

> If you clone the repo without `--recurse-submodules`, run `git submodule update --init --recursive` in the project dir.

#### Install dependencies

`> npm install`

#### Development

`> npm start` (requires PHP >= 7.2 with `curl`, `ctype`, `mbstring` and `gd` extensions)

> Then visit [`localhost:8080`](http://localhost:8080) (or [`localhost:8080/panel`](http://localhost:8080/panel) for the admin panel) 👍🏻

#### Build for production

`> npm run build`
