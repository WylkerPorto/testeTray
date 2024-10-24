import http from "./http";

const saleService = {
  createSale(data: any) {
    return http.post("/sales", data).then((response) => response.data);
  },
  getAllSales() {
    return http.get("/sales").then((response) => response.data);
  },

  getSaleById(saleId: string) {
    return http.get(`/sales/${saleId}`).then((response) => response.data);
  },

  updateSale(saleId: string, data: any) {
    return http.put(`/sales/${saleId}`, data).then((response) => response.data);
  },

  deleteSale(saleId: string) {
    return http.delete(`/sales/${saleId}`).then((response) => response.data);
  },

  getSalesBySeller(sellerId: string) {
    return http
      .get(`/sellers/${sellerId}/sales`)
      .then((response) => response.data);
  },
};

export default saleService;
