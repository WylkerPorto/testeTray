<template>
  <div>
    <header>
      <h1 class="text-xl font-bold">Dashboard</h1>
    </header>
    <main>
      <aside></aside>
      <slot></slot>
    </main>
  </div>
</template>
<script>
export default {
  name: "DashboardLayout",
};
</script>
<style lang=""></style>
