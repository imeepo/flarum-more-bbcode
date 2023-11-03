import { extend } from "flarum/common/extend";
import app from "flarum/common/app";
import CommentPost from "flarum/forum/components/CommentPost";
import DiscussionPage from "flarum/forum/components/DiscussionPage";
import DiscussionControls from "flarum/forum/utils/DiscussionControls";
import LogInModal from "flarum/forum/components/LogInModal";
import TextEditor from "flarum/common/components/TextEditor";
import TextEditorButton from "flarum/common/components/TextEditorButton";

app.initializers.add("imeepo/more-bbcode", () => {
  extend(TextEditor.prototype, "toolbarItems", function (items) {
    items.add(
      "reply-to-see",
      <TextEditorButton
        onclick={() => {
          this.attrs.composer.editor.insertAtCursor("[reply][/reply]");
          const range = this.attrs.composer.editor.getSelectionRange();
          this.attrs.composer.editor.moveCursorTo(range[1] - 8);
        }}
        icon="fa fa-comment-medical"
      >
        {app.translator.trans("imeepo-more-bbcode.forum.button_tooltip_reply")}
      </TextEditorButton>
    );
    items.add(
      "login-to-see",
      <TextEditorButton
        onclick={() => {
          this.attrs.composer.editor.insertAtCursor("[login][/login]");
          const range = this.attrs.composer.editor.getSelectionRange();
          this.attrs.composer.editor.moveCursorTo(range[1] - 8);
        }}
        icon="fas fa-sign-in-alt"
      >
        {app.translator.trans("imeepo-more-bbcode.forum.button_tooltip_login")}
      </TextEditorButton>
    );
    items.add(
      "imeepo-cloud",
      <TextEditorButton
        onclick={() => {
          //this.attrs.composer.editor.insertAtCursor('[cloud type=other title=标题 url=链接]密码[/cloud]');
          this.attrs.composer.editor.insertAtCursor('[cloud type=other title=title url=link][/cloud]');
          const range = this.attrs.composer.editor.getSelectionRange();
          this.attrs.composer.editor.moveCursorTo(range[1] - 8);
        }}
        icon="fas fa-download"
      >
        {app.translator.trans("imeepo-more-bbcode.forum.button_tooltip_cloud")}
      </TextEditorButton>
    );
  });

  extend(CommentPost.prototype, "content", function () {
    if (app.session.user && app.current.matches(DiscussionPage)) {
      $(".reply2see_reply")
        .off("click")
        .on("click", () =>
          DiscussionControls.replyAction.call(
            app.current.get("discussion"),
            true,
            false
          )
        );
    } else {
      $(".reply2see_reply")
        .off("click")
        .on("click", () => app.modal.show(LogInModal));
      $(".login2see_login")
        .off("click")
        .on("click", () => app.modal.show(LogInModal));
    }
  });
});
