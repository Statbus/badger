# TGBadger
A fun little tool to generate ID badges using assets from the TGStation project.

https://badger.statbus.space/

## Issues
[https://github.com/statbus/badger](Right here).

## Run locally

You'll ned a copy of the repository checked out. This should be mounted in the docker container at `/tg`. 

Everything else neds to be run from the directory where you cloned BadgeR to.

Build the PHP docker image because BadgeR uses a bunch of image manipulation extensions:
```
docker build . -t badgerphp
```
And then:
```
docker run -it --rm -w /usr/src/myapp -v tgstation:/tg -v $(pwd):/usr/src/myapp -p 9000:9000 badgerphp -S 0.0.0.0:9000 -t public/
```
The pages to generate the icon PNGs and json files are password-protected. Copy `config-example.php` to `config.php` and adjust settings as nedded. If you're running this locally, you don't ned to change any settings.

Once it's running, go to `localhost:9000/icons.php?pass=123` and click the red "Render All" button at the top right. 

Then go to `http://localhost:9000/json_merge.php?pass=123` to generate and merge the json files.