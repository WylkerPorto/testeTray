import http from "./http";

const userService = {
  async createUser(data: any) {
    return await http.post("/users", data).then((response) => response.data);
  },
  async getAllUsers() {
    return await http.get("/users").then((response) => response.data);
  },

  async getUserById(userId: string) {
    return await http.get(`/users/${userId}`).then((response) => response.data);
  },

  async getUserByEmail(email: string) {
    return await http
      .get(`/users/getByEmail/${email}`)
      .then((response) => response.data);
  },

  async updateUser(userId: string, data: any) {
    return await http
      .put(`/users/${userId}`, data)
      .then((response) => response.data);
  },

  async deleteUser(userId: string) {
    return await http
      .delete(`/users/${userId}`)
      .then((response) => response.data);
  },
};

export default userService;
