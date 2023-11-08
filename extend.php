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
            $config->BBCodes->addCustom(
                '[LIKE]{TEXT}[/LIKE]',
                '<div><like2see></like2see>{TEXT}<like2see></like2see></div>'
            );

            $config->BBCodes->addCustom(
                '[right]{TEXT}[/right]',
                '<div align="right">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[left]{TEXT}[/left]',
                '<div align="left">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[justify]{TEXT}[/justify]',
                '<div align="justify">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[center]{TEXT}[/center]',
                '<div align="center">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[pleft]{TEXT}[/pleft]',
                '<div style="padding-left: 40px;">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[pright]{TEXT}[/pright]',
                '<div style="padding-right: 40px;">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[dropcap]{TEXT}[/dropcap]',
                '<div class="has-dropcap">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[img-left]{TEXT}[/img-left]',
                '<div class="img-left">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[img-right]{TEXT}[/img-right]',
                '<div class="img-right">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[ileft]{TEXT}[/ileft]',
                '<div class="img-left">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[iright]{TEXT}[/iright]',
                '<div class="img-right">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[indent={NUMBER}]{TEXT}[/indent]',
                '<div style="padding-left: {NUMBER}px;">{TEXT}</div>'
            );
            $config->BBCodes->addCustom(
                '[hr]',
                '<hr style="border-top: 1px solid var(--muted-color);">'
            );

            $config->BBCodes->addCustom(
               '[audio mp3="{URL1?}" m4a="{URL2?}" wav="{URL3?}" ogg="{URL4?}" flac="{URL5?}" webm="{URL6?}" width="{NUMBER?;defaultValue=100}"]',
               '<p><audio class="bbaudio inline-exclude" style="width:{NUMBER}%;" controls controlsList="nodownload">
                        <source src="{URL1}" type="audio/mpeg">
                        <source src="{URL2}" type="audio/mp4">
                        <source src="{URL3}" type="audio/wav">
                        <source src="{URL4}" type="audio/ogg">
                        <source src="{URL5}" type="audio/flac">
                        <source src="{URL6}" type="audio/webm">
                </audio></p>'
            );
            $config->BBCodes->addCustom(
               '[video mp4="{URL?}"]',
               '<p><video controls src="{URL}"></video></p>'
            );
            
            $config->BBCodes->addCustom(
                '[gdoc]{URL}[/gdoc]',
                '<div class="bbextend-gdoc"><a href="{URL}" target="_blank"><i class="fas fa-file-word"></i> View Google Doc</a></div>'
            );

            $config->BBCodes->addCustom(             
                '[SIZE1]{TEXT}[/SIZE1]',             
                '<span style="font-size: 12px;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(             
                '[SIZE2]{TEXT}[/SIZE2]',             
                '<span style="font-size: 15px;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(             
                '[SIZE3]{TEXT}[/SIZE3]',             
                '<span style="font-size: 22px;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(             
                '[SIZE4]{TEXT}[/SIZE4]',             
                '<span style="font-size: 26px;">{TEXT}</span>'
            );

            //$event->configurator->BBCodes->addFromRepository('COLORT');
            $config->BBCodes->addCustom(             
                '[COLORT]{TEXT}[/COLORT]',             
                '<span style="color: #1abc9c;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(             
                '[COLORG]{TEXT}[/COLORG]',             
                '<span style="color: #2ecc71;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(             
                '[COLORB]{TEXT}[/COLORB]',             
                '<span style="color: #3498db;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(             
                '[COLORP]{TEXT}[/COLORP]',             
                '<span style="color: #9b59b6;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(             
                '[COLORY]{TEXT}[/COLORY]',             
                '<span style="color: #f1c40f;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(             
                '[COLORO]{TEXT}[/COLORO]',             
                '<span style="color: #e67e22;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(            
                '[COLORR]{TEXT}[/COLORR]',             
                '<span style="color: #e74c3c;">{TEXT}</span>'
            );
            $config->BBCodes->addCustom(             
                '[COLORS]{TEXT}[/COLORS]',             
                '<span style="color: #95a5a6;">{TEXT}</span>'
            );
            
        }),
    new Extend\Locales(__DIR__ . '/resources/locale'),
    (new Extend\ApiSerializer(PostSerializer::class))
        ->attributes(ReplaceCode::class),
];
