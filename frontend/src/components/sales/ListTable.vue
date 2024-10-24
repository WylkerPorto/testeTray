<template>
  <table>
    <thead>
      <tr>
        <th>Vendedor</th>
        <th>Valor</th>
        <th>Comissão</th>
        <th>Data da Venda</th>
        <th>ações</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="sale in sales" :key="sale.uid">
        <td>{{ sale?.seller?.name }}</td>
        <td>R$: {{ sale.value }}</td>
        <td>R$: {{ (Number(sale.value) * 0.085).toFixed(2) }}</td>
        <td>{{ moment(sale.sale_date).format("DD/MM/YY") }}</td>
        <td>
          <button @click="mostrarModalVenda(sale)" title="Editar Venda">
            <i class="icon i-edit i-white"></i>
          </button>
          <button @click="mostrarModalExcluirVenda(sale)" title="Excluir Venda">
            <i class="icon i-delete i-white"></i>
          </button>
          <button @click="reenviarVenda(sale)" title="Reenviar Email">
            <i class="icon i-report i-white"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>

  <Paginator
    v-if="pagination.last_page > 1"
    :pagination="pagination"
    @change="buscarVendas"
  />

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
import Paginator from "@/components/core/Paginator.vue";
import type { ISale } from "@/interfaces/ISale";

export default {
  name: "ListSalesTable",
  data() {
    return {
      moment,
      sales: [] as ISale[],
      pagination: {} as any,
      loading: false,
      showSaleModal: false,
      sale: {} as ISale,
      showDeleteModal: false,
    };
  },
  components: {
    CreateModal,
    DeleteModal,
    Paginator,
  },
  emits: ["update"],
  mounted() {
    this.buscarVendas();
  },
  methods: {
    async buscarVendas(PageUrl?: string) {
      this.loading = true;
      try {
        const data = await saleService.getAllSales(PageUrl);
        this.sales = data.data;
        this.pagination = {
          // Atribui o resto das informações de paginação
          current_page: data.current_page,
          last_page: data.last_page,
          prev_page_url: data.prev_page_url,
          next_page_url: data.next_page_url,
          total: data.total,
        };
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

    async reenviarVenda(sale: ISale) {
      try {
        await saleService.resendCommission(sale.uid);
        alert("Comissão reenviada com sucesso!");
      } catch (error) {
        console.error("Erro ao reenviar comissão:", error);
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

          &:has(.i-report) {
            @apply bg-yellow-700 hover:shadow-yellow-400;
          }
        }
      }
    }
  }
}
</style>
