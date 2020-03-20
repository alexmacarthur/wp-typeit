const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  ...defaultConfig,
  entry: {
    ...defaultConfig.entry,
    index: "./src/block/index.js",
    editor: "./src/scss/style.scss",
  },
  module: {
    ...defaultConfig.module,
    rules: [
      ...defaultConfig.module.rules,
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          "sass-loader",
          {
            loader: "postcss-loader",
            options: {
              ident: "postcss",
              plugins: [require("autoprefixer")],
            },
          },
        ],
      },
    ],
  },
  plugins: [...defaultConfig.plugins, new MiniCssExtractPlugin()],
};
