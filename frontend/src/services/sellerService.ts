import http from "./http";

const sellersService = {
  createSeller(data: any) {
    return http.post("/sellers", data).then((response) => response.data);
  },
  getAllSellers() {
    return http.get("/sellers").then((response) => response.data);
  },

  getSellerById(sellerId: string) {
    return http.get(`/sellers/${sellerId}`).then((response) => response.data);
  },

  updateSeller(sellerId: string, data: any) {
    return http
      .put(`/sellers/${sellerId}`, data)
      .then((response) => response.data);
  },

  deleteSeller(sellerId: string) {
    return http
      .delete(`/sellers/${sellerId}`)
      .then((response) => response.data);
  },
};

export default sellersService;
