"use strict";

const cssnano = require("cssnano")({ preset: "default" });
const purgecss = require("@fullhuman/postcss-purgecss")({
  content: ["./**/*.html", "./**/*.php"],
  whitelist: [],
  defaultExtractor: (content) => content.match(/[\w-/:.]+(?<!:)/g) || [],
});

module.exports = {
  plugins: [
    require("postcss-import"),
    require("tailwindcss"),
    require("autoprefixer"),
    ...(process.env.NODE_ENV === "production" ? [purgecss, cssnano] : []),
  ],
};
