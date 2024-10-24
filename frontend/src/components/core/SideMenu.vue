<template>
  <ul>
    <li>
      <i class="icon i-eyes i-black"></i>
      <RouterLink :to="{ name: 'dashboard' }">Overview</RouterLink>
    </li>
    <li>
      <i class="icon i-sales i-black"></i>
      <RouterLink :to="{ name: 'vendedores' }">Vendedores</RouterLink>
    </li>
    <li>
      <i class="icon i-market i-black"></i>
      <RouterLink :to="{ name: 'vendas' }">Vendas</RouterLink>
    </li>
  </ul>
</template>
<script lang="ts">
export default {
  name: "SideMenu",
};
</script>
<style lang="scss" scoped>
ul {
  @apply flex flex-col gap-4;

  li {
    @apply flex gap-3 p-4 items-center;
    @apply hover:bg-violet-100;

    i {
      @apply w-10 h-10;
    }

    a {
      @apply text-lg;
    }
  }
}
</style>
