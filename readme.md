# Wordpress Dev Shell

Wordpress development environment

## Features.

- Runs on Docker environment
- BitBucket pipelines file setup for configuration with WP Engine
- NPM shortcuts for quick utilisation of environment
- Connection to WPE to pull latest data locally

## Local Development TEMPLATE DOCUMENTATION

### Setup

#### Requirements

- Docker
- NPM
- Gulp

#### Steps

1) Clone repo
2) Log onto the FTP (Details in Last Pass) and download the `uploads` folder
3) Run `npm i` to obtain Node modules required for the project
4) Add the local SSL self-signed certificate to the approved list of certs
    a) **On Mac**: Open `Keychain Access`, click on `System` then the `Certificates` category. Drag in `_dev/certs/server.key` and add it to the list. Double click the certificate in the list, open the `Trust` accordion and set the first dropdown to `Always Trust`.
4) Follow steps below to start developing.

### Branch management

The site uses CI/CD (more detail below) and relies on specific branches. Because of this, we much ensure all branches are up to date. From a local standpoint:
- **master** branch is the source of truth and should always match what the live environment is running off.
- **##dev-branch-name##** checkout development branches to develop new features for the site, with the intention to merge with *master*

### Get Started developing

Make sure you have pulled the latest from GIT, then:
```ssh
npm run up
```
This will spin up the docker environment, making the site accessible via https://localhost. Following that, the DB will be updated with what is on GIT. Finally, it will start Gulp which will watch for changes to your SASS and JS files for compiling.

### Track error logs

Make sure you have replaced `"name": "matter-theme"` by your project name in `package.json`, then:
```ssh
npm run logs
```
Also you can use following command as well `docker logs -f YOUR_WORDPRESS_CONTAINER` or `docker logs -f YOUR_WORDPRESS_CONTAINER | grep "php7:error"`.

### WP Shell

Opens an interactive PHP console for running and testing PHP code.
```ssh
# Call get_bloginfo() to get the name of the site.
$ npm run wpshell
wp> get_bloginfo('name');
=> string(6) "Wordpress Dev SHell"
```
`wp shell` allows you to evaluate PHP statements and expressions interactively, from within a WordPress environment. Type a bit of code, hit enter, and see the code execute right before you. Because WordPress is loaded, you have access to all the functions, classes and globals that you can use within a WordPress plugin, for example.

### Finish developing

Its imperitive for both the project and your machine that you run the following:
```ssh
npm run down
```
This command will back the database up to file, retaining changes you make to the admin. Following that, it will spin down the docker container made for the project. Once complete, you're safe to commit your changes.


## WP Engine environment

Public facing site is hosted on WP Engine and uses its environments for testing and processing the go-live sequence. The database content disconnects between local and WP Engine. If content present in WP Engine is required locally for development, obtain a copy of the live DB and save the SQL file in the /db/ folder of the project as `backup.sql`.

### General process

To ensure successful testing of work before it goes live, its important to make sure the environment that your pushing to has the latest content and live files (uploads, etc). To do this, log into the WP Engine admin (details in Last Pass) and copy from Production to the environment you're about to build to.

### SSH Setup

Login to WP Engine, or get in contact with someone that has access if you don't, and add your SSH key to the production environment. This will allow you to pull and push data from and to the WPE environment via GIT.

### Setup initial environment and BitBucket Pipelines connection

To eliminate some of the process time in getting files from local to WPE, we utilise BitBucket Pipelines to do some of the heavy lifting for us. To get this connection created, follow the below steps:

1) Create an account in WP Engine for the project.
2) Update the `package.json` file, replacing `client` with the name of the project in the following commands:
    - wpe
    - pull-db
    - localise-db
    - obtain-uploads
3) Update the `bitbucket-pipelines.yml` file, replacing `ENVIRONMENT` with the WP Engine project name slug.
4) In BitBucket, navigate to the settings of the project, then to the `Pipelines Settings` and `Enable Pipelines`.
5) Move to the `Pipelines SSH keys` and `Generate new keys`. This will provide you with a public key for BitBucket. Copy this key.
6) Add `git.wpengine.com` to the `Known hosts` and click `Fetch` then `Add`.
7) In WP Engine, navigate to the project, and open the `Git push` page. Enter `bitbucket` as the developer name and paste the BitBucket public key that was copied above then click Add.
8) Waiting 10 minutes, pushing to BitBucket will now trigger a push to the WP Engine environment.

If you have an existing local build and are moving it to a WP Engine environment, the following steps need to be taken:

1) Duplicate the `/db/backup.sql` file for the project and 

### Updating content from production

To ensure we're working on the latest and greatest, there are commands that can be run on the environment to obtain this content. These include the 2 areas that get most out of sync - the database and the uploads folder.
The database is synced from production by default in the `npm run up` command, however if you require the need to pull this independently from the start-up, you can run:
```ssh
npm run pull-db
```
This command will download the latest backed up version of the production database. To then make the file relevant to your local environment, use:
```ssh
npm run localise-db
```
This essentially changes all references to the production URL and changes to the localhost path.

To get a latest copy of the files that have been uploaded to production to match the data in the database, use:
```ssh
npm run obtain-uploads
```
This runs an rsync command and checks against your local environment before running a download. This means that if you regularly use this, the sync wont take long. If this is the first time running it, expect this to take a good chunk of time.

### Branch / Environment map

CI/CD is setup in BitBucket Pipelines to detect pushes to certain branches and update the relevant WP Engine environment. The map of this is as follows:
- **wpe-develop** branch builds to *production/##TBD##*
- **wpe-staging** branch builds to *production/##TBD##*
- **wpe-production** branch builds to *production/##TBD##*

These branches should only be updated and merge to using the *master* branch.

### Slack Notifications

So we're notified when builds are pushing to WP Engine, connect BitBucket up to a corresponding Slack room, dedicated for these notifications. We should prepend the room names with `bb-` and the project name so that others in the team can subscribe to the room if they are working on it.

To do this:
1) Create the room in slack
2) Navigate to the project in BitBucket and open `Settings`
3) Open the `Chat Notification Settings` at the bottom of the menu
4) Click on `Add Subscription` and select the room you created
5) Remove everything from `Repository-wide` notifications
6) Leave `commits pushed` and `branch merged` on `master`
7) Add `wpe-production`, `wpe-staging` and `wpe-develop` all with:
   - `commits pushed`
   - `branch merged`
   - `pipeline failed`
   - `pipeline succeeded`
   - `pipeline fixed`

### Pushing live

Before we can push any code to WP Engine, we need to backup production and update the development environment to triple check our changes before moving live.

To do this, log into the WP Engine admin and run a backup of the production environment, ensuring you update the notification to your email so you know when it completes. Once you have been notified, you can proceed to `Copy to` the `development` environment via the menu in the top right. When moving from `Production` to `Development`, copy the database as well. This will ensure you are testing with the latest content. Again, ensure you add your email to be notified upon completion.

After being inform of the copy successfully completing, you can proceed to merge `master` into `wpe-develop` and push the branch. This kicks off the push of the files to WP Engine - check in with BitBucket Pipelines on the Hestan Culinary project to check its status.

Upon successful completion of the commit and build to WP Engine, you can check the `##TBD##.wpengine.com` environment for your changes. With these all being correct, you can begin the push back to production.

To do this, you need to create a backup point to copy from in the `Development` environment. Once this is complete, proceed to `Copy to` the `Production` environment, however this time, it is **imperative** that you **do not** copy the database as well, therefore only pushing the filesystem. This is because there is chance the client has made updates to the admin between the backup you created on production to the time you are proceeding with this copy.

Completion of this copy to production completes the process of moving changes to the live environment.