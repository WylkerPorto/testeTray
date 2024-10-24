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
          <button @click="mostrarModalVendedor(user)">
            <i class="icon i-edit i-white"></i>
          </button>
          <button @click="mostrarModalExcluirVendedor(user)">
            <i class="icon i-delete i-white"></i>
          </button>
          <button @click="mostrarVendaPorVendedor(user)">
            <i class="icon i-market i-white"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>

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

interface IUser {
  uid: string;
  name: string;
  email: string;
  created_at: string;
  updated_at: string;
}

export default {
  name: "ListSellersTable",
  data() {
    return {
      users: [] as IUser[],
      totalPages: 0,
      loading: false,
      showSellerModal: false,
      user: {} as IUser,
      showDeleteModal: false,
    };
  },
  components: {
    CreateModal,
    DeleteModal,
  },
  emits: ["update"],
  mounted() {
    this.buscarVendedores();
  },
  methods: {
    async buscarVendedores() {
      this.loading = true;
      try {
        const data = await sellerService.getAllSellers();
        this.users = data.data;
        this.totalPages = data.last_page;
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
