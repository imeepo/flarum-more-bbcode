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
            // Định dạng nhãn cloudbox, nếu cần trả lời/đăng nhập để xem thì có thể lồng nhãn, đặt nhãn ở phía trước và thay thế trước.
            // if (str_contains($attributes["contentHtml"], '<cloudbox')) {
            //     $attributes = $this->cloud($serializer, $post, $attributes);
            // }

            // 在新标签打开 Mở ra trong trang mới
            if (str_contains($attributes["contentHtml"], '<cloudbtn')) {
                $attributes = $this->blank($serializer, $post, $attributes);
            }

            // 登录可见 Đăng nhập hiển thị
            if (str_contains($attributes["contentHtml"], '<login2see></login2see>')) {
                $attributes = $this->login($serializer, $post, $attributes);
            }

            // 回复可见 Trả lời có thể nhìn thấy
            if (str_contains($attributes["contentHtml"], '<reply2see></reply2see>')) {
                $attributes = $this->reply($serializer, $post, $attributes);
            }

            // 就像能够看到一样 Thích có thể nhìn thấy
            if (str_contains($attributes["contentHtml"], '<like2see></like2see>')) {
                $attributes = $this->like($serializer, $post, $attributes);
            }
        }

        return $attributes;
    }

    // 回复可见 Trả lời có thể nhìn thấy
    public function reply(PostSerializer $serializer, AbstractModel $post, array $attributes)
    {
        $actor = $serializer->getActor();

        $newHTML = $attributes["contentHtml"];
        $usersModel = $post['discussion']->participants()->get('id');
        $users = [];
        foreach ($usersModel as $user) {
            $users[] = $user->id;
        }

        // 帖子作者和管理员可见 // Hiển thị cho tác giả và quản trị viên
        $replied = !$actor->isGuest() && in_array($actor->id, $users);
        if ($actor->isAdmin()) {
            $replied = true;
        }

        // 检查是否拥有忽略回复可见权限 // Kiểm tra xem bạn có quyền hiển thị để bỏ qua câu trả lời không
        if ($actor->hasPermission('post.bypassReplyRequirement')) {
            $replied = true;
        }

        if ($replied) {
            $newHTML = preg_replace('/<div><reply2see><\/reply2see>(.*?)<reply2see><\/reply2see><\/div>/is',
                '<div class="reply2see"><div class="reply2see_title">' .
                $this->translator->trans('imeepo-more-bbcode.forum.hidden_content_reply')
                . '</div>$1</div>',
                $newHTML
            );
        } else {
            $newHTML = preg_replace(
                '/<div><reply2see><\/reply2see>(.*?)<reply2see><\/reply2see><\/div>/is',
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

    // 登录可见 Đăng nhập hiển thị
    public function login(PostSerializer $serializer, AbstractModel $post, array $attributes)
    {
        $actor = $serializer->getActor();

        $newHTML = $attributes["contentHtml"];
        $usersModel = $post['discussion']->participants()->get('id');
        $users = [];
        foreach ($usersModel as $user) {
            $users[] = $user->id;
        }

        // 帖子作者和管理员可见 // Hiển thị cho tác giả và quản trị viên
        $logined = !$actor->isGuest() && in_array($actor->id, $users);
        if ($actor->isAdmin()) {
            $logined = true;
        }

        // 检查是否登录
        if (!$actor->isGuest()) {
            $logined = true;
        }

        if ($logined) {
            $newHTML = preg_replace('/<div><login2see><\/login2see>(.*?)<login2see><\/login2see><\/div>/is',
                '<div class="login2see"><div class="login2see_title">' .
                $this->translator->trans('imeepo-more-bbcode.forum.hidden_content_login')
                . '</div>$1</div>',
                $newHTML
            );
        } else {
            $newHTML = preg_replace(
                '/<div><login2see><\/login2see>(.*?)<login2see><\/login2see><\/div>/is',
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

    // 格式化cloudbox标签 // Định dạng nhãn hộp đám mây
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

    // 在新标签打开 //Mở ra trong trang mới
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

    // 显示喜欢 // Hiển thị lượt thích
    public function like(PostSerializer $serializer, AbstractModel $post, array $attributes)
    {
        $actor = $serializer->getActor();

        $newHTML = $attributes["contentHtml"];
        $usersModel = $post['discussion']->participants()->get('id');
        $users = [];
        foreach ($usersModel as $user) {
            $users[] = $user->id;
        }

        //$liked = $actor->id && $post->likes()->where('user_id', $actor->id)->exists();


        // 帖子作者和管理员可见 // Hiển thị cho tác giả và quản trị viên
        //$likeed = !$actor->isGuest() && in_array($actor->id, $users);
        $likeed = !$actor->isGuest() && in_array($actor->id, $users) && $post->likes()->where('user_id', $actor->id);
        if ($actor->isAdmin()) {
            $likeed = true;
        }

        // 检查是否拥有忽略回复可见权限 Kiểm tra xem bạn có quyền Bỏ qua khả năng hiển thị trả lời hay không
        if ($actor->hasPermission('post.bypassLikeRequirement')) {
            $likeed = true;
        }

        if ($likeed) {
            $newHTML = preg_replace('/<div><like2see><\/like2see>(.*?)<like2see><\/like2see><\/div>/is',
                '<div class="like2see"><div class="like2see_title">' .
                $this->translator->trans('imeepo-more-bbcode.forum.hidden_content_like')
                . '</div>$1</div>',
                $newHTML
            );
        } else {
            $newHTML = preg_replace(
                '/<div><like2see><\/like2see>(.*?)<like2see><\/like2see><\/div>/is',
                '<div class="like2see"><div class="like2see_alert">' .
                $this->translator->trans('imeepo-more-bbcode.forum.like_to_see',
                    array(
                        '{like}' => '<a class="like2see_like">' . $this->translator->trans('core.forum.header.log_in_link') . '</a>',
                    )
                ) . '</div></div>',
                $newHTML
            );
        }

        $attributes['contentHtml'] = $newHTML;

        return $attributes;
    }
}
