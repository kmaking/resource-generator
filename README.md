# KMA Resource Generator

KMA resource generator used to generate resourcefull controller with views and form controller

## *Artisan Use*

`kma-gen:resources <ModelName> --layout=<app-layout> --prefix=<route-prefix> --view-path=<resourcefull-blade-file-path> --namespace=<controller-namespace>`

##### <ModelName>
Give Models Name for resource

##### --layout=<app-layout> (optional)
`--layout` is optional argument.  
You can set your custom layout for reasource blade files by using this argument.
**Default Value** : layouts.app

##### --prefix=<route-prefix> (optional)
`--prefix` is optional argument.  
You can set route prefix for resource route action.
**Default Value** : Model Name in lower case

##### --view-path=<resourcefull-blade-file-path> (optional)
`--view-path` is optional argument.  
You can put all resource blade files on your custom path under **resources/views** folder
**Default Path** : resources/views/<models-name-in-lowercase>

##### --namespace=<controller-namespace> (optional)
`--namespace` is optional argument.  
You can change namespace of controller by using this argument
**Default Value** : App\Http\Controllers

## *Number of Files Generating*

* One Controller File
* One Url Presenter File
* Four blade files
  - index.blade.php
  - create.blade.php
  - edit.blade.php
  - form.blade.php
  - show.blade.php

## *Licence*
The MIT License (MIT).
