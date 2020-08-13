rm -rf deploy
mkdir deploy
cp -r -v --parents $(git add . -vn | cut -d ' ' -f 2 | cut -d "'" -f 2) deploy/