<template>
  <LoginLayout>
    <LoginForm />
  </LoginLayout>
</template>
<script lang="ts">
import LoginLayout from "@/layouts/LoginLayout.vue";
import LoginForm from "@/components/login/LoginForm.vue";

export default {
  name: "LoginPage",
  components: {
    LoginLayout,
    LoginForm,
  },
};
</script>
<style lang=""></style>
