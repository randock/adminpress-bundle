# adminpress-bundle

## Install:

Add stability directives and repository to composer.json project file:
```
"repositories": [
    {
        "type": "git",
        "url": "git@github.com:randock/adminpress-bundle.git"
    }
],
"minimum-stability": "dev",
"prefer-stable": true,
```

Install Package:
```
$ composer require randock/adminpress-bundle
```

Configure Encore Webpack :
```
$ yarn add sass-loader node-sass jquery --dev
```

Copy webpack config file from vendor folder
```
$ cp vendor/randock/adminpress-bundle/src/Resources/webpack.config.js.dist ./webpack.config.js
```
or add these entries to existing config file:
```
.addEntry('adminpress_js', './vendor/randock/adminpress-bundle/src/Resources/assets/adminpress.js')
.addStyleEntry('adminpress_css', './vendor/randock/adminpress-bundle/src/Resources/assets/adminpress.scss')
.addStyleEntry('adminpress_theme', './vendor/randock/adminpress-bundle/src/Resources/assets/scss/colors/blue.scss')
.autoProvidejQuery()
```

Ok, you are now ready to build the assets
```
$ yarn build
```

To use the dashboard template, create a template extending the base one
```
{# templates/base.html.twig #}
{% extends '@RandockAdminPress/base.html.twig' %}
```

And voilà!

Now you can see the base layout in action.

## Customize:
+ [Theme](#theme)
+ [Blocks](#blocks)
+ [Menu](#menu)
+ [Lang](#lang-menu)
+ [Right side panel](#right-side-panel)
+ [Profile menu](#profile-menu)
+ [Notifications Lists](#notifications-lists)

#### Theme
In webpack.config.js, replace the adminpress_theme entry with scss file what you want
```
.addStyleEntry('adminpress_theme', './vendor/randock/adminpress-bundle/src/Resources/assets/scss/colors/dark-red.scss')
```

#### Blocks
+ `page_content` is the content of document, inside the dashboard layout
+ `section_title` will be the visible title of the page
+ `header_css` and `header_js` are located on the header section of html document
+ `inline_js` is the last block before the body tag is closed
+ `header_extras` is the right place to put all meta-tags you need
+ `header_title` is the content of `<title>` tag on header
+ `left_sidebar_user_profile` is the section on top of the left sidebar
+ `right_side_toggle` by default is empty, and is the button or element responsible of toggling the right side panel 
+ `footer` is self explained
+ Other blocks, you can find out on [base template](src/Resources/views/base.html.twig)

#### Menu
All you need to create the left menu, is to create a service implementing `MenuItemProviderInterface`. It has a single 
method `addItems` returning a `Knp\Menu\ItemInterface` as a menu root.

Then, tag the service with `randock_admin_press.main_menu_add_items` and `priority`. 
```
# config/services.yaml

App\Menu\MenuItemProvider\MainMenuItemProvider:
    public: true
    tags:
        - { name: randock_admin_press.main_menu_add_items, priority: 10 }
```

#### Lang Menu
You need to configure routes with `{_locale}` parameter and tells to adminpress-bundle wich locales you want
```
# config/packages/admin_press.yaml

randock_admin_press:
  locales:
    - { code: en, name: US, icon: us }
    - { code: es, name: Spain }
    - { code: cn, name: China }
    - { code: in, name: India }

```

#### Right side panel
Override these two twig blocks
```
{% block right_side_toggle %}
<button class="waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10">
    <i class="ti-settings text-white"></i>
</button>
{% endblock %}

{% block right_sidebar %}
    {% embed "@RandockAdminPress/components/right_sidebar.html.twig" %}
        {% block right_panel_title ''  %}
        {% block right_panel_body %}
        {% endblock %}
    {% endembed %}
{% endblock right_sidebar %}

```

#### Profile menu

Proced in same mode than the main menu. Implements `MenuItemProviderInterface` in one or more services.
These menu items will be separated by visual dividers on profile menu.

Tag the service with `randock_admin_press.profile_menu_add_items` and assign `priority`. 
```
# config/services.yaml

App\Menu\MenuItemProvider\AccountMenuItemProvider:
    public: true
    tags:
        - { name: randock_admin_press.profile_menu_add_items, priority: 20 }
```

#### Notification lists
Notifications lists are shown on top bar. You should implement a provider per each type of notifications you want to get 
in top bar. In example, you can implement a Direc Messages provider, and a Mail Provider. 
They should implement `NotificationProviderInterface`. Priority indicates the order in which will be shown.

```
App\Notification\DmNotificationProvider:
    public: true
    tags:
        - { name: randock_admin_press.notification_provider, priority: 10 }

App\Notification\MailNotificationProvider:
    public: true
    tags:
        - { name: randock_admin_press.notification_provider, priority: 20 }
```

# Family Icons

#### Main Menu
Main menu item accept an extra parameter named icon. This value should be a mdi icon name, listed [Material Design Icons](https://dev.materialdesignicons.com/icons)
```
$apps = $menu->addChild('Apps', ['extras' => ['icon' => 'bullseye']]);
```

Country Flag icons comes from [Flag Icon CSS](http://flag-icon-css.lip.is/). If no icon is especified, Locale code 
are use to determine which will be used.

#### Lang Menu
```
randock_admin_press:
  locales:
    - { code: en, name: US, icon: us }
    - { code: es, name: Spain }
```

#### Profile Menu
Same as Main Menu, but [Themify Icons](http://ws-infinity.ws-theme.com/index.php/features/icons-themify) used here
```
$menu->addChild('Logout', ['uri' => '/logout', 'extras' => ['icon' => 'power-off']]);
```

#### Notifications Icons
[Material Design Icons](https://dev.materialdesignicons.com/icons), same as Main Menu


# Develop:
Create a new clean project
```
$ composer create-project symfony/skeleton mybackend
```

install dependences
```
$ cd mybackend
$ composer require knplabs/knp-menu-bundle symfony/translation symfony/twig-bundle symfony/validator symfony/webpack-encore-bundle

```
 
Clone repo in a symfony working project, inside `lib/` folder
```
$ mkdir lib
$ cd lib
$ git clone git@github.com:randock/adminpress-bundle.git
```

Add namespace to class loader
```
# composer.json

"autoload-dev": {
    "psr-4": {
        ...
        "Randock\\AdminPressBundle\\": "lib/adminpress-bundle/src/"
        ...
    }
},
```
At the root folder of project, rebuild autoload class
```
# inside root project folder
$ composer dump-autoload
```

You can run validation, code fixing and phpqa by running inside de repo folder
```
$ composer install
$ ant validate
$ ant fix
$ ant phpqa
```


#### Get running inside the project

Instance the bundle
```
# config/bundles.php

return [
    ...
    Randock\AdminPressBundle\RandockAdminPressBundle::class => ['all' => true],
    ...
];
```


Then, proceed with encore and template configuration as was explained at top of this document. You should change the 
path to entry files replacing `./vendor/randock` by `./lib` and enabling sass
```
.addEntry('adminpress_js', './lib/adminpress-bundle/src/Resources/assets/adminpress.js')
.addStyleEntry('adminpress_css', './lib/adminpress-bundle/src/Resources/assets/adminpress.scss')
.addStyleEntry('adminpress_theme', './lib/adminpress-bundle/src/Resources/assets/scss/colors/blue.scss')
.autoProvidejQuery()
.enableSassLoader()
```

Run dev-server. You may have some issues running inside a docker container. For better experience, run it on the local  machine
```
$ yarn install
$ yarn dev-server
```
