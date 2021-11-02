import {FeatureDetector} from "./features/FeatureDetector";
import {StylesheetManager} from "./components/StylesheetManager";
import {EventManager} from "./features/EventManager";

/**
 * Pew.js polyfill
 */
"use strict";

function _instanceof(e, t) {return null != t && "undefined" != typeof Symbol && t[Symbol.hasInstance] ? t[Symbol.hasInstance](e) : e instanceof t}

function _classCallCheck(e, t) {if (!_instanceof(e, t)) throw new TypeError("Cannot call a class as a function")}

function _defineProperties(e, t) {
  for (var n = 0; n < t.length; n++) {
    var r = t[n];
    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
  }
}

function _createClass(e, t, n) {return t && _defineProperties(e.prototype, t), n && _defineProperties(e, n), e}

var Enhancer = function () {
  function e() {_classCallCheck(this, e)}

  return _createClass(e, [{key: "__debug", value: function () {return this.__DEBUG = !0, this}}, {
    key: "enhance", value: function (e, n) {
      var r = this;
      n || (n = document.body);
      var i = e.getAll();
      return Object.keys(i).map(function (e) {
        var t = i[e];
        t.parentHTMLElement = n, r.enhanceEntry(t)
      })
    }
  }, {key: "enhanceEntry", value: function (e, t) {return this.__DEBUG && e.debug(), e.enhance(t), this}}]), e
}(), Registry = function () {
  function e() {_classCallCheck(this, e), this.entries = {}}

  return _createClass(e, [{key: "addEntry", value: function (e) {return this.entries[e.key] = e, this}}, {key: "getAll", value: function () {return this.entries}},
    {key: "getEntry", value: function (e) {return !!this.entries[e] && this.entries[e]}}]), e
}(), RegistryEntry = function () {
  function i(e, t, n, r) {_classCallCheck(this, i), this.key = e, this.classDef = t, this.domSelector = n, this.parentHTMLElement = r, this.HTMLCollection = null}

  return _createClass(i, [{key: "debug", value: function () {return this.__DEBUG = !0, this}}, {
    key: "enhance", value: function (e) {
      var t = this;
      return this.HTMLCollection = this.findDOMElements(e), this.HTMLCollection.forEach(function (e) {t.enhanceElement(e)}), this
    }
  }, {
    key: "enhanceElement", value: function (e) {
      var t = null;
      return void 0 === e.dataset.pewElement ? (t = new this.classDef(e), e.dataset.pewElement = t) : t = e.dataset.pewElement, t
    }
  }, {
    key: "findDOMElements", value: function (e) {
      this.parentHTMLElement || (this.parentHTMLElement = document.body);
      var t = [], n = [], r = this.parentHTMLElement.querySelectorAll(this.domSelector);
      if (r.length) for (var i = 0; i < r.length; i++) e || !r[i].hasAttribute("data-no-pew") ? t.push(r[i]) : n.push(r[i]);
      if (this.__DEBUG) {
        var s = 0 < n.length ? ", and " + n.length + " ignored@ due to [data-no-pew] : " : "";
        console.warn('[PewJS DEBUG] RegistryItem : "' + this.key + '" matched ' + r.length + " results in ParentNode", this.parentHTMLElement, 'with selector "' + this.domSelector + '" :', t, s, n)
      }
      return t
    }
  }]), i
}(), Pew = function () {
  function t(e) {_classCallCheck(this, t), this.registry = new Registry, this.enhancer = new Enhancer}

  return _createClass(t, [{key: "__debug", value: function () {return this.__DEBUG = !0, this.enhancer.__debug(), this}}, {
    key: "enhanceRegistry",
    value: function (e) {return e || (e = document.body), this.__DEBUG && console.info("[PewJS] Automatic enhancement starting on the following registry : ", this.registry.getAll(), "on the following dom fragment", e), this.enhancer.enhance(this.registry, e), this}
  }, {
    key: "addRegistryEntry", value: function (e) {
      var t = e.key, n = e.classDef, r = e.domSelector, i = e.parentHTMLElement, s = new RegistryEntry(t, n, r, i);
      return this.registry.addEntry(s, this.__DEBUG), this
    }
  }, {
    key: "enhanceRegistryEntry", value: function (e) {
      var t = this.getRegistryEntry(e);
      if (t) this.enhancer.enhanceEntry(t, !0); else if (this.__DEBUG) throw'[PewJS] No entry found for Registry Entry key "' + e + '".';
      return this
    }
  }, {key: "getRegistryEntry", value: function (e) {return this.registry.getEntry(e)}}]), t
}();

window.pew = new Pew();

window.wonderwp = window.wonderwp || {};
window.wonderwp.FeatureDetector = new FeatureDetector();

window.wonderwp.StylesheetManager = new StylesheetManager();

window.EventManager = new EventManager();

let event = document.createEvent('Event');
event.initEvent('criticalJsReady', true, true);
document.dispatchEvent(event);

window.criticalJsReady = 1;
