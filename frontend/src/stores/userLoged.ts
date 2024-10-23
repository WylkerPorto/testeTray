// src/stores/userLoged.ts
import { ref } from "vue";
import { defineStore } from "pinia";

// Definindo os dados do usuário logado (id, nome, email, is_admin)
export const useUserLogedStore = defineStore("userLoged", () => {
  // userData será um objeto que contém id, name, email, is_admin
  const userData = ref({
    id: null,
    name: "",
    email: "",
    is_admin: false,
  });

  // Função para definir os dados do usuário
  function setUser(
    data = {
      id: null,
      name: "",
      email: "",
      is_admin: false,
    }
  ) {
    userData.value.id = data.id;
    userData.value.name = data.name;
    userData.value.email = data.email;
    userData.value.is_admin = data.is_admin;
  }

  return { userData, setUser };
});
