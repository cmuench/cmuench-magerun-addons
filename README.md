cmuench-magerun-addons
======================

Additional command for magerun like "create a magerun command or create magerun module"

Adds this commands:

* `tmp:remove`  Removes folder /tmp/magento if it exists
* `magerun:command:create`  Creates a magerun command in current working directory
* `magerun:module:create`   Creates a magerun module
* `magerun:config:dump`   Dump complete all merged YAML n98-magerun config files at once

## Installation in your user module folder


    mkdir -p ~/.n98-magerun/modules
    cd ~/.n98-magerun/modules
    git clone https://github.com/cmuench/cmuench-magerun-addons.git
