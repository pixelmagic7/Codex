# Tools

## Rakefile

### Requirements

* Ruby
* Gems: Rake, uglifier, yui/compressor

## Setup

* Install Ruby

```
# install gems
gem install rake uglifier yui-compressor
# create new plugin
mkdir ~/code/my-wp-plugin
cd ~/code/my-wp-plugin
touch Rakefile
# copy Rakefile contents to Rakefile
rake -T # to test if it works
# create plugin stub
rake init
```


### Available Tasks

```
➜ rake -T
rake init         # create basic plugin files and directories
rake prepare      # prepare all assets for production
rake prepare:css  # prepare css files for production
rake prepare:js   # prepare javascript files for production
```