<template>
  <footer>
    <button
      @click="goToPage(pagination.prev_page_url)"
      :disabled="!pagination.prev_page_url"
    >
      Anterior
    </button>
    <span
      >Página {{ pagination.current_page }} de {{ pagination.last_page }}</span
    >
    <button
      @click="goToPage(pagination.next_page_url)"
      :disabled="!pagination.next_page_url"
    >
      Próxima
    </button>
  </footer>
</template>

<script>
export default {
  name: "Paginator",
  props: {
    pagination: {
      type: Object,
      required: true,
    },
  },
  emits: ["changed"],
  methods: {
    goToPage(url) {
      if (url) {
        // Extrai o caminho e a query
        const relativeUrl = url.split("/api")[1];
        this.$emit("change", relativeUrl);
      }
    },
  },
};
</script>

<style lang="scss" scoped>
footer {
  @apply flex justify-center items-center gap-4;
  @apply bg-white p-4;

  button {
    @apply bg-gray-300 text-black py-2 px-4 rounded-2xl;
    @apply hover:shadow-lg hover:shadow-gray-200;
  }

  span {
    @apply font-bold text-lg;
  }
}
</style>
