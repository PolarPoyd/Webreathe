# Dashboard IOT simulator
Hello World!
Au cours d'un projet de 6 jours, j'ai développé un dashboard IoT avec Symfony, simulant des mises à jour de données en temps réel toutes les minutes via un Cron job. Durant ce projet, j'ai découvert et intégré Chart.js pour la visualisation des données et approfondi mes compétences en JavaScript et Twig. J'ai également créé une documentation détaillée pour le déploiement sur différents systèmes.
Je suis ravi de partager avec la communauté ce que j'ai appris au cours de cette expérience enrichissante.
---
## Installation
Assurez vous d'avoir Composer et Symfony d'installé sur votre machine. Si vous utilisez un logiciel comme XAMPP ou Laragon, veillez à ce que le projet soit bien dans votre htdocs. Aussi, pensez à démarrer votre serveur local. 
Dans le terminal intégré au projet:
```bash
composer install
```
Création de la BDD: 
```bash
php bin/console doctrine:database:create
```
Mise à jour du schéma de la base:
```bash
php bin/console doctrine:schema:update --force
```
## Configuration Cron Job
Avant de démarrer l'application, nous allons connecter notre commande symfony à un planificateur de tâches. Nous utiliserons sous MacOs et Linux, un cron configuré de sorte à ce que cette commande soit déclenché en arrière plan toutes les minutes, qu'on navigue sur les pages ou non. Sous Windows nous utiliserons le Task Scheduler. 
### MacOS / Linux 
Pour ce faire, nous aurons besoin de 2 informations. 
1 - Le chemin absolu de php sur votre machine. 
Pour information, vous pouvez utiliser cette commande dans le terminal MacOs : 
```bash
which php
```
Vous devez alors avoir des informations ressemblant à "/opt/homebrew/bin/php"
2 - le chemin réel de votre projet. 
Pour information, vous pouvez utiliser cette commande dans le terminal intégré au projet : 
```bash
pwd
```
 Vous devez alors avoir des informations ressemblant à "/Applications/XAMPP/xamppfiles/htdocs/projects/Webreathe"
Nous alons alors effectué une commande semblable à "* * * * * /information/1 /information/2/bin/console app:add-random-data"
Veillez a ce que les chemins correspondent aux informations récupérées juste avant.
- Dans votre terminal: 
```bash
crontab -e
```
- Dans le terminal qui s'ouvre ajoutons le cron: 
( exemple avec les informations de ma machine ) 
```bash
* * * * * /opt/homebrew/bin/php /Applications/XAMPP/xamppfiles/htdocs/projects/Webreathe/bin/console app:add-random-data
```
- Sauvegarder et sortir du terminal cron: 
```bash
:wq
```
- Vous pouvez désormais lancer l'application et tester le projet:
```bash
symfony server:start
```
### Windows
Pour ce faire, nous aurons besoin de 2 informations. 
1 - Le fichier éxécutable php.exe dans votre machine.
Pour information, vous pouvez trouver ce fichier en tapant "php.exe" dans votre barre de tâches puis clique droit "ouvrir l'emplacement du fichier" afin de trouver le chemin exact de votre éxécutable.
 
2 - le chemin réel de votre projet.
Pour information, vous pouvez utiliser cette commande dans le terminal intégré au projet : 
```bash
pwd
```
Maintenant, dans votre barre de tâches recherchez et ouvrez "Planificateur de tâches".
- Dans l'onglet de gauche, cliquez sur "Bibliothèque du planificateur de tâches". 
- Puis, dans l'onglet de droite cliquez sur "Créer une tâche de base"
  
![Image de la configuration sur Windows](https://i.gyazo.com/f50966d70b2d8d7a7cf26c21059b8358.png)
- Donnez un nom et une description à la tâche et cliquez sur suivant.
  
  ![Image de la configuration sur Windows](https://i.gyazo.com/5bfc4a1bc09703f9f5ace262c8177848.png)
- Choisissez "Au démarrage de l'ordinateur" et cliquez sur suivant.
- Choisissez "Démarrer un programme" et cliquez sur suivant.
- Dans le champ "Programme/script" cliquez sur "Parcourir..." et ciblez votre éxécutable "php.exe" que nous avons vu précédemment.
- Dans le champ "Ajouter des arguments (facultatif)" ajoutez ceci :
```bash
bin/console app:add-random-data
```
- Dans le champ "Commencer dans (facultatif)" ajoutez le chemin réel de votre projet que nous avons vu précédemment.
Si vous utilisez le logiciel XAMPP vous devriez avoir quelque chose semblable à ceci :
   ![Image de la configuration sur Windows](https://i.gyazo.com/a075a39a6ee228d3c23386c17c104513.png)
- Cliquez ensuite sur "Suivant"
- Cliquez sur "Terminer"
- Ensuite recherchez votre nouvelle tâche dans la Bibliothèque du planificateur et double cliquez sur celle-ci.
- Dirigez-vous dans l'onglet "Déclencheurs" et cliquez sur "Nouveau". 
- Configurez les paramètres sur "Chaque jour" puis les paramètres avancés comme dans cette image :
 ![Image de la configuration sur Windows](https://i.gyazo.com/4b894b530fc86bc067a0dc6613549a4a.png)
- Puis cliquez sur "Ok".
- Cliquez à nouveau sur "Ok".
- Recherchez à nouveau votre tâche dans la bibliothèque et cliquez dessus.
- Dans l'onglet de droite "Actions" cliquez sur "Exécuter".
  
 ![Image de la configuration sur Windows](https://i.gyazo.com/a2142ee2b9d2733ccd247700931e37cf.png)
Vous pouvez désormais lancer l'application et tester le projet:
```bash
symfony server:start
```

## Infos supplémentaire

### MacOS / Linux
Afin de supprimer le cron job mis en place:
```bash
crontab -r
```

### Windows
Afin de supprimer la tâche mis en place:
- Dans votre barre de tâches, recherchez le planificateur de tâches.
- Dans la bibliothèque, recherchez votre tâche.
- Clique droit dessus, supprimer.

---
