<template>
  <table>
    <thead>
      <tr>
        <th>Vendedor</th>
        <th>Valor</th>
        <th>Data da Venda</th>
        <th>ações</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="sale in sales" :key="sale.uid">
        <td>{{ sale?.seller?.name }}</td>
        <td>{{ sale.value }}</td>
        <td>{{ moment(sale.sale_date).format("DD/MM/YY") }}</td>
        <td>
          <button @click="mostrarModalVenda(sale)">
            <i class="icon i-edit i-white"></i>
          </button>
          <button @click="mostrarModalExcluirVenda(sale)">
            <i class="icon i-delete i-white"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>

  <CreateModal
    :open="showSaleModal"
    :sale="sale"
    @close-click="fecharModais"
    @cancel="fecharModais"
    @confirm="atualizarVenda"
  />

  <DeleteModal
    :open="showDeleteModal"
    @close-click="fecharModais"
    @confirm="excluirVenda"
    @cancel="fecharModais"
  />
</template>

<script lang="ts">
import saleService from "@/services/saleService";
import moment from "moment";
import CreateModal from "@/components/sales/CreateModal.vue";
import DeleteModal from "@/components/core/DeleteModal.vue";

interface ISale {
  uid: string;
  seller_id: string;
  seller: { uid: string; name: string };
  value: string;
  sale_date: string;
  created_at: string;
  updated_at: string;
}

export default {
  name: "ListSalesTable",
  data() {
    return {
      moment,
      sales: [] as ISale[],
      totalPages: 0,
      loading: false,
      showSaleModal: false,
      sale: {} as ISale,
      showDeleteModal: false,
    };
  },
  components: {
    CreateModal,
    DeleteModal,
  },
  emits: ["update"],
  mounted() {
    this.buscarVendas();
  },
  methods: {
    async buscarVendas() {
      this.loading = true;
      try {
        const data = await saleService.getAllSales();
        this.sales = data.data;
        this.totalPages = data.last_page;
      } catch (e) {
        console.log("error", e);
      } finally {
        this.loading = false;
      }
    },

    mostrarModalVenda(sale: ISale) {
      this.sale = sale;
      this.showSaleModal = true;
    },

    mostrarModalExcluirVenda(sale: ISale) {
      this.sale = sale;
      this.showDeleteModal = true;
    },

    fecharModais() {
      this.sale = {} as ISale;
      this.showSaleModal = false;
      this.showDeleteModal = false;
    },

    async atualizarVenda(sale: ISale) {
      try {
        await saleService.updateSale(sale.uid, sale);
        this.fecharModais();
        this.buscarVendas();
      } catch (e) {
        console.log("error", e);
      }
    },

    async excluirVenda() {
      try {
        await saleService.deleteSale(this.sale.uid);
        this.fecharModais();
        this.buscarVendas();
      } catch (e) {
        console.log("error", e);
      }
    },
  },
};
</script>
<style lang="scss" scoped>
table {
  @apply table-auto w-full;

  tbody {
    tr {
      @apply odd:bg-white even:bg-gray-50 border-b text-center;

      td {
        @apply p-4;

        &:has(button) {
          @apply flex gap-2 items-center justify-center;
        }

        button {
          @apply text-white py-2 px-4 rounded-2xl;
          @apply hover:shadow-lg;

          &:has(.i-edit) {
            @apply bg-blue-700 hover:shadow-blue-400;
          }

          &:has(.i-delete) {
            @apply bg-red-700 hover:shadow-red-400;
          }
        }
      }
    }
  }
}
</style>
