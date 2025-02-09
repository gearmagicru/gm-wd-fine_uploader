# <img src="https://raw.githubusercontent.com/gearmagicru/gm-wd-fancybox/refs/heads/master/assets/images/icon.svg" width="64px" height="64px" align="absmiddle"> Виджет загрузчика "Fine Uploader"

Загрузчик файлов Fine Uploader, поддерживает все основные браузеры и не требует Flash, jQuery или каких-либо внешних библиотек.

## Пример применения
### с менеджером виджетов:
```
$lightbox = Gm::$app->widgets->get('gm.wd.fancybox', ['width' => 600, 'height' => 400]);
$lightbox->run();
```
### в шаблоне:
```
$this->widget('gm.wd.fancybox', ['width' => 600, 'height' => 400])->run();
```
### с namespace:
```
use Gm\Widget\Fancybox\Widget as Lightbox;
Lightbox::widget(['width' => 600, 'height' => 400])->run();
```
если namespace ранее не добавлен в PSR, необходимо выполнить:
```
Gm::$loader->addPsr4('Gm\Widget\Fancybox\\', Gm::$app->modulePath . '/gm/gm.wd.fancybox/src');
```

## Установка

Для добавления виджета в ваш проект, вы можете просто выполнить команду ниже:

```
$ composer require gearmagicru/gm-wd-fine_uploader
```

или добавить в файл composer.json вашего проекта:
```
"require": {
    "gearmagicru/gm-wd-fine_uploader": "*"
}
```

После добавления виджета в проект, воспользуйтесь Панелью управления GM Panel для установки его в редакцию вашего веб-приложения.

## Ресурсы
- [Сайт Fine Uploader](https://fineuploader.com/)
- [Документация Fine Uploader](https://docs.fineuploader.com/)