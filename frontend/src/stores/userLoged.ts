import { ref } from "vue";
import { defineStore } from "pinia";

// Definindo os dados do usuário logado (id, nome, email, is_admin)
export const useUserLogedStore = defineStore("userLoged", () => {
  // userData será um objeto que contém id, name, email, is_admin
  const userData = ref({
    id: null as string | null,
    name: "",
    email: "",
    is_admin: false,
  });

  // Função para definir os dados do usuário
  function setUser(data: {
    id: string;
    name: string;
    email: string;
    is_admin: boolean;
  }) {
    userData.value.id = data.id;
    userData.value.name = data.name;
    userData.value.email = data.email;
    userData.value.is_admin = data.is_admin;
  }

  // Função para limpar os dados do usuário
  function clearUser() {
    userData.value.id = null;
    userData.value.name = "";
    userData.value.email = "";
    userData.value.is_admin = false;
  }

  return { userData, setUser, clearUser };
});
