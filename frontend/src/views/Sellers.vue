<template>
  <DashboardLayout>
    <main>
      <HeaderSeller @update="atualizaTabela" />
      <ListTable ref="listTable" />
    </main>
  </DashboardLayout>
</template>
<script lang="ts">
import DashboardLayout from "@/layouts/DashboardLayout.vue";
import ListTable from "@/components/sellers/ListTable.vue";
import HeaderSeller from "@/components/sellers/HeaderSeller.vue";

export default {
  name: "SellersPage",
  components: {
    DashboardLayout,
    ListTable,
    HeaderSeller,
  },
  methods: {
    atualizaTabela() {
      this.$refs.listTable.buscarVendedores();
    },
  },
};
</script>
<style lang="scss" scoped></style>
