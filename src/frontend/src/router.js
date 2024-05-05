import { createRouter, createWebHistory } from "vue-router";

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      name: "home",
      component: () => import("./views/Home.vue"),
    },
    {
      path: "/login",
      name: "login",
      component: () => import("./views/Login.vue"),
    },
    {
        path: "/register",
        name: "register",
        component: () => import("./views/Register.vue"),
    },
    {
      path: "/question/:id(\\w{5})",
      name: "question",
      component: () => import("./views/Question.vue"),
      props: (route) => ({ id: route.params.id }),
    },
    {
        path: "/:pathMatch(.*)*",
        name: "not-found",
        component: () => import("./views/NotFound.vue"),
    }
  ],
});