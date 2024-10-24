import http from "./http";

const saleService = {
  async createSale(data: any) {
    return await http.post("/sales", data).then((response) => response.data);
  },
  async getAllSales(pageUrl?: string) {
    return await http
      .get(pageUrl || "/sales")
      .then((response) => response.data);
  },

  async getSaleById(saleId: string) {
    return await http.get(`/sales/${saleId}`).then((response) => response.data);
  },

  async updateSale(saleId: string, data: any) {
    return await http
      .put(`/sales/${saleId}`, data)
      .then((response) => response.data);
  },

  async deleteSale(saleId: string) {
    return await http
      .delete(`/sales/${saleId}`)
      .then((response) => response.data);
  },

  async getSalesBySeller(sellerId: string, date: string) {
    return await http
      .get(`/sellers/${sellerId}/sales?date=${date}`)
      .then((response) => response.data);
  },

  async resendCommission(saleId: string) {
    return await http.post(`/sales/${saleId}/resend-commission`);
  },
};

export default saleService;
