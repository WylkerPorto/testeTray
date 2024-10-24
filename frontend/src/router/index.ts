import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "login",
      component: () => import("@/views/Login.vue"),
    },
    {
      path: "/dashboard",
      name: "dashboard",
      component: () => import("@/views/Dashboard.vue"),
    },
    {
      path: "/vendedores",
      name: "vendedores",
      component: () => import("@/views/Sellers.vue"),
    },
    {
      path: "/vendas",
      name: "vendas",
      component: () => import("@/views/Sales.vue"),
    },
    {
      path: "/vendas/:id",
      name: "vendaRelatorio",
      component: () => import("@/views/SalesReport.vue"),
    },
  ],
});

export default router;
