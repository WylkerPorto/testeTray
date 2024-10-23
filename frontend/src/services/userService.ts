import http from "./http";

const userService = {
  getAllUsers() {
    return http.get("/users").then((response) => response.data);
  },

  getUserById(userId: string) {
    return http.get(`/users/${userId}`).then((response) => response.data);
  },

  getUserByEmail(email: string) {
    return http
      .get(`/users/getByEmail/${email}`)
      .then((response) => response.data);
  },

  updateUser(userId: string, data: any) {
    return http.put(`/users/${userId}`, data).then((response) => response.data);
  },

  deleteUser(userId: string) {
    return http.delete(`/users/${userId}`).then((response) => response.data);
  },
};

export default userService;
