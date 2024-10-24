<template>
  <DashboardLayout>
    <main>
      <HeaderSale @update="atualizaTabela" />
      <ListTable ref="listTable" />
    </main>
  </DashboardLayout>
</template>
<script lang="ts">
import DashboardLayout from "@/layouts/DashboardLayout.vue";
import { useSellersStore } from "@/stores/sellers";
import ListTable from "@/components/sales/ListTable.vue";
import HeaderSale from "@/components/sales/HeaderSale.vue";

export default {
  name: "SalesPage",
  components: {
    DashboardLayout,
    ListTable,
    HeaderSale,
  },
  mounted() {
    const useSellerts = useSellersStore();
    useSellerts.getSellers();
  },
  methods: {
    atualizaTabela() {
      this.$refs.listTable.buscarVendas();
    },
  },
};
</script>
<style lang="scss" scoped></style>
