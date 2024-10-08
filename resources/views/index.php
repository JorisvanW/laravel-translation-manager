<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Translation Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script>//https://github.com/rails/jquery-ujs/blob/master/src/rails.js
        (function(e,t){if(e.rails!==t){e.error("jquery-ujs has already been loaded!")}var n;var r=e(document);e.rails=n={linkClickSelector:"a[data-confirm], a[data-method], a[data-remote], a[data-disable-with]",buttonClickSelector:"button[data-remote], button[data-confirm]",inputChangeSelector:"select[data-remote], input[data-remote], textarea[data-remote]",formSubmitSelector:"form",formInputClickSelector:"form input[type=submit], form input[type=image], form button[type=submit], form button:not([type])",disableSelector:"input[data-disable-with], button[data-disable-with], textarea[data-disable-with]",enableSelector:"input[data-disable-with]:disabled, button[data-disable-with]:disabled, textarea[data-disable-with]:disabled",requiredInputSelector:"input[name][required]:not([disabled]),textarea[name][required]:not([disabled])",fileInputSelector:"input[type=file]",linkDisableSelector:"a[data-disable-with]",buttonDisableSelector:"button[data-remote][data-disable-with]",CSRFProtection:function(t){var n=e('meta[name="csrf-token"]').attr("content");if(n)t.setRequestHeader("X-CSRF-Token",n)},refreshCSRFTokens:function(){var t=e("meta[name=csrf-token]").attr("content");var n=e("meta[name=csrf-param]").attr("content");e('form input[name="'+n+'"]').val(t)},fire:function(t,n,r){var i=e.Event(n);t.trigger(i,r);return i.result!==false},confirm:function(e){return confirm(e)},ajax:function(t){return e.ajax(t)},href:function(e){return e.attr("href")},handleRemote:function(r){var i,s,o,u,a,f,l,c;if(n.fire(r,"ajax:before")){u=r.data("cross-domain");a=u===t?null:u;f=r.data("with-credentials")||null;l=r.data("type")||e.ajaxSettings&&e.ajaxSettings.dataType;if(r.is("form")){i=r.attr("method");s=r.attr("action");o=r.serializeArray();var h=r.data("ujs:submit-button");if(h){o.push(h);r.data("ujs:submit-button",null)}}else if(r.is(n.inputChangeSelector)){i=r.data("method");s=r.data("url");o=r.serialize();if(r.data("params"))o=o+"&"+r.data("params")}else if(r.is(n.buttonClickSelector)){i=r.data("method")||"get";s=r.data("url");o=r.serialize();if(r.data("params"))o=o+"&"+r.data("params")}else{i=r.data("method");s=n.href(r);o=r.data("params")||null}c={type:i||"GET",data:o,dataType:l,beforeSend:function(e,i){if(i.dataType===t){e.setRequestHeader("accept","*/*;q=0.5, "+i.accepts.script)}if(n.fire(r,"ajax:beforeSend",[e,i])){r.trigger("ajax:send",e)}else{return false}},success:function(e,t,n){r.trigger("ajax:success",[e,t,n])},complete:function(e,t){r.trigger("ajax:complete",[e,t])},error:function(e,t,n){r.trigger("ajax:error",[e,t,n])},crossDomain:a};if(f){c.xhrFields={withCredentials:f}}if(s){c.url=s}return n.ajax(c)}else{return false}},handleMethod:function(r){var i=n.href(r),s=r.data("method"),o=r.attr("target"),u=e("meta[name=csrf-token]").attr("content"),a=e("meta[name=csrf-param]").attr("content"),f=e('<form method="post" action="'+i+'"></form>'),l='<input name="_method" value="'+s+'" type="hidden" />';if(a!==t&&u!==t){l+='<input name="'+a+'" value="'+u+'" type="hidden" />'}if(o){f.attr("target",o)}f.hide().append(l).appendTo("body");f.submit()},formElements:function(t,n){return t.is("form")?e(t[0].elements).filter(n):t.find(n)},disableFormElements:function(t){n.formElements(t,n.disableSelector).each(function(){n.disableFormElement(e(this))})},disableFormElement:function(e){var t=e.is("button")?"html":"val";e.data("ujs:enable-with",e[t]());e[t](e.data("disable-with"));e.prop("disabled",true)},enableFormElements:function(t){n.formElements(t,n.enableSelector).each(function(){n.enableFormElement(e(this))})},enableFormElement:function(e){var t=e.is("button")?"html":"val";if(e.data("ujs:enable-with"))e[t](e.data("ujs:enable-with"));e.prop("disabled",false)},allowAction:function(e){var t=e.data("confirm"),r=false,i;if(!t){return true}if(n.fire(e,"confirm")){r=n.confirm(t);i=n.fire(e,"confirm:complete",[r])}return r&&i},blankInputs:function(t,n,r){var i=e(),s,o,u=n||"input,textarea",a=t.find(u);a.each(function(){s=e(this);o=s.is("input[type=checkbox],input[type=radio]")?s.is(":checked"):s.val();if(!o===!r){if(s.is("input[type=radio]")&&a.filter('input[type=radio]:checked[name="'+s.attr("name")+'"]').length){return true}i=i.add(s)}});return i.length?i:false},nonBlankInputs:function(e,t){return n.blankInputs(e,t,true)},stopEverything:function(t){e(t.target).trigger("ujs:everythingStopped");t.stopImmediatePropagation();return false},disableElement:function(e){e.data("ujs:enable-with",e.html());e.html(e.data("disable-with"));e.bind("click.railsDisable",function(e){return n.stopEverything(e)})},enableElement:function(e){if(e.data("ujs:enable-with")!==t){e.html(e.data("ujs:enable-with"));e.removeData("ujs:enable-with")}e.unbind("click.railsDisable")}};if(n.fire(r,"rails:attachBindings")){e.ajaxPrefilter(function(e,t,r){if(!e.crossDomain){n.CSRFProtection(r)}});r.delegate(n.linkDisableSelector,"ajax:complete",function(){n.enableElement(e(this))});r.delegate(n.buttonDisableSelector,"ajax:complete",function(){n.enableFormElement(e(this))});r.delegate(n.linkClickSelector,"click.rails",function(r){var i=e(this),s=i.data("method"),o=i.data("params"),u=r.metaKey||r.ctrlKey;if(!n.allowAction(i))return n.stopEverything(r);if(!u&&i.is(n.linkDisableSelector))n.disableElement(i);if(i.data("remote")!==t){if(u&&(!s||s==="GET")&&!o){return true}var a=n.handleRemote(i);if(a===false){n.enableElement(i)}else{a.error(function(){n.enableElement(i)})}return false}else if(i.data("method")){n.handleMethod(i);return false}});r.delegate(n.buttonClickSelector,"click.rails",function(t){var r=e(this);if(!n.allowAction(r))return n.stopEverything(t);if(r.is(n.buttonDisableSelector))n.disableFormElement(r);var i=n.handleRemote(r);if(i===false){n.enableFormElement(r)}else{i.error(function(){n.enableFormElement(r)})}return false});r.delegate(n.inputChangeSelector,"change.rails",function(t){var r=e(this);if(!n.allowAction(r))return n.stopEverything(t);n.handleRemote(r);return false});r.delegate(n.formSubmitSelector,"submit.rails",function(r){var i=e(this),s=i.data("remote")!==t,o,u;if(!n.allowAction(i))return n.stopEverything(r);if(i.attr("novalidate")==t){o=n.blankInputs(i,n.requiredInputSelector);if(o&&n.fire(i,"ajax:aborted:required",[o])){return n.stopEverything(r)}}if(s){u=n.nonBlankInputs(i,n.fileInputSelector);if(u){setTimeout(function(){n.disableFormElements(i)},13);var a=n.fire(i,"ajax:aborted:file",[u]);if(!a){setTimeout(function(){n.enableFormElements(i)},13)}return a}n.handleRemote(i);return false}else{setTimeout(function(){n.disableFormElements(i)},13)}});r.delegate(n.formInputClickSelector,"click.rails",function(t){var r=e(this);if(!n.allowAction(r))return n.stopEverything(t);var i=r.attr("name"),s=i?{name:i,value:r.val()}:null;r.closest("form").data("ujs:submit-button",s)});r.delegate(n.formSubmitSelector,"ajax:send.rails",function(t){if(this==t.target)n.disableFormElements(e(this))});r.delegate(n.formSubmitSelector,"ajax:complete.rails",function(t){if(this==t.target)n.enableFormElements(e(this))});e(function(){n.refreshCSRFTokens()})}})(jQuery)
    </script>
    <style>
        a.status-1 {
            font-weight: bold;
        }

        .form-inline {
            display: inline;
        }

        .trans-actions:not(.top-flow) > a[href] {
            display: none;
        }

        .bulk-container.top-flow,
        .trans-actions.top-flow {
            -webkit-transition: all 0.1s;
            -moz-transition: all 0.1s;
            -ms-transition: all 0.1s;
            -o-transition: all 0.1s;
            transition: all 0.1s;

        <?php if (Illuminate\Support\Arr::get($config, 'menu_position') === 'bottom') {
            echo 'bottom: 0;box-shadow: 0 -1px 0 rgba(0,0,0,.23);';
        } else {
            echo 'top: 0;box-shadow: 0 1px 0 rgba(0,0,0,.23);';
        } ?> width: 80%;
            z-index: 1;
            padding: 10px;
            display: block;
            position: fixed;
            background: #fff;
        }

        <?php if (Illuminate\Support\Arr::get($config, 'menu_position') === 'bottom') {
            echo '.table {margin-bottom: 80px; }';
        } ?>

        .trans-actions.top-flow form {
            display: inline;
        }

        .trans-actions.top-flow button[type="submit"] {
            float: right;
        }

        table tr:hover {
            background: #eee;
        }

        table tr td + table tr:hover td {
            border-color: #f00;
        }

        <?php if (Illuminate\Support\Arr::get($config, 'support_grammarly', false)) { ?>
        @media (min-width: 768px) {
            .form-inline .form-control {
                min-width: 302px;
            }
        }
        <?php } ?>
        <?php if(Illuminate\Support\Arr::get($config, 'services.deepl.enabled', false)): ?>
        .trans-actions.top-flow a[href] {
            float: right;
            margin-right: 5px;
        }
        .bulk-container.top-flow {
            width: unset;
        }

        .btn-bulk {
            margin-left: 3px;
        }
        tr label {
            font-weight: unset;
            display: unset;
            max-width: 100%;
            margin-bottom: 0;
            cursor: pointer;
        }
        <?php endif; ?>
    </style>
    <script>
        jQuery(document).ready(function ($) {

            var scrolling = null;
            jQuery('[data-scroll-to], a[href^="#"]').on('click', function (e) {
                var target = jQuery(this).data('scroll-to') ? jQuery(this).data('scroll-to') : jQuery(this).attr('href');

                if (target && target.length > 1 && jQuery(target) && jQuery(target).length) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (scrolling != null)
                        scrolling.stop();

                    scrolling = jQuery('html, body').animate({
                        scrollTop: (parseInt(jQuery(target).offset().top) - 200)
                    }, 100);

                    jQuery("html, body").bind("scroll mousedown DOMMouseScroll mousewheel", function () {
                        jQuery('html, body').stop();
                    });
                }
            });

            jQuery('[href="#new-translation"]').click(function () {
                jQuery('#new-translation [name="keys"]').focus();
            });

            $(window).on('scroll', function () {
                $('.trans-actions').toggleClass('top-flow', (window.pageYOffset || document.documentElement.scrollTop) > 100);
                $('.bulk-container').toggleClass('top-flow', (window.pageYOffset || document.documentElement.scrollTop) > 319);
            }).trigger('scroll');

            $.ajaxSetup({
                beforeSend: function (xhr, settings) {
                    console.log('beforesend');
                    settings.data += "&_token=<?= Illuminate\Support\Facades\Session::token(); ?>";
                }
            });

            $('.editable').editable().on('hidden', function (e, reason) {
                var locale = $(this).data('locale');
                if (reason === 'save') {
                    $(this).removeClass('status-0').addClass('status-1');
                }
                if (reason === 'save' || reason === 'nochange') {
                    var $next = $(this).closest('tr').next().find('.editable.locale-' + locale);
                    setTimeout(function () {
                        $next.editable('show');
                    }, 300);
                }
            });

            $('.group-select').on('change', function () {
                var group = $(this).val();
                if (group) {
                    window.location.href = '<?= Illuminate\Support\Facades\URL::action('\Barryvdh\TranslationManager\Controller@getView') ?>/' + $(this).val();
                } else {
                    window.location.href = '<?= Illuminate\Support\Facades\URL::action('\Barryvdh\TranslationManager\Controller@getIndex') ?>';
                }
            });

            $("a.delete-key").click(function (event) {
                event.preventDefault();

                var elem = $(this);

                if (confirm(elem.attr('data-confirm-msg')) == true) {
                    var row = $(this).closest('tr');
                    var url = $(this).attr('href');
                    var id  = row.attr('id');
                    $.post(url, {id: id}, function () {
                        row.remove();
                    });
                }
            });

            <?php if(is_callable($configVal = Illuminate\Support\Arr::get($config, 'import_enabled', true)) ? $configVal() : $configVal): ?>
            $('.form-import').on('ajax:success', function (e, data) {
                $('div.success-import strong.counter').text(data.counter);
                $('div.success-import').slideDown();
            });
            <?php endif; ?>

            <?php if(is_callable($configVal = Illuminate\Support\Arr::get($config, 'find_enabled', true)) ? $configVal() : $configVal): ?>
            $('.form-find').on('ajax:success', function (e, data) {
                $('div.success-find strong.counter').text(data.counter);
                $('div.success-find').slideDown();
            });
            <?php endif; ?>

            $('.form-publish').on('ajax:success', function (e, data) {
                $('div.success-publish').slideDown();
            });

            <?php if(Illuminate\Support\Arr::get($config, 'services.deepl.enabled', false)): ?>
            $('.bulk, [name="check_all"]').change(function () {
                if (this.name === 'check_all') {
                    $('.bulk').prop('checked', $(this).is(':checked'));
                }

                jQuery('.btn-bulk').prop('disabled', !$('.bulk:checked').length);
            });

            $('.form-bulk').on('submit', function (e) {
                $(this).find('[name="keys"]').val($('.bulk:checked').serializeArray().map(function (item) {
                    return item.value;
                }).join('|'))

                if ($(this).find('[name="locale_base"]').val() === $(this).find('[name="locale_target"]').val()) {
                    e.preventDefault();

                    alert('From and to locale cannot be the same.');
                }
            }).on('ajax:success', function (e, data) {
                $('div.success-bulk strong.locale_base').text(data.locale_base);
                $('div.success-bulk strong.locale_target').text(data.locale_target);
                $('div.success-bulk').slideDown();

                if (data.translations !== undefined) {
                    $.each(data.translations, function (key, text) {
                        $('[id="' + key + '"] a[data-locale="' + data.locale_target + '"]').removeClass('status-0').addClass('status-1').toggleClass('editable-empty', !text.length).text(text);
                    });
                }
            });

            $('.form-usage').on('ajax:success', function (e, data) {
                $('#service-usage').text(data.text);
            });
            <?php endif; ?>
        })
    </script>
</head>
<body>
<div style="width: 80%; margin: auto;">
    <h1>Translation Manager</h1>
    <p>Warning, translations are not visible until they are exported back to the app/lang file, using 'php artisan translation:export' command or publish button.</p>
    <div class="alert alert-success success-import" style="display:none;">
        <p>Done importing, processed <strong class="counter">N</strong> items! Reload this page to refresh the groups!</p>
    </div>
    <div class="alert alert-success success-find" style="display:none;">
        <p>Done searching for translations, found <strong class="counter">N</strong> items!</p>
    </div>
    <div class="alert alert-success success-publish" style="display:none;">
        <p>Done publishing the translations for group '<?= $group ?>'!</p>
    </div>
    <div class="alert alert-success success-bulk" style="display:none;">
        <p>Done translating the selecterd rows from '<strong class="locale_base">N</strong>' to '<strong class="locale_target">N</strong>'!</p>
    </div>
    <?php if (Illuminate\Support\Facades\Session::has('successPublish')) : ?>
        <div class="alert alert-info">
            <?php echo Illuminate\Support\Facades\Session::get('successPublish'); ?>
        </div>
    <?php endif; ?>
    <p>
        <?php if (!isset($group) && (is_callable($configVal = Illuminate\Support\Arr::get($config, 'import_enabled', true)) ? $configVal() : $configVal)) : ?>
    <form class="form-inline form-import" method="POST" action="<?= Illuminate\Support\Facades\URL::action('\Barryvdh\TranslationManager\Controller@postImport') ?>" data-remote="true" role="form">
        <input type="hidden" name="_token" value="<?php echo Illuminate\Support\Facades\Session::token(); ?>">
        <select name="replace" class="form-control">
            <option value="0">Append new translations</option>
            <option value="1">Replace existing translations</option>
        </select>
        <button type="submit" class="btn btn-success" data-disable-with="Loading..">Import groups</button>
    </form>
<?php if (is_callable($configVal = Illuminate\Support\Arr::get($config, 'find_enabled', true)) ? $configVal() : $configVal): ?>
    <form class="form-inline form-find" method="POST" action="<?= Illuminate\Support\Facades\URL::action('\Barryvdh\TranslationManager\Controller@postFind') ?>" data-remote="true" role="form" data-confirm="Are you sure you want to scan you app folder? All found translation keys will be added to the database.">
        <input type="hidden" name="_token" value="<?php echo Illuminate\Support\Facades\Session::token(); ?>">
        <p></p>
        <button type="submit" class="btn btn-info" data-disable-with="Searching..">Find translations in files</button>
    </form>
<?php endif; ?>
<?php endif; ?>
    <?php if (isset($group)) : ?>
        <div class="trans-actions">
            <?php if (is_callable($configVal = Illuminate\Support\Arr::get($config, 'publish_enabled', true)) ? $configVal() : $configVal): ?>
            <form class="form-inline form-publish" method="POST" action="<?= Illuminate\Support\Facades\URL::action('\Barryvdh\TranslationManager\Controller@postPublish', $group) ?>" data-remote="true" role="form" data-confirm="Are you sure you want to publish the translations group '<?= $group ?>? This will overwrite existing language files.">
                <input type="hidden" name="_token" value="<?php echo Illuminate\Support\Facades\Session::token(); ?>">
                <button type="submit" class="btn btn-info" data-disable-with="Publishing..">Publish translations</button>
                <a href="<?= Illuminate\Support\Facades\URL::action('\Barryvdh\TranslationManager\Controller@getIndex') ?>" class="btn btn-default">Back</a>
            </form>
            <?php endif; ?>

            <a class="btn btn-default" href="#new-translation">+ New translation</a>
        </div>
    <?php endif; ?>
    </p>
    <form role="form">
        <input type="hidden" name="_token" value="<?php echo Illuminate\Support\Facades\Session::token(); ?>">
        <div class="form-group">
            <select name="group" id="group" class="form-control group-select">
                <?php foreach ($groups as $key => $value): ?>
                    <option value="<?= $key ?>"<?= $key == $group ? ' selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
    <?php if ($group): ?>
        <?php if (is_callable($configVal = Illuminate\Support\Arr::get($config, 'creating_enabled', true)) ? $configVal() : $configVal): ?>
            <form action="<?= Illuminate\Support\Facades\URL::action('\Barryvdh\TranslationManager\Controller@postAdd', [$group]) ?>" method="POST" role="form" id="new-translation">
                <input type="hidden" name="_token" value="<?php echo Illuminate\Support\Facades\Session::token(); ?>">
                <textarea class="form-control" rows="3" name="keys" placeholder="Add 1 key per line, without the group prefix"></textarea>
                <p></p>
                <input type="submit" value="Add keys" class="btn btn-primary">
            </form>
        <?php endif ?>
        <hr>
        <h4>Total: <?= $numTranslations ?>, changed: <?= $numChanged ?></h4>
        <?php if (Illuminate\Support\Arr::get($config, 'services.deepl.enabled', false)): ?>
            <div class="bulk-container">
                <form class="form-inline form-bulk" method="POST" action="<?= Illuminate\Support\Facades\URL::action('\Barryvdh\TranslationManager\ServiceController@postBulk', $group) ?>" data-remote="true" role="form">
                    <input type="hidden" name="_token" value="<?php echo Illuminate\Support\Facades\Session::token(); ?>">
                    <input type="hidden" name="keys" value="">
                    <img src="https://www.deepl.com/img/press/logo_DeepL.svg" alt="DeepL" width="70px"/> Translate from

                    <select name="locale_base" class="form-control">
                        <?php foreach ($locales as $locale): ?>
                            <option value="<?= $locale; ?>" <?= Illuminate\Support\Arr::get($config, 'services.deepl.default_locale') === $locale ? 'selected' : ''; ?>><?= $locale; ?></option>
                        <?php endforeach; ?>
                    </select> to
                    <select name="locale_target" class="form-control">
                        <?php foreach ($locales as $locale): ?>
                            <option value="<?= $locale; ?>" <?= Illuminate\Support\Arr::get($config, 'services.deepl.default_locale') !== $locale ? 'selected' : ''; ?>><?= $locale; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary btn-bulk" data-disable-with="Loading...">Start</button>
                </form>

                <form class="form-inline form-usage" method="POST" action="<?= Illuminate\Support\Facades\URL::action('\Barryvdh\TranslationManager\ServiceController@postUsage') ?>" data-remote="true" role="form">
                    <input type="hidden" name="_token" value="<?php echo Illuminate\Support\Facades\Session::token(); ?>">
                    <button type="submit" class="btn btn-default btn-usage" data-disable-with="Loading...">Usage</button>
                </form> <span id="service-usage"></span>
            </div>
        <?php endif ?>
        <table class="table">
            <thead>
            <tr>
                <?php if (Illuminate\Support\Arr::get($config, 'services.deepl.enabled', false)): ?>
                    <th width="10px"><input type="checkbox" name="check_all"></th>
                <?php endif ?>
                <th width="15%">Key</th>
                <?php foreach ($locales as $locale): ?>
                    <th><?= $locale ?></th>
                <?php endforeach; ?>
                <?php if ($deleteEnabled): ?>
                    <th>&nbsp;</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($translations as $key => $translation): ?>
                <tr id="<?= $key ?>">
                    <?php if (Illuminate\Support\Arr::get($config, 'services.deepl.enabled', false)) { ?>
                        <td><input type="checkbox" name="bulk[]" value="<?= $key ?>" id="bulk_<?= $key; ?>" class="bulk"/></td>
                    <td><label for="bulk_<?= $key; ?>"><?= $key ?></label></td>
                    <?php } else { ?>
                    <td><?= $key ?></td>
                    <?php } ?>
                    <?php foreach ($locales as $locale): ?>
                        <?php $t = isset($translation[$locale]) ? $translation[$locale] : null ?>

                        <td>
                            <a href="#edit" class="editable status-<?= $t ? $t->status : 0 ?> locale-<?= $locale ?>" data-locale="<?= $locale ?>" data-name="<?= $locale . "|" . $key ?>" id="username" data-type="textarea" data-pk="<?= $t ? $t->id : 0 ?>" data-url="<?= $editUrl ?>" data-title="Enter translation"><?= $t ? htmlentities($t->value, ENT_QUOTES, 'UTF-8', false) : '' ?></a>
                        </td>
                    <?php endforeach; ?>
                    <?php if ($deleteEnabled): ?>
                        <td>
                            <a href="<?= Illuminate\Support\Facades\URL::action('\Barryvdh\TranslationManager\Controller@postDelete', [$group, $key]) ?>" class="delete-key" data-confirm-msg="Are you sure you want to delete the translations for '<?= $key ?>?"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    <?php else: ?>
        <p>Choose a group to display the group translations. If no groups are visible, make sure you have run the migrations and imported the translations.</p>

    <?php endif; ?>
</div>

</body>
</html>
