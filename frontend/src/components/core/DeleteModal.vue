<template>
  <ModalLayout title="Confirmação de exclusão" :open="open">
    <p>Deseja realmente excluir este item?</p>

    <footer>
      <button @click="$emit('confirm')">Excluir</button>
      <button @click="$emit('cancel')">Cancelar</button>
    </footer>
  </ModalLayout>
</template>
<script>
import ModalLayout from "@/layouts/ModalLayout.vue";

export default {
  name: "DeleteConfirmModal",
  components: {
    ModalLayout,
  },
  props: {
    open: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["confirm", "cancel"],
  methods: {},
};
</script>
<style lang="scss" scoped>
p {
  @apply text-center text-2xl;
}

footer {
  @apply flex justify-end gap-4 mt-5;

  button {
    @apply bg-gray-300 text-black py-2 px-4 rounded-2xl;
    @apply hover:shadow-lg hover:shadow-gray-200;

    &:first-child {
      @apply bg-red-700 hover:shadow-red-400 text-white;
    }
  }
}
</style>
