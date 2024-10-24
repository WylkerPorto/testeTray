<template>
  <DashboardLayout>
    <main>
      <HeaderSale @update="atualizaTabela" />
      <ListTable ref="listTable" />
    </main>
  </DashboardLayout>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import DashboardLayout from "@/layouts/DashboardLayout.vue";
import { useSellersStore } from "@/stores/sellers";
import ListTable from "@/components/sales/ListTable.vue";
import HeaderSale from "@/components/sales/HeaderSale.vue";

export default defineComponent({
  name: "SalesPage",
  components: {
    DashboardLayout,
    ListTable,
    HeaderSale,
  },
  setup() {
    const listTable = ref<InstanceType<typeof ListTable> | null>(null);
    const sellersStore = useSellersStore();

    // Função para atualizar a tabela
    const atualizaTabela = () => {
      if (listTable.value) {
        listTable.value.buscarVendas();
      }
    };

    // Chamando a store para obter os vendedores
    onMounted(() => {
      sellersStore.getSellers();
    });

    return {
      listTable,
      atualizaTabela,
    };
  },
});
</script>

<style lang="scss" scoped></style>
