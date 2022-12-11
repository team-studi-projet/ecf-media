# ecfblancmedia
Ecf blanc Mediatheque
## Installation
Faites un git clone sur votre bureau ou dans le répertoire où vous voulez stocké le projet.
***
Pour installer le projet sur votre machine, allez ici et ensuite copiez ceci dans le fichier :
>"C:\xampp\apache\conf\extra\httpd-vhosts.conf"
````
<VirtualHost *:80>
ServerName ecf-media.localhost
DocumentRoot "C:\Users\Dell\Desktop\ecf-blanc-media\public"
DirectoryIndex index.php

	  <Directory "C:\Users\Dell\Desktop\ecf-blanc-media\public">
	      Require all granted
	      FallbackResource /index.php
	  </Directory>
</VirtualHost>
````

Verifiez bien que les chemins ci-dessus correspondent à votre emplacement de dossier (où vous avez fait "git clone") sur votre PC. 
***
Ensuite allumer Xammp, cliquez sur le module Apache, cliquez sur "stop" puis "start" (vous devriez avoir le texte "Apache" souligné en vert).
***
Puis allez sur votre navigateur et tapez : ecf-media.localhost 
***
Vous devriez avoir le message "Hello la team Médiatheque !" affiché :)