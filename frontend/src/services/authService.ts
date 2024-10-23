import http from "./http";

interface LoginCredentials {
  email: string;
  password: string;
}

interface LoginResponse {
  token: string;
}

const authService = {
  login(credentials: LoginCredentials): Promise<LoginResponse> {
    return http.post("/login", credentials).then((response) => response.data);
  },

  logout() {
    // Opcional: Limpar o token do localStorage
    localStorage.removeItem("token");
  },
};

export default authService;
