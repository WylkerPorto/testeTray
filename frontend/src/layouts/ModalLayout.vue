<template>
  <main v-if="open">
    <section @click.stop>
      <header>
        <span> {{ title }} </span>
        <button @click="closeClick()">
          <i class="icon i-close"></i>
        </button>
      </header>
      <div>
        <slot />
      </div>
    </section>
  </main>
</template>
<script lang="ts">
export default {
  name: "ModalLayout",
  props: {
    title: {
      type: String,
      default: "",
    },
    open: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["close-click"],
  methods: {
    closeClick() {
      this.$emit("close-click");
    },
  },
};
</script>

<style lang="scss" scoped>
main {
  @apply fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50;
  @apply transition-all;

  section {
    @apply bg-white rounded-2xl p-8;
    min-width: 500px;

    header {
      @apply flex justify-between items-center;

      span {
        @apply font-bold text-lg;
      }

      button {
        @apply bg-gray-100 p-2 rounded-full;
        @apply hover:shadow-lg hover:bg-gray-200;
      }
    }

    div {
      @apply mt-8;
    }
  }
}
</style>
