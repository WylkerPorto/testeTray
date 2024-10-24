import http from "./http";

const sellersService = {
  async createSeller(data: any) {
    return await http.post("/sellers", data).then((response) => response.data);
  },
  async getAllSellers(pageUrl?: string) {
    return await http
      .get(pageUrl || "/sellers")
      .then((response) => response.data);
  },

  async getSellerById(sellerId: string) {
    return await http
      .get(`/sellers/${sellerId}`)
      .then((response) => response.data);
  },

  async updateSeller(sellerId: string, data: any) {
    return await http
      .put(`/sellers/${sellerId}`, data)
      .then((response) => response.data);
  },

  async deleteSeller(sellerId: string) {
    return await http
      .delete(`/sellers/${sellerId}`)
      .then((response) => response.data);
  },
};

export default sellersService;
