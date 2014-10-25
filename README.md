## Introduction

WP Shepherd allows you to download, install and develop multiple versions of WordPress. You can also set-up the default plugins you want to install with every download. 
WP Shepherd uses Codeigniter MVC and Twitter Bootstrap as it's foundation. See [sjlu](https://github.com/sjlu).
It is intended that this application is used on localhost with mamp, wamp or xampp.


## Installation
1. Download the master zip
2. Unzip the master
3. Rename the unzipped wps-master to wps
4. Move or copy the new wps renamed folder to the root of you web directory. i.e. if you are using mamp have it under htdocs
5. Create an empty database called wps
6. You will need to edit /wps/applications/config/config.php and add the correct $config['base_url']	= , for mamp it's $config['base_url']	= 'http://localhost:8888/wps/';
6. Launch your browser, and again as an example if your are using mamp type in loacalhost:8888
7. You will see wps. Click on it an launch WP Shepherd
8. Thats it.  


## Finished Developing a site
Once you have finished developing the site you can click on the websites menu and select 'Local to Make Live'.
This will download the MySql database for the site and the WordPress files as well. The database export is in the root of the WordPress project


Project strated on [sjlu Codeigniter and Bootstrap project](https://github.com/sjlu/)
