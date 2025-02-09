<?php
/**
 * Виджет веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Widget\FineUploader;

use Gm;
use Gm\View\ClientScript;
use Gm\View\WidgetResourceTrait;

/**
 * Виджет "Fine Uploader".
 * 
 * @link https://fineuploader.com/
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Widget\FineUploader
 * @version 5.16.2
 */
class Widget extends \Gm\View\BaseWidget
{
    use WidgetResourceTrait;

    /**
     * @var string Символ начала JS скрипта в строке.
     */
    const SYMBOL_SCRIPT = ':';

    /**
     * Шаблон интерфейса виджета, ссылается на: идентификатор HTML элемента, HTML 
     * элемент (JS), название шаблона.
     * 
     * Если название шаблона, то будет вызван метод виджета "<template>Template".
     * 
     * @var string
     */
    public string $template = '';

    /**
     * Идентификатор HTML элемента, куда выводится список загружаемых файлов.
     * 
     * @var string
     */
    public string $elementId = '';

    /**
     * Идентификатор DOM кнопки, загрузки файлов.
     * 
     * @var string
     */
    public string $buttonUloadId = 'btn-upload';

    /**
     * Добавить JS скрипт триггера  кнопки загрузки файлов (если кнопка отображается).
     * 
     * @see Widget::getScript()
     * 
     * @var bool
     */
    public bool $useTriggerUpload = true;

    /**
     * URL-адрес загрузки файлов.
     * 
     * @see Widget::addRequestParam()
     * 
     * @var string
     */
    public string $uploadUrl = '';

    /**
     * Если значение `false`, то элементы из очереди можно загрузить позже, вызвав 
     * метод JS uploadStoredFiles().
     * 
     * @var bool
     */
    public bool $autoUpload = false;

    /**
     * Запись сообщений журнала в объект window.console.
     * 
     * @var bool
     */
    public bool $debug = true;

    /**
     * Параметры запроса.
     * 
     * Например:
     * ```php
     * [
     *     'customHeaders'      => [], // дополнительные заголовки отправляются вместе с каждым запросом на загрузку
     *     'endpoint'           => '/server/upload', // конечная точка для отправки запросов на загрузку
     *     'filenameParam'      => 'qqfilename', // имя параметра, передаваемого, если исходное имя файла было отредактировано или отправляется Blob
     *     'forceMultipart'     => true, // принудительно использовать многокомпонентное кодирование для всех загрузок
     *     'inputName'          => 'qqfile', // атрибут элемента ввода, который будет содержать имя файла
     *     'method'             => 'POST', // метод используемый при отправке файлов на традиционную конечную точку
     *     'omitDefaultParams'  => false, // если установлено значение true, никакие созданные параметры (qq*) не будут отправляться с запросом на загрузку
     *     'params'             => [], // параметры, которые должны отправляться с каждым запросом на загрузку
     *     'paramsInBody'       => true, // включить / отключить отправку параметров в теле запроса
     *     'requireSuccessJson' => true, // если значение true, то каждый ответ на загрузку должен содержать тело сообщения JSON с {success: true}
     *     'uuidName'           => 'qquuid', // имя параметра, уникально идентифицирующего каждый связанный элемент
     *     'totalFileSizeName'  => 'qqtotalfilesize' // имя переданного параметра, указывающего общий размер файла в байтах
     * ]
     * ```
     * 
     * @link https://docs.fineuploader.com/branch/master/api/options.html#request
     * 
     * @var array<string, mixed>
     */
    public array $request = [];
    
    /**
     * @var array
     */
    public array $thumbnails = [];

    /**
     * При значении true Fine Uploader будет обеспечивать появление модального 
     * диалогового окна подтверждения всякий раз, когда пользователь пытается уйти 
     * со страницы, на которой выполняется загрузка.
     * 
     * @var bool
     */
    public bool $warnBeforeUnload = true;

    /**
     * Если задано значение `false`, пользователь не сможет одновременно выбирать 
     * или отбрасывать более одного элемента.
     * 
     * @var bool
     */
    public bool $multiple = true;

    /**
     * Максимально допустимое количество одновременных запросов.
     * 
     * @var int
     */
    public int $maxConnections = 3;

    /**
     * Если задано значение `true`, ссылка отмены не отображается рядом с файлами 
     * при использовании загрузчика форм.
     * 
     * @var bool
     */
    public bool $disableCancelForFormUploads = false;

    /**
     * Повторная попытка загрузки.
     * 
     * Включение повторной загрузки, например:
     * ```php
     * [
     *     'enableAuto' => true
     * ]
     * ```
     * 
     * @link https://docs.fineuploader.com/branch/master/api/options.html#retry
     * 
     * @var array<string, mixed>
     */
    public array $retry = ['enableAuto' => true];

    /**
     * Удаление файлов.
     * 
     * Если пользователь загрузил файл, но понял, что это была ошибка, прежде чем 
     * отменить загрузку, можно удалить файлы. Fine Uploader поддерживает удаление 
     * файлов через POST, DELETE, например:
     * ```php
     * [
     *     'enabled'  => true,
     *     'endpoint' => '/my/delete/endpoint'
     * ]
     * ```
     * 
     * @link https://docs.fineuploader.com/branch/master/api/options.html#deleteFile
     * 
     * @var array<string, mixed>
     */
    public array $deleteFile = [];

    /**
     * Проверка файлов перед загрузкой.
     * 
     * Например:
     * ```php
     * [
     *     'acceptFiles'       => null, // ограничеть допустимые типы файлов, отображаемые в диалоговом окне выбора
     *     'allowedExtensions' => [], // допустимые расширения файлов
     *     'allowEmpty'        => false, // допустимый размер файла 0 байт
     *     'itemLimit'         => 0, // максимальное количество элементов, которые могут быть загружены в сеансе
     *     'minSizeLimit'      => 0, // минимально допустимый размер элемента в байтах
     *     'sizeLimit'         => 0, // максимально допустимый размер элемента в байтах
     *     'stopOnFirstInvalidFile' => true, // Если значение true, то первый недействительный элемент остановит обработку дальнейших файлов
     * ]
     * ```
     * 
     * @link https://docs.fineuploader.com/branch/master/api/options.html#validation
     * 
     * @var array
     */
    public array $validation = [];

    /**
     * Флаги, которые включают или отключают обходные пути для ошибок, специфичных 
     * для браузера.
     * 
     * Например:
     * ```php
     * [
     *     'iosEmptyVideos'    => true,
     *     'ios8BrowserCrash'  => false,
     *     'ios8SafariUploads' => true
     * ]
     * ```
     * 
     * @var array
     */
    public array $workarounds = [];

    /**
     * Локализация сообщений.
     * 
     * @link https://docs.fineuploader.com/branch/master/api/options.html#messages
     * 
     * @var array
     */
    public array $messages = [];

    /**
     * Локализация текста.
     * 
     * @link https://docs.fineuploader.com/branch/master/api/options.html#text
     * 
     * @var array
     */
    public array $text = [];

    /**
     * События.
     * 
     * @link https://docs.fineuploader.com/branch/master/api/events.html
     * 
     * @var array
     */
    public array $callbacks = [];

    /**
     * Параметры скрипта, которые будут переданы в JavaScript.
     * 
     * @see Widget::addScriptParam()
     * 
     * @var array<int, string>
     */
    private array $scriptParams = [];

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        $this->initTranslations();

        if (empty($this->elementId)) {
            $this->elementId = uniqid();
        }

        $url = $this->getAssetsUrl();

        // fineuploader
        Gm::$app->clientScript
            ->appendPackage('fineuploader', [
                'position' => ClientScript::POS_HEAD,
                'js'       => ['fine-uploader.js'      => [$url . '/dist/fine-uploader.js']],
                'css'      => ['fine-uploader-new.css' => [$url . '/dist/css/fine-uploader-new.css']]
            ])
            ->registerPackage('fineuploader')
            ->registerJs($this->getScript(), ClientScript::POS_END, 'fineuploader');

        // если указан шаблон
        if ($text = $this->getTemplateText()) {
            Gm::$app->clientScript
                ->registerJs($text, ClientScript::POS_HEAD, 'template', ['type' => 'text/template', 'id' => $this->template]);
        }
    }


    /**
     * Шаблон интерфейса виджета.
     * 
     * Если свойство {@see Wdiget::$template} имеет значение 'trigger'.
     *
     * @return string
     */
    protected function triggerTemplate(): string
    {
        return <<<"FOOBAR"
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="{$this->t('Drop files here')}">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="buttons">
            <div class="qq-upload-button-selector qq-upload-button">
                <div>{$this->t('Select files')}</div>
            </div>
            <button type="button" id="{$this->buttonUloadId}" class="qq-upload-button">
                <i class="icon-upload icon-white"></i> {$this->t('Upload')}
            </button>
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing">
            <span>{$this->t('Processing dropped files')}</span>
            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
        </span>
        <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
            <li>
                <div class="qq-progress-bar-container-selector">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                <span class="qq-upload-file-selector qq-upload-file"></span>


                <span class="qq-upload-size-selector qq-upload-size"></span>
                <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">{$this->t('Сancel')}</button>
                <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">{$this->t('Retry')}</button>
                <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">{$this->t('Delete')}</button>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
            </li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector qq-button">{$this->t('Close')}</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector qq-button">{$this->t('No')}</button>
                <button type="button" class="qq-ok-button-selector qq-button">{$this->t('Yes')}</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector qq-button">{$this->t('Сancel')}</button>
                <button type="button" class="qq-ok-button-selector qq-button">Ok</button>
            </div>
        </dialog>
    </div>
    FOOBAR;
    }

    /**
     * Добавляет параметр "thumbnails" для передачи в JavaScript.
     * 
     * @return static
     */
    protected function addThumbnailsParam(): static
    {
        if (empty($this->thumbnails['placeholders'])) {
            $this->thumbnails['placeholders'] = [];
        }
        if (empty($this->thumbnails['placeholders']['waitingPath'])) {
            $this->thumbnails['placeholders']['waitingPath'] = $this->getAssetsUrl() . '/images/placeholders/waiting-generic.png';
        }
        if (empty($this->thumbnails['placeholders']['notAvailablePath'])) {
            $this->thumbnails['placeholders']['waitingPath'] = $this->getAssetsUrl() . '/images/placeholders/not_available-generic.png';
        }
        return $this->addScriptParam('thumbnails', $this->thumbnails);
    }

    /**
     * Добавляет параметр "request" для передачи в JavaScript.
     * 
     * @return static
     */
    protected function addRequestParam(): static
    {
        if (empty($this->request['endpoint'])) {
            $this->request['endpoint'] = $this->uploadUrl;
        }
        return $this->addScriptParam('request', $this->request);
    }

    /**
     * Добавляет параметр "element" для передачи в JavaScript.
     * 
     * @return static
     */
    protected function addElementParam(): static
    {
        return $this->addScriptParam('element', ":document.getElementById('{$this->elementId}')");
    }

    /**
     * Добавляет параметр "messages" для передачи в JavaScript.
     * 
     * @return static
     */
    protected function addMessagesParam(): static
    {
        return $this->addScriptParam('messages', array_merge($this->t('{messages}'), $this->messages));
    }

    /**
     * Добавляет параметр "text" для передачи в JavaScript.
     * 
     * @return static
     */
    protected function addTextParam(): static
    {
        return $this->addScriptParam('text', array_merge($this->t('{text}'), $this->text));
    }

    /**
     * Добавляет параметр "retry" для передачи в JavaScript.
     * 
     * @return static
     */
    protected function addRetryParam(): static
    {
        return $this->addScriptParam(
            'retry', 
            array_merge([
                'showAutoRetryNote' => true,
                'autoRetryNote'     => $this->t('autoRetryNote')
            ], $this->retry)
        );
    }

    /**
     * Добавляет параметр "callbacks" для передачи в JavaScript.
     * 
     * @return static
     */
    protected function addCallbacksParam(): static
    {
        if (empty($this->callbacks)) return $this;

        $value = [];
        foreach ($this->callbacks as $name => $script) {
            $value[] = $name . ': ' . $script;
        }
        return $this->addScriptParam(
            'callbacks', 
            self::SYMBOL_SCRIPT . '{' . implode(', ', $value) . '}'
        );
    }

    /**
     * Добавляет параметр "retry" для передачи в JavaScript.
     * 
     * @return static
     */
    protected function addTemplateParam(): static
    {

        return $this->addScriptParam(
            'template', 
            array_merge([
                'showAutoRetryNote' => true,
                'autoRetryNote'     => $this->t('autoRetryNote')
            ], $this->retry)
        );
    }

    /**
     * Добавляет параметры для передачи в JavaScript.
     * 
     * @param string $name Имя параметра.
     * @param mixed $value Значение параметра.
     * 
     * @return static
     */
    protected function addScriptParam(string $name, mixed $value): static
    {
        if (is_bool($value))
            $value = $value ? 'true' : 'false';
        else
        if (is_string($value)) {
            if ($value) {
                if (strncmp($value, self::SYMBOL_SCRIPT, 1) === 0)
                    $value = mb_substr($value, 1);
                else
                    $value = "'$value'";
            } else
                return $this;
        } else
        if (is_array($value)) {
            if ($value) 
                $value = json_encode($value);
            else
                return $this;
        }

        $this->scriptParams[] = $name . ': ' . $value;
        return $this;
    }

    /**
     * Собирает параметры виджета для передачи в JavaScript.
     * 
     * @return string
     */
    protected function scriptParamsToString(): string
    {
        return implode(', ', $this->scriptParams);
    }

    /**
     * Возвращает JavaScript виджета.
     * 
     * @return string
     */
    public function getScript(): string
    {
        $this
            ->addElementParam()
            ->addScriptParam('template', $this->template)
            ->addRequestParam()
            ->addThumbnailsParam()
            ->addScriptParam('autoUpload', $this->autoUpload)
            ->addScriptParam('deleteFile', $this->deleteFile)
            ->addRetryParam()
            ->addScriptParam('debug', $this->debug)
            ->addScriptParam('multiple', $this->multiple)
            ->addScriptParam('warnBeforeUnload', $this->warnBeforeUnload)
            ->addScriptParam('maxConnections', $this->maxConnections)
            ->addScriptParam('validation', $this->validation)
            ->addScriptParam('workarounds', $this->workarounds)
            ->addMessagesParam()
            ->addTextParam()
            ->addScriptParam('disableCancelForFormUploads', $this->disableCancelForFormUploads)
            ->addCallbacksParam();
            
        $text = 'let manualUploader = new qq.FineUploader({' . $this->scriptParamsToString() . '}); ';
        if ($this->useTriggerUpload) {
            $text .= 'qq(document.getElementById("' . $this->buttonUloadId . '")).attach("click", function() { manualUploader.uploadStoredFiles(); });';
        }
        return $text;
    }

    /**
     * Проверяет, является ли указанный параметр "Шаблон" именем метода виджета.
     * 
     * @return bool
     */
    protected function isTemplateFunc(): bool
    {
        return $this->template ? method_exists($this, $this->template . 'Template') : false;
    }

    /**
     * Проверяет, является ли указанный параметр "Шаблон" идентификатором HTML элемента.
     * 
     * @return bool
     */
    protected function isTemplateId(): bool
    {
        return $this->template ? (!$this->isTemplateElement() && $this->isTemplateFunc()) : false;
    }

    /**
     * Проверяет, является ли указанный параметр "Шаблон" HTML элементом.
     * 
     * @return bool
     */
    protected function isTemplateElement(): bool
    {
        return strncmp($this->template, self::SYMBOL_SCRIPT, 1) === 0;
    }

    /**
     * Возвращает текст шаблона виджета.
     * 
     * @return string
     */
    protected function getTemplateText(): string
    {
        if ($this->isTemplateFunc()) {
            $name = $this->template . 'Template';
            return $this->$name();
        }
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function run(): mixed
    {
        return '<div id="' . $this->elementId . '" class="qq-container"></div>' . "\r\n";
    }
}