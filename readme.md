
# Robots and Sitemap generator package

This package will help you to create a robots.txt file and a sitemap with all the get routes of your application on the fly.

## Getting Started

### Installation

Install via Composer.
 
```
composer require mtz-jaime/robots-sitemap
```

If you are using Laravel 5.5 this package already includes the auto discovery package. 
If for some reason you decided to remove this functionality on your application, add the service provider into your application config. 

Do this by adding the following line to the 'providers' section of the application config (usually config/app.php):

```
MtzJaime\RobotsSitemap\RobotsSitemapServiceProvider::class,
```

Publish the config file in order to have control to decide what to block in your robots or sitemap
```
php artisan vendor:publish --provider="MtzJaime\RobotsSitemap\RobotsSitemapServiceProvider" --tag="config"
```

## Code Usage

To enable the package features you need to add this new env variable ```BLOCK_SITE=false```

Configure the config file as better fit under your requirements.

    'disallowURL' => 
    [
        /mySecretPost
        /mySecretFolder/
    ],

    'userAgent' => 
    [
        'AgentName' => ['/', '/mySecretFolder/', '/mySecretPost']
    ],

    'excludeSiteMap' => 
    [
        // Do not include the initial '/'
        mySecretFolder/mySecretPost
        mySecretPost
    ],

Before trying to access the robots.txt be sure that you already delete the default robots.txt file that Laravel provide in public/robots.txt

If you already deleted it and you get an 404 error, remove the following line from your nginx file or similar in apache
```
location = /robots.txt  { access_log off; log_not_found off; }
```