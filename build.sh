#!/bin/bash

echo "Building production version of plugin..."

rm -rf ../wp-typeit-build
npm install 
npm run build
rm -rf node_modules
mkdir -p ../wp-typeit-build/wp-typeit
cp -a ./ ../wp-typeit-build/wp-typeit

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
    "empty.ts"
    "tsconfig.json"
    ".tool-versions"
)

for item in "${FILES_TO_DELETE[@]}"
do
    path_to_delete="../wp-typeit-build/wp-typeit/$item"
    echo "Deleting $path_to_delete"
    rm -rf $path_to_delete
done

cd ../wp-typeit-build
echo "Zipping..."
zip -r "wp-typeit.zip" ./wp-typeit
cd ../wp-typeit

echo "Done!"
