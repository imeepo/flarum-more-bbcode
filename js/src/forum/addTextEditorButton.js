import { extend } from "flarum/extend";
import TextEditor from "flarum/components/TextEditor";
import TextEditorButton from "./TextEditorButton";

export default function addTextEditorButton() {
  extend(TextEditor.prototype, "toolbarItems", function (items) {
      items.add('imeepo-more-bbcode', <TextEditorButton textEditor={this.attrs.composer.editor} />);
  });
}
