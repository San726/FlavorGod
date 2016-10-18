(function (window, undefined) {
    'use strict';
    var $ = window.jQuery || window.$ || {};
    var document = window.document;
    var console = window.console;

    $(document).ready(function(){
      if(console || "console" in window) {
        console.log("%c WARNING!!!", "color:#FF8F1C; font-size:40px;");
        console.log("%c This browser feature is for developers only. Please do not copy-paste any code or run any scripts here.", "color:#003087; font-size:12px;");
        console.log("%c For more information, http://en.wikipedia.org/wiki/Self-XSS", "color:#003087; font-size:12px;");
      }
    });
})(window);