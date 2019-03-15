(function(mod) {
  if (typeof exports == "object" && typeof module == "object") // CommonJS
    mod(require("../../lib/codemirror"));
  else if (typeof define == "function" && define.amd) // AMD
    define(["../../lib/codemirror"], mod);
  else // Plain browser env
    mod(CodeMirror);
})(function(CodeMirror) {
  "use strict";

  CodeMirror.defineSimpleMode('oop2sas', {
    // The start state contains the rules that are intially used
    start: [

      {regex: /\/(?:[^\\]|\\.)*?\//, token: "comment"},

      {regex: /self|this/, token: "oop"},
      
      {regex: /([\w]+\(+)|\)\:|([\s]+[\w]+\:+)|(\%[\w]+\:+)|method|%return;/, token: 'method'},
      
      {regex: /(^[\w]+\:+$)|^(%macro)(\s+)([\w]+\(+)|\=\)\;|%mend;/, token: 'oop'},

      {regex: /%local|%global|%let|%if|%end|%end;|%else|%else;|%do|%do;|%then/, token: "sas_macro_define"},
      
      {regex: /proc|run;|quit;|data|end;/, token: "sas_function"},
      
      {regex: /(\%[\w]+)/, token: 'macro_function'}, 

      {regex: /(<=|>=|!=|<>)|[=\;\(:\),{}.*<>+\-\/^\[\]]/, token: "operator"},
      {regex: /&/, token: "variable_value"},
     
      // The regex matches the token, the token property contains the type
      {regex: /"(?:[^\\]|\\.)*?(?:"|$)/, token: "string"},
      // You can match multiple tokens at once. Note that the captured
      // groups must span the whole string in this case
      {regex: /(function)(\s+)([a-z$][\w$]*)/,
       token: ["keyword", null, "variable-2"]},
      // Rules are matched in the order in which they appear, so there is
      // no ambiguity between this one and the one above
      {regex: /(?:function|var|return|if|for|while|else|do|this)\b/,
       token: "keyword"},
      {regex: /true|false|null|undefined/, token: "atom"},
      {regex: /0x[a-f\d]+|[-+]?(?:\.\d+|\d+\.?\d*)(?:e[-+]?\d+)?/i,
       token: "number"},
      {regex: /\/\/.*/, token: "comment"},
     
      // A next property will cause the mode to move to a different state
      {regex: /\/\*/, token: "comment", next: "comment"},

      // indent and dedent properties guide autoindentation
      {regex: /[\{\[\(]/, indent: true},
      {regex: /[\}\]\)]/, dedent: true},
      {regex: /[a-z$][\w$]*/, token: "variable"},
      // You can embed other modes with the mode property. This rule
      // causes all code between << and >> to be highlighted with the XML
      // mode.
      {regex: /<</, token: "meta", mode: {spec: "xml", end: />>/}}
    ],
    // The multi-line comment state.
    comment: [
      {regex: /.*?\*\//, token: "comment", next: "start"},
      {regex: /.*/, token: "comment"}
    ],
    // The meta property contains global information about the mode. It
    // can contain properties like lineComment, which are supported by
    // all modes, and also directives like dontIndentStates, which are
    // specific to simple modes.
    /* 
    meta: {
      dontIndentStates: ["comment"],
      lineComment: "//"
    }
    */
  });
});