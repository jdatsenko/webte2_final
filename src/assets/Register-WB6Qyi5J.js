import { B as BaseStyle, s as script$2, o as openBlock, c as createElementBlock, m as mergeProps, b as renderSlot, k as createCommentVNode, u as useToast, l as reactive, p as computed, f as createBaseVNode, t as toDisplayString, g as unref, d as createVNode, q as withCtx, F as Fragment, i as t, n as normalizeClass, j as script$5, h as router } from "./index-sPSBL-rk.js";
import { R as Register } from "./api-Dk7U0UxE.js";
import { s as script$3 } from "./inputtext.esm-5geTda5R.js";
import { s as script$4 } from "./password.esm-ClMqp3a8.js";
var inlineStyles = {
  root: function root(_ref) {
    var props = _ref.props;
    return {
      justifyContent: props.layout === "horizontal" ? props.align === "center" || props.align === null ? "center" : props.align === "left" ? "flex-start" : props.align === "right" ? "flex-end" : null : null,
      alignItems: props.layout === "vertical" ? props.align === "center" || props.align === null ? "center" : props.align === "top" ? "flex-start" : props.align === "bottom" ? "flex-end" : null : null
    };
  }
};
var classes = {
  root: function root2(_ref2) {
    var props = _ref2.props;
    return ["p-divider p-component", "p-divider-" + props.layout, "p-divider-" + props.type, {
      "p-divider-left": props.layout === "horizontal" && (!props.align || props.align === "left")
    }, {
      "p-divider-center": props.layout === "horizontal" && props.align === "center"
    }, {
      "p-divider-right": props.layout === "horizontal" && props.align === "right"
    }, {
      "p-divider-top": props.layout === "vertical" && props.align === "top"
    }, {
      "p-divider-center": props.layout === "vertical" && (!props.align || props.align === "center")
    }, {
      "p-divider-bottom": props.layout === "vertical" && props.align === "bottom"
    }];
  },
  content: "p-divider-content"
};
var DividerStyle = BaseStyle.extend({
  name: "divider",
  classes,
  inlineStyles
});
var script$1 = {
  name: "BaseDivider",
  "extends": script$2,
  props: {
    align: {
      type: String,
      "default": null
    },
    layout: {
      type: String,
      "default": "horizontal"
    },
    type: {
      type: String,
      "default": "solid"
    }
  },
  style: DividerStyle,
  provide: function provide() {
    return {
      $parentInstance: this
    };
  }
};
var script = {
  name: "Divider",
  "extends": script$1,
  inheritAttrs: false
};
var _hoisted_1$1 = ["aria-orientation"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return openBlock(), createElementBlock("div", mergeProps({
    "class": _ctx.cx("root"),
    style: _ctx.sx("root"),
    role: "separator",
    "aria-orientation": _ctx.layout
  }, _ctx.ptmi("root")), [_ctx.$slots["default"] ? (openBlock(), createElementBlock("div", mergeProps({
    key: 0,
    "class": _ctx.cx("content")
  }, _ctx.ptm("content")), [renderSlot(_ctx.$slots, "default")], 16)) : createCommentVNode("", true)], 16, _hoisted_1$1);
}
script.render = render;
const _hoisted_1 = { class: "flex justify-content-center flex-wrap" };
const _hoisted_2 = { class: "p-text-bold p-text-center" };
const _hoisted_3 = { class: "card flex mb-3 justify-content-center" };
const _hoisted_4 = { class: "flex flex-column gap-2" };
const _hoisted_5 = /* @__PURE__ */ createBaseVNode("label", { for: "username" }, "Username", -1);
const _hoisted_6 = { class: "card flex mb-3 justify-content-center" };
const _hoisted_7 = { class: "flex flex-column gap-2" };
const _hoisted_8 = /* @__PURE__ */ createBaseVNode("label", { for: "email" }, "Email", -1);
const _hoisted_9 = { class: "card flex my-3 justify-content-center" };
const _hoisted_10 = { class: "flex flex-column gap-2" };
const _hoisted_11 = /* @__PURE__ */ createBaseVNode("label", { for: "value" }, "Password", -1);
const _hoisted_12 = /* @__PURE__ */ createBaseVNode("p", { class: "mt-2" }, "Requirements:", -1);
const _hoisted_13 = {
  class: "pl-2 ml-2 mt-0",
  style: { "line-height": "1.5" }
};
const _hoisted_14 = { class: "card flex my-3 justify-content-center" };
const _hoisted_15 = { class: "flex flex-column gap-2" };
const _hoisted_16 = /* @__PURE__ */ createBaseVNode("label", { for: "value" }, "Repeat Password", -1);
const _hoisted_17 = { class: "card flex justify-content-center" };
const _hoisted_18 = { class: "flex mt-4 justify-content-center" };
const _hoisted_19 = /* @__PURE__ */ createBaseVNode("div", { class: "flex align-items-center" }, [
  /* @__PURE__ */ createBaseVNode("span", null, "Already have an account?")
], -1);
const _hoisted_20 = { class: "ml-2" };
const _sfc_main = {
  __name: "Register",
  setup(__props) {
    const toast = useToast();
    const formData = reactive({
      username: "",
      email: "",
      password: "",
      repeatPassword: ""
    });
    const passwordHasLowercase = computed(() => /[a-z]/.test(formData.password));
    const passwordHasUppercase = computed(() => /[A-Z]/.test(formData.password));
    const passwordHasNumber = computed(() => /[0-9]/.test(formData.password));
    const passwordHasMinLength = computed(() => formData.password.length >= 8);
    const register = async () => {
      if (formData.username.length < 3) {
        toast.add({
          severity: "error",
          summary: "Error",
          detail: "Username must be at least 3 characters"
        });
        return;
      }
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(formData.email)) {
        toast.add({
          severity: "error",
          summary: "Error",
          detail: "Invalid email"
        });
        return;
      }
      const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
      if (!passwordRegex.test(formData.password)) {
        toast.add({
          severity: "error",
          summary: "Error",
          detail: "Password is not strong enough"
        });
        return;
      }
      if (formData.password !== formData.repeatPassword) {
        toast.add({
          severity: "error",
          summary: "Error",
          detail: "Passwords do not match"
        });
        return;
      }
      const response = await Register.post(formData);
      toast.add({
        severity: response.data.success ? "success" : "error",
        summary: response.data.success ? "Success" : "Error",
        detail: response.data.message
      });
      if (response.data.success) {
        router.push("/login");
      }
    };
    return (_ctx, _cache) => {
      return openBlock(), createElementBlock(Fragment, null, [
        createBaseVNode("div", _hoisted_1, [
          createBaseVNode("h1", _hoisted_2, toDisplayString(unref(t)("Register.title")), 1)
        ]),
        createBaseVNode("div", _hoisted_3, [
          createBaseVNode("div", _hoisted_4, [
            _hoisted_5,
            createVNode(unref(script$3), {
              id: "username",
              modelValue: formData.username,
              "onUpdate:modelValue": _cache[0] || (_cache[0] = ($event) => formData.username = $event)
            }, null, 8, ["modelValue"])
          ])
        ]),
        createBaseVNode("div", _hoisted_6, [
          createBaseVNode("div", _hoisted_7, [
            _hoisted_8,
            createVNode(unref(script$3), {
              id: "email",
              modelValue: formData.email,
              "onUpdate:modelValue": _cache[1] || (_cache[1] = ($event) => formData.email = $event)
            }, null, 8, ["modelValue"])
          ])
        ]),
        createBaseVNode("div", _hoisted_9, [
          createBaseVNode("div", _hoisted_10, [
            _hoisted_11,
            createVNode(unref(script$4), {
              modelValue: formData.password,
              "onUpdate:modelValue": _cache[2] || (_cache[2] = ($event) => formData.password = $event),
              autocomplete: "off"
            }, {
              footer: withCtx(() => [
                createVNode(unref(script)),
                _hoisted_12,
                createBaseVNode("ul", _hoisted_13, [
                  createBaseVNode("li", {
                    class: normalizeClass({
                      "text-green-500": passwordHasLowercase.value,
                      "text-red-500": !passwordHasLowercase.value
                    })
                  }, " At least one lowercase ", 2),
                  createBaseVNode("li", {
                    class: normalizeClass({
                      "text-green-500": passwordHasUppercase.value,
                      "text-red-500": !passwordHasUppercase.value
                    })
                  }, " At least one uppercase ", 2),
                  createBaseVNode("li", {
                    class: normalizeClass({
                      "text-green-500": passwordHasNumber.value,
                      "text-red-500": !passwordHasNumber.value
                    })
                  }, " At least one numeric ", 2),
                  createBaseVNode("li", {
                    class: normalizeClass({
                      "text-green-500": passwordHasMinLength.value,
                      "text-red-500": !passwordHasMinLength.value
                    })
                  }, " Minimum 8 characters ", 2)
                ])
              ]),
              _: 1
            }, 8, ["modelValue"])
          ])
        ]),
        createBaseVNode("div", _hoisted_14, [
          createBaseVNode("div", _hoisted_15, [
            _hoisted_16,
            createVNode(unref(script$4), {
              modelValue: formData.repeatPassword,
              "onUpdate:modelValue": _cache[3] || (_cache[3] = ($event) => formData.repeatPassword = $event),
              feedback: false,
              autocomplete: "off"
            }, null, 8, ["modelValue"])
          ])
        ]),
        createBaseVNode("div", _hoisted_17, [
          createVNode(unref(script$5), {
            label: "Submit",
            onClick: register
          })
        ]),
        createBaseVNode("div", _hoisted_18, [
          _hoisted_19,
          createBaseVNode("div", _hoisted_20, [
            createVNode(unref(script$5), {
              label: "Login",
              outlined: "",
              onClick: _cache[4] || (_cache[4] = ($event) => unref(router).push("/login"))
            })
          ])
        ])
      ], 64);
    };
  }
};
export {
  _sfc_main as default
};
