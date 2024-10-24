<template>
  <nav>
    <div>
      <span>{{ name }}:</span>
      <span>{{ email }}</span>
    </div>
    <button @click="logout">Logout</button>
  </nav>
</template>
<script lang="ts">
import { useUserLogedStore } from "@/stores/userLoged";
import userService from "@/services/userService";

export default {
  name: "NavigationDashboard",
  setup() {
    const userLoged = useUserLogedStore();
    return { userLoged };
  },
  mounted() {
    if (!this.userLoged.userData.id) {
      this.reloadData();
    }
  },
  methods: {
    /**
     * Recarrega os dados do usuario logado.
     *  Ele é chamado quando o componente é montado e o usuario não tem
     * dados no store.
     */
    async reloadData() {
      try {
        const email = localStorage.getItem("email")!;
        const data = await userService.getUserByEmail(email);
        const userLoged = useUserLogedStore();
        userLoged.setUser(data);
      } catch (e) {
        if (e?.status === 401) {
          this.$router.push({ name: "login" });
        }
        console.log("error", e);
      }
    },
    logout() {
      this.userLoged.clearUser();
      localStorage.removeItem("token");
      this.$router.push({ name: "login" });
    },
  },
  computed: {
    name() {
      return this.userLoged?.userData?.name;
    },
    email() {
      return this.userLoged?.userData?.email;
    },
  },
};
</script>
<style lang="scss" scoped>
nav {
  @apply flex justify-between items-center p-4 bg-violet-200;

  div {
    @apply flex items-center gap-2;

    span {
      @apply font-bold text-base;
    }
  }

  button {
    @apply bg-violet-950 text-white py-2 px-4 rounded-2xl;
    @apply hover:shadow-lg hover:shadow-violet-600;
  }
}
</style>
