import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "./stores/user.store";

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      name: "home",
      component: () => import("./views/Home.vue"),
      beforeEnter: async () => {
        const { getUserInfo } = useUserStore();
        await getUserInfo();
      },
    },
    {
      path: "/manual",
      name: "manual",
      component: () => import("./views/Manual.vue"),
      beforeEnter: async () => {
        const { getUserInfo } = useUserStore();
        await getUserInfo();
      },
    },
    {
      path: "/login",
      name: "login",
      component: () => import("./views/Login.vue"),
      beforeEnter: async (_to, _from, next) => {
        const { state, getUserInfo } = useUserStore();
        await getUserInfo();
        if (state.isLogged) {
          next({ name: "home" });
        } else {
          next();
        }
      },
    },
    {
      path: "/result/:questionCode",
      name: "result",
      component: () => import("./views/Results.vue"),
      beforeEnter: async (_to, _from, next) => {
        const { getUserInfo } = useUserStore();
        await getUserInfo();
        next();
      },
    },
    {
      path: "/create",
      name: "create",
      component: () => import("./views/Create.vue"),
      beforeEnter: async (_to, _from, next) => {
        const { state, getUserInfo } = useUserStore();
        await getUserInfo();
        if (state.isLogged) {
          next();
        } else {
          next({ name: "login" });
        }
      },
    },
    {
      path: "/register",
      name: "register",
      component: () => import("./views/Register.vue"),
      beforeEnter: async (_to, _from, next) => {
        const { state, getUserInfo } = useUserStore();
        await getUserInfo();
        if (state.isLogged) {
          next({ name: "home" });
        } else {
          next();
        }
      },
    },
    {
      path: "/question/:id(\\w{5})",
      name: "question",
      component: () => import("./views/Question.vue"),
      props: (route) => ({ code: route.params.id }),
      beforeEnter: async () => {
        const { getUserInfo } = useUserStore();
        await getUserInfo();
      },
    },
    // ====================
    // User
    // ====================
    {
      path: "/user",
      name: "account",
      component: () => import("./views/User/Account.vue"),
      beforeEnter: async (_to, _from, next) => {
        const { state, getUserInfo } = useUserStore();
        await getUserInfo();
        if (state.isLogged) {
          next();
        } else {
          next({ name: "login" });
        }
      },
    },
    {
      path: "/user/password",
      name: "change-password",
      component: () => import("./views/User/ChangePassword.vue"),
      beforeEnter: async (_to, _from, next) => {
        const { state, getUserInfo } = useUserStore();
        await getUserInfo();
        if (state.isLogged) {
          next();
        } else {
          next({ name: "login" });
        }
      },
    },
    {
      path: "/admin",
      name: "admin",
      component: () => import("./views/Admin/Admin.vue"),
      beforeEnter: async (_to, _from, next) => {
        const { state, getUserInfo } = useUserStore();
        await getUserInfo();
        if (state.isLogged && state.user.isAdmin) {
          next();
        } else {
          next({ name: "home" });
        }
      },
    },
    {
      path: "/:pathMatch(.*)*",
      name: "not-found",
      component: () => import("./views/NotFound.vue"),
      beforeEnter: async () => {
        const { getUserInfo } = useUserStore();
        await getUserInfo();
      },
    },
  ],
});
