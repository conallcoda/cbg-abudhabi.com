(function() {
  "use strict";
  function normalizeComponent(scriptExports, render, staticRenderFns, functionalTemplate, injectStyles, scopeId, moduleIdentifier, shadowMode) {
    var options = typeof scriptExports === "function" ? scriptExports.options : scriptExports;
    if (render) {
      options.render = render;
      options.staticRenderFns = staticRenderFns;
      options._compiled = true;
    }
    if (scopeId) {
      options._scopeId = "data-v-" + scopeId;
    }
    return {
      exports: scriptExports,
      options
    };
  }
  const _sfc_main$7 = {
    data() {
      return {
        pages: []
      };
    },
    props: {
      title: {
        type: String,
        required: true
      },
      items: {
        type: Array,
        required: true
      }
    },
    mounted: function() {
      this.items.forEach((page) => {
        this.pages.push(page);
      });
    },
    computed: {
      _items() {
        return this.pages;
      }
    }
  };
  var _sfc_render$7 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "k-block k-block-type-profiles k-block-type-default", on: { "click": function($event) {
      return _vm.$emit("open");
    } } }, [_c("div", { staticClass: "k-block-title tw-mb-4" }, [_c("svg", { staticClass: "k-icon k-block-icon", attrs: { "aria-hidden": "true", "data-type": "users" } }, [_c("use", { attrs: { "xlink:href": "#icon-users" } })]), _c("span", { staticClass: "k-block-name" }, [_vm._v(" " + _vm._s(_vm.title) + " ")])]), _c("div", _vm._l(_vm._items, function(item, index) {
      return _c("span", [_vm._v(" " + _vm._s(item.text)), index != _vm.items.length - 1 ? _c("span", [_vm._v(", ")]) : _vm._e()]);
    }), 0)]);
  };
  var _sfc_staticRenderFns$7 = [];
  _sfc_render$7._withStripped = true;
  var __component__$7 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$7,
    _sfc_render$7,
    _sfc_staticRenderFns$7,
    false,
    null,
    null
  );
  __component__$7.options.__file = "C:/Users/conal/Development/coda/cfc-stmoritz.com/site/plugins/cfc/panel/components/ItemList.vue";
  const ItemListComponent = __component__$7.exports;
  const _sfc_main$6 = {
    computed: {
      textField() {
        return this.field("title", {
          marks: true
        });
      }
    }
  };
  var _sfc_render$6 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "k-block k-block-type-accordion k-block-type-default", on: { "click": _vm.open } }, [_c("div", { staticClass: "k-block-title tw-mb-4" }, [_c("k-writer", _vm._b({ ref: "input", attrs: { "disabled": true, "inline": true, "keys": _vm.keys, "value": _vm.content.title }, on: { "input": function($event) {
      return _vm.update({ title: $event });
    } } }, "k-writer", _vm.textField, false)), _c("svg", { staticClass: "k-icon k-block-icon", attrs: { "aria-hidden": "true", "data-type": "angle-down" } }, [_c("use", { attrs: { "xlink:href": "#icon-angle-down" } })])], 1)]);
  };
  var _sfc_staticRenderFns$6 = [];
  _sfc_render$6._withStripped = true;
  var __component__$6 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$6,
    _sfc_render$6,
    _sfc_staticRenderFns$6,
    false,
    null,
    null
  );
  __component__$6.options.__file = "C:/Users/conal/Development/coda/cfc-stmoritz.com/site/plugins/cfc/panel/components/blocks/Accordion.vue";
  const Accordion = __component__$6.exports;
  const _sfc_main$5 = {};
  var _sfc_render$5 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "tw-bg-black tw-opacity-30 tw-h-[1px] tw-w-full" });
  };
  var _sfc_staticRenderFns$5 = [];
  _sfc_render$5._withStripped = true;
  var __component__$5 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$5,
    _sfc_render$5,
    _sfc_staticRenderFns$5,
    false,
    null,
    null
  );
  __component__$5.options.__file = "C:/Users/conal/Development/coda/cfc-stmoritz.com/site/plugins/cfc/panel/components/blocks/Divider.vue";
  const Divider = __component__$5.exports;
  const _sfc_main$4 = {
    computed: {
      items() {
        return this.content.items;
      }
    }
  };
  var _sfc_render$4 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-cfc-item-list", { attrs: { "title": "Form Fields", "items": _vm.items }, on: { "open": _vm.open } });
  };
  var _sfc_staticRenderFns$4 = [];
  _sfc_render$4._withStripped = true;
  var __component__$4 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$4,
    _sfc_render$4,
    _sfc_staticRenderFns$4,
    false,
    null,
    null
  );
  __component__$4.options.__file = "C:/Users/conal/Development/coda/cfc-stmoritz.com/site/plugins/cfc/panel/components/blocks/FormFields.vue";
  const FormFields = __component__$4.exports;
  const _sfc_main$3 = {};
  var _sfc_render$3 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("div", { staticClass: "k-block k-block-type-form-next-step-button k-block-type-default", on: { "click": _vm.open } }, [_c("div", { staticClass: "k-block-title tw-mb-4" }, [_c("svg", { staticClass: "k-icon k-block-icon", attrs: { "aria-hidden": "true", "data-type": "bolt" } }, [_c("use", { attrs: { "xlink:href": "#icon-bolt" } })]), _c("span", { staticClass: "k-block-name" }, [_vm._v(" Next Step Button: [" + _vm._s(_vm.content.text) + "] ")])])]);
  };
  var _sfc_staticRenderFns$3 = [];
  _sfc_render$3._withStripped = true;
  var __component__$3 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$3,
    _sfc_render$3,
    _sfc_staticRenderFns$3,
    false,
    null,
    null
  );
  __component__$3.options.__file = "C:/Users/conal/Development/coda/cfc-stmoritz.com/site/plugins/cfc/panel/components/blocks/FormNextStepButton.vue";
  const FormNextStepButton = __component__$3.exports;
  const _sfc_main$2 = {
    computed: {
      items() {
        return this.content.items;
      }
    }
  };
  var _sfc_render$2 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-cfc-item-list", { attrs: { "title": "Partners", "items": _vm.items }, on: { "open": _vm.open } });
  };
  var _sfc_staticRenderFns$2 = [];
  _sfc_render$2._withStripped = true;
  var __component__$2 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$2,
    _sfc_render$2,
    _sfc_staticRenderFns$2,
    false,
    null,
    null
  );
  __component__$2.options.__file = "C:/Users/conal/Development/coda/cfc-stmoritz.com/site/plugins/cfc/panel/components/blocks/Partners.vue";
  const _sfc_main$1 = {
    computed: {
      items() {
        return this.content.items;
      }
    }
  };
  var _sfc_render$1 = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("k-cfc-item-list", { attrs: { "title": "Profiles", "items": _vm.items }, on: { "open": _vm.open } });
  };
  var _sfc_staticRenderFns$1 = [];
  _sfc_render$1._withStripped = true;
  var __component__$1 = /* @__PURE__ */ normalizeComponent(
    _sfc_main$1,
    _sfc_render$1,
    _sfc_staticRenderFns$1,
    false,
    null,
    null
  );
  __component__$1.options.__file = "C:/Users/conal/Development/coda/cfc-stmoritz.com/site/plugins/cfc/panel/components/blocks/Profiles.vue";
  const Profiles = __component__$1.exports;
  const _sfc_main = {
    data() {
      return {
        label: "Submission",
        submission: [{ fish: "fish" }]
      };
    },
    created() {
      this.load().then((response) => {
        this.label = response.label;
        this.submission = response.submission;
      });
    }
  };
  var _sfc_render = function render() {
    var _vm = this, _c = _vm._self._c;
    return _c("section", { staticClass: "k-submission-section" }, [_c("ul", _vm._l(_vm.submission, function(group) {
      return _c("li", { key: group.id }, [_c("h2", { staticClass: "k-headline group-headline" }, [_vm._v(_vm._s(group.label))]), _c("ul", { staticClass: "group-content" }, _vm._l(group.fields, function(field) {
        return _c("li", { key: field.id }, [_c("div", { staticClass: "field-label" }, [_vm._v(" " + _vm._s(field.label) + " [" + _vm._s(field.key) + "] ")]), _c("div", { staticClass: "field-answer" }, [_vm._v(_vm._s(field.value))])]);
      }), 0)]);
    }), 0)]);
  };
  var _sfc_staticRenderFns = [];
  _sfc_render._withStripped = true;
  var __component__ = /* @__PURE__ */ normalizeComponent(
    _sfc_main,
    _sfc_render,
    _sfc_staticRenderFns,
    false,
    null,
    "873c0d7d"
  );
  __component__.options.__file = "C:/Users/conal/Development/coda/cfc-stmoritz.com/site/plugins/cfc/panel/components/sections/SubmissionSection.vue";
  const SubmissionSection = __component__.exports;
  panel.plugin("coda/cfc", {
    sections: {
      submission: SubmissionSection
    },
    blocks: {
      accordion: Accordion,
      button: `
        <div class="k-block-title"><svg aria-hidden="true" data-type="bolt" class="k-icon k-block-icon"><use xlink:href="#icon-bolt"></use></svg><span class="k-block-name"> Button [{{content.text}}] </span><!----></div>
            `,
      divider: Divider,
      form_fields: FormFields,
      form_next_step_button: FormNextStepButton,
      profiles: Profiles
    },
    components: { "k-cfc-item-list": ItemListComponent },
    icons: {
      lock: '<path d="M7 10H20C20.5523 10 21 10.4477 21 11V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11C3 10.4477 3.44772 10 4 10H5V9C5 5.13401 8.13401 2 12 2C14.7405 2 17.1131 3.5748 18.2624 5.86882L16.4731 6.76344C15.6522 5.12486 13.9575 4 12 4C9.23858 4 7 6.23858 7 9V10ZM5 12V20H19V12H5ZM10 15H14V17H10V15Z"></path>',
      food: '<path d="M21 2V22H19V15H15V8C15 4.68629 17.6863 2 21 2ZM19 4.53C18.17 5 17 6.17 17 8V13H19V4.53ZM9 13.9V22H7V13.9C4.71776 13.4367 3 11.419 3 9V3H5V10H7V3H9V10H11V3H13V9C13 11.419 11.2822 13.4367 9 13.9Z"></path>',
      handshake: '<path d="M11.8611 2.39057C12.8495 1.73163 14.1336 1.71797 15.1358 2.35573L19.291 4.99994H20.9998C21.5521 4.99994 21.9998 5.44766 21.9998 5.99994V14.9999C21.9998 15.5522 21.5521 15.9999 20.9998 15.9999H19.4801C19.5396 16.9472 19.0933 17.9102 18.1955 18.4489L13.1021 21.505C12.4591 21.8907 11.6609 21.8817 11.0314 21.4974C10.3311 22.1167 9.2531 22.1849 8.47104 21.5704L3.33028 17.5312C2.56387 16.9291 2.37006 15.9003 2.76579 15.0847C2.28248 14.7057 2 14.1254 2 13.5109V6C2 5.44772 2.44772 5 3 5H7.94693L11.8611 2.39057ZM4.17264 13.6452L4.86467 13.0397C6.09488 11.9632 7.96042 12.0698 9.06001 13.2794L11.7622 16.2518C12.6317 17.2083 12.7903 18.6135 12.1579 19.739L17.1665 16.7339C17.4479 16.5651 17.5497 16.2276 17.4448 15.9433L13.0177 9.74551C12.769 9.39736 12.3264 9.24598 11.9166 9.36892L9.43135 10.1145C8.37425 10.4316 7.22838 10.1427 6.44799 9.36235L6.15522 9.06958C5.58721 8.50157 5.44032 7.69318 5.67935 7H4V13.5109L4.17264 13.6452ZM14.0621 4.04306C13.728 3.83047 13.3 3.83502 12.9705 4.05467L7.56943 7.65537L7.8622 7.94814C8.12233 8.20827 8.50429 8.30456 8.85666 8.19885L11.3419 7.45327C12.5713 7.08445 13.8992 7.53859 14.6452 8.58303L18.5144 13.9999H19.9998V6.99994H19.291C18.9106 6.99994 18.5381 6.89148 18.2172 6.68727L14.0621 4.04306ZM6.18168 14.5448L4.56593 15.9586L9.70669 19.9978L10.4106 18.7659C10.6256 18.3897 10.5738 17.9178 10.2823 17.5971L7.58013 14.6247C7.2136 14.2215 6.59175 14.186 6.18168 14.5448Z"></path>',
      divider: '<path d="M21 3C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H21ZM19 16H5V18H19V16Z"></path>',
      program: '<path d="M8.5 7C8.5 5.89543 7.60457 5 6.5 5C5.39543 5 4.5 5.89543 4.5 7C4.5 8.10457 5.39543 9 6.5 9C7.60457 9 8.5 8.10457 8.5 7ZM10.5 7C10.5 9.20914 8.70914 11 6.5 11C4.29086 11 2.5 9.20914 2.5 7C2.5 4.79086 4.29086 3 6.5 3C8.70914 3 10.5 4.79086 10.5 7ZM21 4H13V6H21V4ZM21 11H13V13H21V11ZM21 18H13V20H21V18ZM6.5 19C5.39543 19 4.5 18.1046 4.5 17C4.5 15.8954 5.39543 15 6.5 15C7.60457 15 8.5 15.8954 8.5 17C8.5 18.1046 7.60457 19 6.5 19ZM6.5 21C8.70914 21 10.5 19.2091 10.5 17C10.5 14.7909 8.70914 13 6.5 13C4.29086 13 2.5 14.7909 2.5 17C2.5 19.2091 4.29086 21 6.5 21ZM6.5 8C7.05228 8 7.5 7.55228 7.5 7C7.5 6.44772 7.05228 6 6.5 6C5.94772 6 5.5 6.44772 5.5 7C5.5 7.55228 5.94772 8 6.5 8Z"></path>',
      hotel: '<path d="M22 21H2V19H3V4C3 3.44772 3.44772 3 4 3H18C18.5523 3 19 3.44772 19 4V9H21V19H22V21ZM17 19H19V11H13V19H15V13H17V19ZM17 9V5H5V19H11V9H17ZM7 11H9V13H7V11ZM7 15H9V17H7V15ZM7 7H9V9H7V7Z"></path>',
      blog: '<path d="M2 4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4ZM4 5V19H20V5H4ZM6 7H12V13H6V7ZM8 9V11H10V9H8ZM14 9H18V7H14V9ZM18 13H14V11H18V13ZM6 15V17L18 17V15L6 15Z"></path>',
      wrap: '<path d="M15 18H16.5C17.8807 18 19 16.8807 19 15.5C19 14.1193 17.8807 13 16.5 13H3V11H16.5C18.9853 11 21 13.0147 21 15.5C21 17.9853 18.9853 20 16.5 20H15V22L11 19L15 16V18ZM3 4H21V6H3V4ZM9 18V20H3V18H9Z"></path',
      survey: '<path d="M17 2V4H20.0066C20.5552 4 21 4.44495 21 4.9934V21.0066C21 21.5552 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5551 3 21.0066V4.9934C3 4.44476 3.44495 4 3.9934 4H7V2H17ZM7 6H5V20H19V6H17V8H7V6ZM9 16V18H7V16H9ZM9 13V15H7V13H9ZM9 10V12H7V10H9ZM15 4H9V6H15V4Z"></path>'
    }
  });
})();
