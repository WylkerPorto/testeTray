<template>
  <form @submit.prevent="login">
    <section>
      <picture>
        <i class="icon i-user"></i>
      </picture>
      <input
        v-model="form.email"
        type="email"
        placeholder="Email"
        :class="{ 'has-error': emailError }"
        required
      />
    </section>

    <section>
      <picture>
        <i class="icon i-locker"></i>
      </picture>
      <input
        v-model="form.password"
        type="password"
        placeholder="Password"
        :class="{ 'has-error': passwordError }"
        required
      />
    </section>

    <button type="submit" :disabled="loading">Login</button>
  </form>
</template>
<script lang="ts">
import authService from "@/services/authService";
import userService from "@/services/userService";
import { useUserLogedStore } from "@/stores/userLoged";

export default {
  name: "LoginForm",
  data() {
    return {
      form: {
        email: "" as string,
        password: "" as string,
      },
      emailError: false as boolean,
      passwordError: false as boolean,
      loading: false as boolean,
    };
  },
  methods: {
    validate() {
      // Resetar os erros antes de validar e desabilita botão
      this.loading = true;
      this.emailError = false;
      this.passwordError = false;

      // Validar os campos
      if (!this.form.email) {
        this.emailError = true;
      }

      if (!this.form.password) {
        this.passwordError = true;
      }

      return false;
    },
    async login() {
      try {
        if (this.validate()) {
          throw new Error("Campos inválidos");
        }

        const data = await authService.login(this.form);

        if (data?.token) {
          this.handleSetUser(data.token);
        }
      } catch (e) {
        console.log("login error", e);
      } finally {
        this.loading = false;
      }
    },
    /**
     * Seta o usuário logado no store e redireciona para dashboard
     */
    async handleSetUser(token: string) {
      try {
        localStorage.setItem("token", token);
        localStorage.setItem("email", this.form.email);
        const data = await userService.getUserByEmail(this.form.email);
        const userLoged = useUserLogedStore();
        userLoged.setUser(data);
        this.$router.push({ name: "dashboard" });
      } catch (e) {
        console.log("handleSetUser error", e);
      }
    },
  },
};
</script>
<style lang="scss" scoped>
form {
  @apply flex flex-col gap-10 w-auto items-center rounded-2xl px-10 py-16 bg-violet-400;
  @apply hover:shadow-lg hover:shadow-violet-600;

  section {
    @apply flex items-center bg-violet-700;

    picture {
      @apply h-auto w-12 justify-items-center;
    }

    input {
      @apply outline-none h-12 w-80 pl-4 text-lg;

      &.has-error {
        @apply border border-red-500; // Classe de erro com borda vermelha
      }
    }
  }

  button {
    @apply bg-violet-950 text-white py-2 px-10 rounded-2xl;
    @apply hover:shadow-lg hover:shadow-violet-600;
  }
}
</style>
