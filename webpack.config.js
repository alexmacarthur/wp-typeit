const defaultConfig = require("@wordpress/scripts/config/webpack.config");

module.exports = {
  ...defaultConfig,
  entry: {
    ...defaultConfig.entry,
    index: "./src/block/index.js",
    editor: "./src/scss/style.scss",
  },
  resolve: {
    ...defaultConfig.entry,
    extensions: [".tsx", ".ts", ".js"],
  },
  module: {
    ...defaultConfig.module,
    rules: [
      ...defaultConfig.module.rules,
      {
        test: /\.tsx?$/,
        use: "ts-loader",
        exclude: /node_modules\/(?!typeit)/,
      },
    ],
  },
  plugins: [...defaultConfig.plugins],
};
