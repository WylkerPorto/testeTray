<template>
  <DashboardLayout>
    <main>
      <HeaderSeller @update="atualizaTabela" />
      <ListTable ref="listTable" />
    </main>
  </DashboardLayout>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import DashboardLayout from "@/layouts/DashboardLayout.vue";
import ListTable from "@/components/sellers/ListTable.vue";
import HeaderSeller from "@/components/sellers/HeaderSeller.vue";

export default defineComponent({
  name: "SellersPage",
  components: {
    DashboardLayout,
    ListTable,
    HeaderSeller,
  },
  setup() {
    // Definindo o ref para acessar o método buscarVendedores
    const listTable = ref<InstanceType<typeof ListTable> | null>(null);

    const atualizaTabela = () => {
      if (listTable.value) {
        listTable.value.buscarVendedores(); // Garante que buscarVendedores será chamado
      }
    };

    return {
      listTable,
      atualizaTabela,
    };
  },
});
</script>

<style lang="scss" scoped></style>
