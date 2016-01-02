# Javascript instalation
Put below code befor ```</body>``` tag
```js
<script>
    (function(i){var d=document;var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='http://inz.tums.pl/js/statisticapp.js';var w=window; w.statisticApp=i;var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);
    })({
        appId: "your app id",
        userKey: "unique user key", // Uniq user identificator (email or id)
    });
</script>
```

# PHP instalation
Instal script via composer
```dcl
composer require emsoft/statisticapp dev-master
```
Create instance of StatisticApp
```php
use Emsoft\StatisticAppBundle\StatisticApp;
// ...
$statisticApp = new StatisticApp('your app id');
```

Before each request run below code
```php
use Emsoft\StatisticAppBundle\StatisticMessage;
// ...
$message = new StatisticMessage("unique user key"); // Uniq user identificator (email or id)
$statisticApp->send($message);
```

# Symfony instalation

Instal script via composer
```dcl
composer require emsoft/statisticapp dev-master
```
Put app id into config parameters
```yml
parameters:
    locale: pl
    statisticAppId: asd
```

Create statistic event listener
```php
<?php
namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Emsoft\StatisticAppBundle\StatisticApp;
use Emsoft\StatisticAppBundle\StatisticMessage;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;

class StatisticListener
{

    /**
     * @var ContainerInterface
     */
    private $container;
    private $statisticApp;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->statisticApp = new StatisticApp($container->getParameter('statisticAppId'));
    }
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }

        foreach ($controller as $co)
        {
            if ($co instanceof ProfilerController) {
                return;
            }
        }
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $message = new StatisticMessage($user->getId());
        $this->statisticApp->send($message);
    }

}
```

Add event listener to service config
```yml
app.statistic.action_listener:
    class: AppBundle\EventListener\StatisticListener
    arguments: [ @service_container ]
    tags:
        - { name: kernel.event_listener, event: kernel.controller, method: onKernelController }
```


