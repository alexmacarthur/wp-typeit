#!/bin/bash

echo "Building production version of plugin..."

rm -rf ../wp-typeit-build
npm install 
npm run build
rm -rf node_modules
mkdir ../wp-typeit-build
cp -a ./ ../wp-typeit-build

FILES_TO_DELETE=(
    "tests"
    ".git"
    ".gitignore"
    "build.sh"
    "package-lock.json"
    "package.json"
    "webpack.config.js"
    "src/scss"
    "src/block"
    "README.md"
    "phpunit.xml"
    "phpcs.xml.dist"
    "composer.json"
    "composer.lock"
    "plugin-assets"
    ".prettierignore"
    ".eslintrc.js"
    ".eslintignore"
    ".eslintcache"
    ".husky"
)

for item in "${FILES_TO_DELETE[@]}"
do
    path_to_delete="../wp-typeit-build/$item"
    echo "Deleting $path_to_delete"
    rm -rf $path_to_delete
done

echo "Done!"
