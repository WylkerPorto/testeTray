<template>
  <ModalLayout :title="sale ? 'Editar Venda' : 'Criar Venda'" :open="open">
    <form @submit.prevent="save">
      <div>
        <label for="seller">Vendedor</label>
        <select name="seller" id="seller" v-model="form.seller_id">
          <option
            v-for="(seller, index) in sellers"
            :key="index"
            :value="seller.id"
          >
            {{ seller.name }}
          </option>
        </select>
      </div>

      <div>
        <label for="value">Valor</label>
        <input
          id="value"
          v-model="form.value"
          type="number"
          placeholder="value"
          :class="{ 'has-error': valorError }"
          required
        />
      </div>

      <div>
        <label for="sale_date">Data da venda</label>
        <input
          id="sale_date"
          v-model="form.sale_date"
          type="date"
          :class="{ 'has-error': valorError }"
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
import { useSellersStore } from "@/stores/sellers";
import moment from "moment";

export default {
  name: "CreateSaleModal",
  components: {
    ModalLayout,
  },
  props: {
    open: {
      type: Boolean,
      default: false,
    },
    sale: {
      type: Object,
      default: () => {},
    },
  },
  emits: ["confirm", "cancel"],
  data() {
    return {
      valorError: false as boolean,
      sellerError: false as boolean,
      dataError: false as boolean,

      form: {
        seller_id: "" as string,
        value: "" as string,
        sale_date: "" as string,
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
    const sellersStore = useSellersStore();
    return { sellersStore };
  },
  methods: {
    loadData() {
      if (this.sale) {
        this.form = { ...this.form, ...this.sale };
        this.form.sale_date = moment(this.sale.sale_date).format("YYYY-MM-DD");
      }
    },
    clearAndClose() {
      this.form = {
        seller_id: "" as string,
        value: "" as string,
        sale_date: "" as string,
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
      this.valorError = false;
      this.sellerError = false;
      this.dataError = false;

      if (!this.form.value) {
        this.valorError = true;
      }
      if (!this.form.seller_id) {
        this.sellerError = true;
      }
      if (!this.form.sale_date) {
        this.dataError = true;
      }

      if (this.valorError || this.sellerError || this.dataError) {
        return true;
      }
      return false;
    },
  },
  computed: {
    sellers() {
      return this.sellersStore.sellers;
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

    select {
      @apply outline-none h-12 pl-4 text-lg border border-gray-300;
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
