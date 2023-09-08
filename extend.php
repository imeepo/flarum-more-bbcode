<?php

/*
 * This file is part of imeepo/flarum-more-bbcode.
 *
 * Copyright (c) 2023 imeepo.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Imeepo\MoreBBCode;

use Flarum\Api\Serializer\PostSerializer;
use Flarum\Extend;
use Imeepo\MoreBBCode\ReplaceCode;
use s9e\TextFormatter\Configurator;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/resources/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),
    (new Extend\Formatter)
        ->configure(function (Configurator $config) {
            // 添加自定义BBCode
            // https://s9etextformatter.readthedocs.io/Plugins/BBCodes/Add_custom_BBCodes/
            $config->BBCodes->addCustom(
                '[REPLY]{TEXT}[/REPLY]',
                '<div><reply2see></reply2see>{TEXT}<reply2see></reply2see></div>'
            );
            $config->BBCodes->addCustom(
                '[LOGIN]{TEXT}[/LOGIN]',
                '<div><login2see></login2see>{TEXT}<login2see></login2see></div>'
            );
            $config->BBCodes->addCustom(
                '[cloud type={TEXT1} title={TEXT2} url={URL}]{TEXT3}[/cloud]',
                '<div class="imeepo_cloud cloud_{TEXT1}"><div class="cloud_logo"></div><div class="cloud_describe"><div class="cloud_title">{TEXT2}</div><div class="cloud_content"><span class="cloud_type"></span><span class="cloud_password cloud_hide{TEXT3}"> | <span class="cloud_text"></span>{TEXT3}</span></div></div><cloudbtn class="cloud_button" href="{URL}" target="_blank" rel="noopener noreferrer"><i class="fa fa-download"></i></cloudbtn></div>'
            );
        }),
    new Extend\Locales(__DIR__ . '/resources/locale'),
    (new Extend\ApiSerializer(PostSerializer::class))
        ->attributes(ReplaceCode::class),
];
