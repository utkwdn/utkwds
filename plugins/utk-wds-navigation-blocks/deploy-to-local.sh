#/bin/zsh

npm run build
npm run plugin-zip
rm -rf ~/Local\ Sites/wds/app/public/wp-content/plugins/utk-wds-navigation-blocks
unzip utk-wds-navigation-blocks.zip -d ~/Local\ Sites/wds/app/public/wp-content/plugins/utk-wds-navigation-blocks/
rm utk-wds-navigation-blocks.zip