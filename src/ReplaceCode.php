<?php

namespace Imeepo\MoreBBCode;

use Flarum\Api\Serializer\PostSerializer;
use Flarum\Database\AbstractModel;

class ReplaceCode extends FormatContent
{
    public function __invoke(PostSerializer $serializer, AbstractModel $post, array $attributes)
    {
        if (isset($attributes["contentHtml"])) {
            // 格式化cloudbox标签，如果需要回复/登录可见可以嵌套该标签，则需要把该标签放到前面优先替换
            // if (str_contains($attributes["contentHtml"], '<cloudbox')) {
            //     $attributes = $this->cloud($serializer, $post, $attributes);
            // }

            // 在新标签打开
            if (str_contains($attributes["contentHtml"], '<cloudbtn')) {
                $attributes = $this->blank($serializer, $post, $attributes);
            }

            // 登录可见
            if (str_contains($attributes["contentHtml"], '<login2see>')) {
                $attributes = $this->login($serializer, $post, $attributes);
            }

            // 回复可见
            if (str_contains($attributes["contentHtml"], '<reply2see>')) {
                $attributes = $this->reply($serializer, $post, $attributes);
            }
        }

        return $attributes;
    }

    // 回复可见
    public function reply(PostSerializer $serializer, AbstractModel $post, array $attributes)
    {
        $actor = $serializer->getActor();

        $newHTML = $attributes["contentHtml"];
        $usersModel = $post['discussion']->participants()->get('id');
        $users = [];
        foreach ($usersModel as $user) {
            $users[] = $user->id;
        }

        // 帖子作者和管理员可见
        $replied = !$actor->isGuest() && in_array($actor->id, $users);
        if ($actor->isAdmin()) {
            $replied = true;
        }

        // 检查是否拥有忽略回复可见权限
        if ($actor->hasPermission('post.bypassReplyRequirement')) {
            $replied = true;
        }

        if ($replied) {
            $newHTML = preg_replace('/<reply2see>(.*?)<\/reply2see>/is',
                '<div class="reply2see"><div class="reply2see_title">' .
                $this->translator->trans('imeepo-more-bbcode.forum.hidden_content_reply')
                . '</div>$1</div>',
                $newHTML
            );
        } else {
            $newHTML = preg_replace(
                '/<reply2see>(.*?)<\/reply2see>/is',
                '<div class="reply2see"><div class="reply2see_alert">' .
                $this->translator->trans('imeepo-more-bbcode.forum.reply_to_see',
                    array(
                        '{reply}' => '<a class="reply2see_reply">' . $this->translator->trans('core.forum.discussion_controls.reply_button') . '</a>',
                    )
                ) . '</div></div>',
                $newHTML
            );
        }

        $attributes['contentHtml'] = $newHTML;

        return $attributes;
    }

    // 登录可见
    public function login(PostSerializer $serializer, AbstractModel $post, array $attributes)
    {
        $actor = $serializer->getActor();

        $newHTML = $attributes["contentHtml"];
        $usersModel = $post['discussion']->participants()->get('id');
        $users = [];
        foreach ($usersModel as $user) {
            $users[] = $user->id;
        }

        // 帖子作者和管理员可见
        $logined = !$actor->isGuest() && in_array($actor->id, $users);
        if ($actor->isAdmin()) {
            $logined = true;
        }

        // 检查是否登录
        if (!$actor->isGuest()) {
            $logined = true;
        }

        if ($logined) {
            $newHTML = preg_replace('/<login2see>(.*?)<\/login2see>/is',
                '<div class="login2see"><div class="login2see_title">' .
                $this->translator->trans('imeepo-more-bbcode.forum.hidden_content_login')
                . '</div>$1</div>',
                $newHTML
            );
        } else {
            $newHTML = preg_replace(
                '/<login2see>(.*?)<\/login2see>/is',
                '<div class="login2see"><div class="login2see_alert">' .
                $this->translator->trans('imeepo-more-bbcode.forum.login_to_see',
                    array(
                        '{login}' => '<a class="login2see_login">' . $this->translator->trans('core.forum.header.log_in_link') . '</a>',
                    )
                ) . '</div></div>',
                $newHTML
            );
        }

        $attributes['contentHtml'] = $newHTML;

        return $attributes;
    }

    // 格式化cloudbox标签
    public function cloud(PostSerializer $serializer, AbstractModel $post, array $attributes)
    {
        $newHTML = $attributes["contentHtml"];
        // var_dump($newHTML);die;
        $newHTML = preg_replace('/<cloudbox(.*?)<\/cloudbox>/is',
            '<div$1</div>',
            $newHTML
        );

        $attributes['contentHtml'] = $newHTML;

        return $attributes;
    }

    // 在新标签打开
    public function blank(PostSerializer $serializer, AbstractModel $post, array $attributes)
    {
        $newHTML = $attributes["contentHtml"];

        $newHTML = preg_replace('/<cloudbtn(.*?)<\/cloudbtn>/is',
            '<a$1</a>',
            $newHTML
        );

        $attributes['contentHtml'] = $newHTML;

        return $attributes;
    }
}
