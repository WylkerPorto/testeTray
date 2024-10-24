<template>
  <DashboardLayout>
    <p>Relatório de Vendas por Vendedor</p>
    <ListTable />
  </DashboardLayout>
</template>
<script lang="ts">
import DashboardLayout from "@/layouts/DashboardLayout.vue";
import ListTable from "@/components/SalesReport/ListTable.vue";

export default {
  name: "SalesReport",
  components: {
    DashboardLayout,
    ListTable,
  },
};
</script>
<style lang="scss" scoped>
p {
  @apply font-bold text-3xl text-center mb-10;
}
</style>
