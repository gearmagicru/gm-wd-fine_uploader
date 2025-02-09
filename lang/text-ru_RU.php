<?php
/**
 * Этот файл является частью виджета веб-приложения GearMagic.
 * 
 * Пакет русской локализации.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

return [
    '{name}'        => 'Fine Uploader',
    '{description}' => 'Загрузчик файлов',

    // Шаблон
    'Drop files here' => 'Перетащите файлы сюда',
    'Select files' => 'Выбрать файлы',
    'Upload' => 'Загрузить',
    'Processing dropped files' => 'Обработка брошенных файлов...',
    'Close' => 'Закрыть',
    'Сancel' => 'Отмена',
    'Retry' => 'Повторить',
    'Delete' => 'Удалить',
    'Yes' => 'Да',
    'No' => 'Нет',

    // Параметры
    'autoRetryNote' => 'Повторная попытка {retryNum}/{maxAuto}...',
    '{messages}' => [
        'emptyError' => '{file} пуст, пожалуйста, выберите файлы еще раз без него.',
        'maxHeightImageError' => 'Изображение слишком высокое.',
        'maxWidthImageError' => 'Изображение слишком широкое.',
        'minHeightImageError' => 'Изображение недостаточно высокое..',
        'minWidthImageError' => 'Изображение недостаточно широкое.',
        'minSizeError' => '{file} слишком мал, минимальный размер файла — {minSizeLimit}.',
        'noFilesError' => 'Нет файлов для загрузки.',
        'onLeave' => 'Файлы загружаются, если вы сейчас покинете загрузку, она будет отменена..',
        'retryFailTooManyItemsError' => 'Повторная попытка не удалась — вы достигли лимита файлов.',
        'sizeError' => '{file} слишком большой, максимальный размер файла — {sizeLimit}.',
        'tooManyItemsError' => 'Слишком много элементов ({netItems}) будет загружено. Лимит элементов — {itemLimit}.',
        'typeError' => '{file} имеет недопустимое расширение. Допустимые расширения: {extensions}.',
        'nsupportedBrowserIos8Safari' 
            => 'Неустранимая ошибка - этот браузер не позволяет загружать файлы любого рода из-за серьезных ошибок в iOS8 Safari. Пожалуйста, используйте iOS8 Chrome, пока Apple не исправит эти проблемы.',
        'tooManyFilesError' => 'Вы можете перетащить только один файл.',
        'unsupportedBrowser' => 'Неустранимая ошибка — этот браузер не разрешает загрузку файлов.'

    ],
    '{text}' => [
        'defaultResponseError' => 'Причина сбоя загрузки неизвестна',
        'fileInputTitle' => 'входной файл',
        'sizeSymbols' => ['кБ', 'МБ', 'ГБ', 'ТБ', 'ПБ', 'ЕБ'],
        'formatProgress' => '{percent}% из {total_size}',
        'failUpload' => 'Загрузка не удалась',
        'waitingForResponse' => 'Обработка...',
        'paused' => 'На паузе'
    ]
];
