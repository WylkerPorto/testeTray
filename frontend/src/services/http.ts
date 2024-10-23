import axios from "axios";

// Criando a instância do Axios com configurações padrão
const http = axios.create({
  baseURL: "http://localhost/api",
  headers: {
    "Content-Type": "application/json",
  },
});

// Interceptador para adicionar o token JWT a cada requisição
http.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

export default http;
