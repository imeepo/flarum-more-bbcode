/*
 * This file is part of MathRen.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import app from 'flarum/common/app';
import addTextEditorButton from './addTextEditorButton';

app.initializers.add(
  'imeepo-more-bbcode',
  () => {
    // Add text editor buttons.
    addTextEditorButton();
     
  },
  -500 // since we're overriding things...
);
