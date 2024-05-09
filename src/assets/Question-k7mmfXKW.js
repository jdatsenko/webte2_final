import { u as useQuestionStore } from "./question.store-mfPt6wxL.js";
import { z as onMounted, g as unref, c as createElementBlock, f as createBaseVNode, t as toDisplayString, o as openBlock } from "./index-DnPdYued.js";
const _hoisted_1 = { key: 0 };
const _hoisted_2 = /* @__PURE__ */ createBaseVNode("h1", null, "Loading...", -1);
const _hoisted_3 = [
  _hoisted_2
];
const _hoisted_4 = { key: 1 };
const _hoisted_5 = /* @__PURE__ */ createBaseVNode("h1", null, "Question not found", -1);
const _hoisted_6 = [
  _hoisted_5
];
const _hoisted_7 = { key: 2 };
const _sfc_main = {
  __name: "Question",
  props: ["code"],
  setup(__props) {
    const { state, getQuestion } = useQuestionStore();
    const { code } = __props;
    onMounted(async () => {
      if (state.question === null) {
        await getQuestion(code);
      }
    });
    return (_ctx, _cache) => {
      return unref(state).loading ? (openBlock(), createElementBlock("div", _hoisted_1, _hoisted_3)) : unref(state).question == null ? (openBlock(), createElementBlock("div", _hoisted_4, _hoisted_6)) : (openBlock(), createElementBlock("div", _hoisted_7, [
        createBaseVNode("h1", null, toDisplayString(unref(state).question.question), 1),
        createBaseVNode("p", null, toDisplayString(unref(state).question.subject), 1)
      ]));
    };
  }
};
export {
  _sfc_main as default
};
