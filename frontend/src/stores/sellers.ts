import { ref } from "vue";
import { defineStore } from "pinia";
import sellerService from "@/services/sellerService";

interface IUser {
  id: string;
  uid: string;
  name: string;
  email: string;
}

export const useSellersStore = defineStore("sellers", () => {
  const sellers = ref<IUser[]>([]);

  async function getSellers() {
    try {
      const data = await sellerService.getAllSellers();
      sellers.value = data.data;
    } catch (e) {
      console.log("error", e);
    }
  }

  function clearSellers() {
    sellers.value = [];
  }

  return { sellers, getSellers, clearSellers };
});
