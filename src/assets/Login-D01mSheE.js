import { e as ref, c as createElementBlock, f as createBaseVNode, t as toDisplayString, g as unref, d as createVNode, w as withModifiers, F as Fragment, o as openBlock, i as t, j as script$2, h as router } from "./index-DnPdYued.js";
import { s as script } from "./inputtext.esm-fJsqCQ9B.js";
import { s as script$1 } from "./password.esm-fmP39qqD.js";
const _hoisted_1 = { class: "flex justify-content-center flex-wrap" };
const _hoisted_2 = { class: "p-text-bold p-text-center" };
const _hoisted_3 = { class: "card flex mb-3 justify-content-center" };
const _hoisted_4 = { class: "flex flex-column gap-2" };
const _hoisted_5 = /* @__PURE__ */ createBaseVNode("label", { for: "email" }, "Email", -1);
const _hoisted_6 = { class: "card flex my-3 justify-content-center" };
const _hoisted_7 = { class: "flex flex-column gap-2" };
const _hoisted_8 = /* @__PURE__ */ createBaseVNode("label", { for: "password" }, "Password", -1);
const _hoisted_9 = { class: "card flex justify-content-center" };
const _hoisted_10 = { class: "flex mt-4 justify-content-center" };
const _hoisted_11 = /* @__PURE__ */ createBaseVNode("div", { class: "flex align-items-center" }, [
  /* @__PURE__ */ createBaseVNode("span", null, "Haven't registered yet?")
], -1);
const _hoisted_12 = { class: "ml-2" };
const _sfc_main = {
  __name: "Login",
  setup(__props) {
    const email = ref("");
    const password = ref("");
    const login = () => {
    };
    return (_ctx, _cache) => {
      return openBlock(), createElementBlock(Fragment, null, [
        createBaseVNode("div", _hoisted_1, [
          createBaseVNode("h1", _hoisted_2, toDisplayString(unref(t)("Login.title")), 1)
        ]),
        createBaseVNode("form", {
          onSubmit: withModifiers(login, ["prevent"])
        }, [
          createBaseVNode("div", _hoisted_3, [
            createBaseVNode("div", _hoisted_4, [
              _hoisted_5,
              createVNode(unref(script), {
                id: "email",
                modelValue: email.value,
                "onUpdate:modelValue": _cache[0] || (_cache[0] = ($event) => email.value = $event)
              }, null, 8, ["modelValue"])
            ])
          ]),
          createBaseVNode("div", _hoisted_6, [
            createBaseVNode("div", _hoisted_7, [
              _hoisted_8,
              createVNode(unref(script$1), {
                modelValue: password.value,
                "onUpdate:modelValue": _cache[1] || (_cache[1] = ($event) => password.value = $event),
                feedback: false,
                autocomplete: "off"
              }, null, 8, ["modelValue"])
            ])
          ]),
          createBaseVNode("div", _hoisted_9, [
            createVNode(unref(script$2), { label: "Submit" })
          ])
        ], 32),
        createBaseVNode("div", _hoisted_10, [
          _hoisted_11,
          createBaseVNode("div", _hoisted_12, [
            createVNode(unref(script$2), {
              label: "Register",
              outlined: "",
              onClick: _cache[2] || (_cache[2] = ($event) => unref(router).push("/register"))
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
