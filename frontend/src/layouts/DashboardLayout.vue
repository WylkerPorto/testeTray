<template>
  <div>
    <header>
      <NavigationDashboard />
    </header>
    <main>
      <aside>
        <SideMenu />
      </aside>

      <!-- Conteudo -->
      <section>
        <slot></slot>
      </section>
    </main>
  </div>
</template>
<script lang="ts">
import NavigationDashboard from "@/components/core/NavigationDashboard.vue";
import SideMenu from "@/components/core/SideMenu.vue";

export default {
  name: "DashboardLayout",
  components: {
    NavigationDashboard,
    SideMenu,
  },
  mounted() {
    if (!localStorage.getItem("token")) {
      this.$router.push({ name: "login" });
    }
  },
};
</script>
<style lang="scss" scoped>
main {
  @apply flex;

  aside {
    @apply w-48;
  }

  section {
    @apply w-full overflow-auto p-8;
  }
}
</style>
