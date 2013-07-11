Installation de Museo
=====
1. Importer tout le dossier dans /wamp/www/museo/
2. Créer la base "museo" dans phpmyadmin
3. Importer le fichier SQL du dossier /install dedans
4. Configurer dans config.php les accès de votre phpmyadmin

### Configuration Apache requise :
Il faut activer les modules (clic droit sur wamp puis Apache dans la barre des tâches) :
* mod_expires
* mod_headers
* mod_rewrite

### Configuration PHP 
clic droit sur wamp puis PHP dans la barre des tâches:
* short open tag

