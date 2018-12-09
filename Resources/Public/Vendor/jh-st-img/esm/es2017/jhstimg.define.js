
// jhstimg: Custom Elements Define Library, ES Module/es2017 Target

import { defineCustomElement } from './jhstimg.core.js';
import {
  JhStImg
} from './jhstimg.components.js';

export function defineCustomElements(win, opts) {
  return defineCustomElement(win, [
    JhStImg
  ], opts);
}
