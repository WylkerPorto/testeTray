<template>
  <div>
    <h1>Vendedores</h1>
    <button @click="showSellerModal = true">Novo</button>
  </div>
  <CreateModal
    :open="showSellerModal"
    @close-click="fecharModais"
    @cancel="fecharModais"
    @confirm="cadastrarVendedor"
  />
</template>
<script lang="ts">
import CreateModal from "@/components/sellers/CreateModal.vue";
import sellerService from "@/services/sellerService";
import type { IUser } from "@/interfaces/IUser";

export default {
  name: "HeaderSeller",
  components: {
    CreateModal,
  },
  data() {
    return {
      user: {} as IUser,
      showSellerModal: false,
    };
  },
  emits: ["update"],
  methods: {
    fecharModais() {
      this.user = {} as IUser;
      this.showSellerModal = false;
    },

    async cadastrarVendedor(user: IUser) {
      try {
        await sellerService.createSeller(user);
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
