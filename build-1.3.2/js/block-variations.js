/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!************************************!*\
  !*** ./src/js/block-variations.js ***!
  \************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);


(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockVariation)('core/paragraph', {
  name: 'cta-link',
  title: 'CTA Link',
  description: 'A call to action is something you want a user to do (versus somewhere you want them to go). Function as a supporting button, taking the user down a task-path that leads to an interaction.',
  keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('call to action'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('button'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('cta'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('fancy link'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('arrow')],
  attributes: {
    className: 'is-style-utkwds-cta-link',
    content: '<a href="https://www.utk.edu/">CTA Link</a>'
  },
  icon: 'admin-links',
  isActive: ['className']
});
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockVariation)('core/paragraph', {
  name: 'single-link',
  title: 'Single Link',
  description: 'For medium emphasis, like at the end of a paragraph. Limit to 30 characters to keep it "clickable."',
  keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('link'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('links'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('single'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('standalone'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('fancy')],
  attributes: {
    className: 'is-style-utkwds-single-link',
    content: '<a href="https://www.utk.edu/">Single Link</a>'
  },
  icon: 'admin-links',
  isActive: ['className']
});
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockVariation)('core/list', {
  name: 'link-group-2up',
  title: 'Link Group 2up',
  description: 'For a list of links in 2 columns.',
  keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('links'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('links'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('link list'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('link group'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('collection'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('columns'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('columned'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('2'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('2up'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('two')],
  attributes: {
    className: 'is-style-utkwds-link-group-2up'
  },
  icon: 'editor-ul',
  innerBlocks: [['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 1</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 2</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 3</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 4</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 5</a>'
  }]],
  isActive: ['className'],
  scope: ['block']
});
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockVariation)('core/list', {
  name: 'link-group-3up',
  title: 'Link Group 3up',
  description: 'For a list of links in 3 columns.',
  keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('links'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('links'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('link list'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('link group'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('collection'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('columns'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('columned'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('3'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('3up'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('three')],
  attributes: {
    className: 'is-style-utkwds-link-group-3up'
  },
  icon: 'editor-ul',
  innerBlocks: [['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 1</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 2</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 3</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 4</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 5</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 6</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 7</a>'
  }], ['core/list-item', {
    content: '<a href="https://www.utk.edu/">Link 8</a>'
  }]],
  isActive: ['className'],
  scope: ['block']
});
})();

/******/ })()
;
//# sourceMappingURL=block-variations.js.map