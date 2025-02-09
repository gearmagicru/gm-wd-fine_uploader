<?php
/**
 * Этот файл является частью виджета веб-приложения GearMagic.
 * 
 * Пакет английской (британской) локализации.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

return [
    '{name}'        => 'Fine Uploader',
    '{description}' => 'File uploading',

    // Шаблон
    'Drop files here' => 'Drop files here',
    'Select files' => 'Select files',
    'Upload' => 'Upload',
    'Processing dropped files' => 'Processing dropped files...',
    'Close' => 'Close',
    'Сancel' => 'Сancel',
    'Retry' => 'Retry',
    'Delete' => 'Delete',
    'Yes' => 'Yes',
    'No' => 'No',

    // Параметры
    'autoRetryNote' => 'Retrying {retryNum}/{maxAuto}...',
    '{messages}' => [
        'emptyError' => '{file} is empty, please select files again without it.',
        'maxHeightImageError' => 'Image is too tall.',
        'maxWidthImageError' => 'Image is too wide.',
        'minHeightImageError' => 'Image is not tall enough.',
        'minWidthImageError' => 'Image is not wide enough.',
        'minSizeError' => '{file} is too small, minimum file size is {minSizeLimit}.',
        'noFilesError' => 'No files to upload.',
        'onLeave' => 'The files are being uploaded, if you leave now the upload will be canceled.',
        'retryFailTooManyItemsError' => 'Retry failed - you have reached your file limit.',
        'sizeError' => '{file} is too large, maximum file size is {sizeLimit}.',
        'tooManyItemsError' => 'Too many items ({netItems}) would be uploaded. Item limit is {itemLimit}.',
        'typeError' => '{file} has an invalid extension. Valid extension(s): {extensions}.',
        'nsupportedBrowserIos8Safari' 
            => 'Unrecoverable error - this browser does not permit file uploading of any kind due to serious bugs in iOS8 Safari. Please use iOS8 Chrome until Apple fixes these issues.',
        'tooManyFilesError' => 'You may only drop one file',
        'unsupportedBrowser' => 'Unrecoverable error - this browser does not permit file uploading of any kind.'
    ],
    '{text}' => [
        'defaultResponseError' => 'Upload failure reason unknown',
        'fileInputTitle' => 'file input',
        'sizeSymbols' => ['kB', 'MB', 'GB', 'TB', 'PB', 'EB'],
        'formatProgress' => '{percent}% of {total_size}',
        'failUpload' => 'Upload failed',
        'waitingForResponse' => 'Processing...',
        'paused' => 'Paused'
    ]
];