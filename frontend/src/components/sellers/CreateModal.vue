<template>
  <ModalLayout
    :title="seller ? 'Editar Vendedor' : 'Criar Vendedor'"
    :open="open"
  >
    <form @submit.prevent="save">
      <div>
        <label for="name">name</label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          placeholder="Name"
          :class="{ 'has-error': nameError }"
          required
        />
      </div>

      <div>
        <label for="email">email</label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          placeholder="Email"
          :class="{ 'has-error': emailError }"
          required
        />
      </div>

      <div>
        <button type="submit">Save</button>
        <button type="button" @click="clearAndClose">Cancel</button>
      </div>
    </form>
  </ModalLayout>
</template>
<script lang="ts">
import ModalLayout from "@/layouts/ModalLayout.vue";

import { useUserLogedStore } from "@/stores/userLoged";

export default {
  name: "CreateSellerModal",
  components: {
    ModalLayout,
  },
  props: {
    open: {
      type: Boolean,
      default: false,
    },
    seller: {
      type: Object,
      default: () => {},
    },
  },
  emits: ["confirm", "cancel"],
  data() {
    return {
      nameError: false as boolean,
      emailError: false as boolean,

      form: {
        name: "" as string,
        email: "" as string,
      },
    };
  },
  watch: {
    open() {
      if (this.open) {
        this.loadData();
      }
    },
  },
  setup() {
    const userLoged = useUserLogedStore();
    return { userLoged };
  },
  methods: {
    loadData() {
      if (this.seller) {
        this.form = { ...this.form, ...this.seller };
      }
    },
    clearAndClose() {
      this.form = {
        name: "",
        email: "",
      };
      this.$emit("cancel");
    },
    save() {
      if (this.validate()) {
        return;
      }
      this.$emit("confirm", this.form);
    },
    validate() {
      this.nameError = false;
      this.emailError = false;

      if (!this.form.name) {
        this.nameError = true;
      }
      if (!this.form.email) {
        this.emailError = true;
      }

      if (this.nameError || this.emailError) {
        return true;
      }
      return false;
    },
  },
};
</script>
<style lang="scss" scoped>
form {
  @apply flex flex-col gap-3 w-auto items-center rounded-2xl px-10 pb-14 pt-4;

  div {
    @apply flex flex-col gap-2 w-full;

    input {
      @apply outline-none h-12 pl-4 text-lg border border-gray-300;

      &#admin {
        @apply h-auto;
      }
    }

    &:has(#admin) {
      @apply flex-row;
    }

    &:has(button) {
      @apply flex-row justify-end gap-4;

      button {
        @apply bg-gray-300 text-black py-2 px-4 rounded-2xl;
        @apply hover:shadow-lg hover:shadow-gray-200;

        &:first-child {
          @apply bg-green-700 hover:shadow-green-400 text-white;
        }
      }
    }
  }
}
</style>
