<template>
  <table>
    <thead>
      <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>ações</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="user in users" :key="user.uid">
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>
          <button @click="mostrarModalVendedor(user)" title="Editar Vendedor">
            <i class="icon i-edit i-white"></i>
          </button>
          <button
            @click="mostrarModalExcluirVendedor(user)"
            title="Excluir Vendedor"
          >
            <i class="icon i-delete i-white"></i>
          </button>
          <button
            @click="mostrarVendaPorVendedor(user)"
            title="Lista de Vendas por Dia"
          >
            <i class="icon i-market i-white"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>

  <Paginator
    v-if="pagination.last_page > 1"
    :pagination="pagination"
    @change="buscarVendedores"
  />

  <CreateModal
    :open="showSellerModal"
    :seller="user"
    @close-click="fecharModais"
    @cancel="fecharModais"
    @confirm="atualizarVendedor"
  />

  <DeleteModal
    :open="showDeleteModal"
    @close-click="fecharModais"
    @confirm="excluirVendedor"
    @cancel="fecharModais"
  />
</template>

<script lang="ts">
import sellerService from "@/services/sellerService";
import CreateModal from "@/components/sellers/CreateModal.vue";
import DeleteModal from "@/components/core/DeleteModal.vue";
import Paginator from "@/components/core/Paginator.vue";
import type { IUser } from "@/interfaces/IUser";

export default {
  name: "ListSellersTable",
  data() {
    return {
      users: [] as IUser[],
      pagination: {} as any,
      loading: false,
      showSellerModal: false,
      user: {} as IUser,
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
    this.buscarVendedores();
  },
  methods: {
    async buscarVendedores(pageUrl?: string) {
      this.loading = true;
      try {
        const data = await sellerService.getAllSellers(pageUrl);
        this.users = data.data;
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

    mostrarModalVendedor(user: IUser) {
      this.user = user;
      this.showSellerModal = true;
    },

    mostrarModalExcluirVendedor(user: IUser) {
      this.user = user;
      this.showDeleteModal = true;
    },

    fecharModais() {
      this.user = {} as IUser;
      this.showSellerModal = false;
      this.showDeleteModal = false;
    },

    async atualizarVendedor(user: IUser) {
      try {
        await sellerService.updateSeller(user.uid, user);
        this.fecharModais();
        this.buscarVendedores();
      } catch (e) {
        console.log("error", e);
      }
    },

    async excluirVendedor() {
      try {
        await sellerService.deleteSeller(this.user.uid);
        this.fecharModais();
        this.buscarVendedores();
      } catch (e) {
        console.log("error", e);
      }
    },

    mostrarVendaPorVendedor(user: IUser) {
      this.$router.push({
        name: "vendaRelatorio",
        params: { id: user.uid },
      });
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

          &:has(.i-market) {
            @apply bg-yellow-700 hover:shadow-yellow-400;
          }
        }
      }
    }
  }
}
</style>
