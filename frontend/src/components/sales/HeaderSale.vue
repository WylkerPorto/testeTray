<template>
  <div>
    <h1>Vendas</h1>
    <button @click="showSaleModal = true">Novo</button>
  </div>
  <CreateModal
    :open="showSaleModal"
    @close-click="fecharModais"
    @cancel="fecharModais"
    @confirm="cadastrarVenda"
  />
</template>
<script lang="ts">
import CreateModal from "@/components/sales/CreateModal.vue";
import saleService from "@/services/saleService";
import type { ISale } from "@/interfaces/ISale";

export default {
  name: "HeaderSale",
  components: {
    CreateModal,
  },
  data() {
    return {
      sale: {} as ISale,
      showSaleModal: false,
    };
  },
  emits: ["update"],
  methods: {
    fecharModais() {
      this.sale = {} as ISale;
      this.showSaleModal = false;
    },

    async cadastrarVenda(sale: ISale) {
      try {
        await saleService.createSale(sale);
        this.fecharModais();
        this.$emit("update");
      } catch (e) {
        console.log("error", e);
      }
    },
  },
};
</script>
<style lang="scss" scoped>
div {
  @apply flex justify-between items-center mb-10;

  h1 {
    @apply font-bold text-lg;
  }

  button {
    @apply bg-green-700 text-white py-2 px-4 rounded-2xl;
    @apply hover:shadow-lg hover:shadow-green-600;
  }
}
</style>
