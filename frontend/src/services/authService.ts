import http from "./http";

interface ILoginCredentials {
  email: string;
  password: string;
}

interface ILoginResponse {
  token: string;
}

const authService = {
  async login(credentials: ILoginCredentials): Promise<ILoginResponse> {
    return await http
      .post("/login", credentials)
      .then((response) => response.data);
  },

  logout() {
    // Opcional: Limpar o token do localStorage
    localStorage.removeItem("token");
  },
};

export default authService;
