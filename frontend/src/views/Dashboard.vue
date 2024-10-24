<template>
  <DashboardLayout>
    <main>
      <RouterLink :to="{ name: 'vendedores' }">
        <i class="icon i-black i-sales"></i>
        <span>Vendedores</span>
      </RouterLink>

      <RouterLink :to="{ name: 'vendas' }">
        <i class="icon i-black i-market"></i>
        <span>Vendas</span>
      </RouterLink>
    </main>
  </DashboardLayout>
</template>
<script lang="ts">
import DashboardLayout from "@/layouts/DashboardLayout.vue";

export default {
  name: "DashboardPage",
  components: {
    DashboardLayout,
  },
};
</script>
<style lang="scss" scoped>
main {
  @apply flex justify-evenly pt-20;

  a {
    @apply flex flex-col items-center justify-center gap-4 border-2 rounded-2xl border-violet-700 w-52 h-52;
    @apply hover:bg-violet-300 hover:text-white hover:shadow-lg hover:shadow-violet-600;

    i {
      @apply h-20 w-20;
    }
  }
}
</style>
