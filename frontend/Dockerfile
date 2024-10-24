# frontend/Dockerfile
FROM node:18

WORKDIR /app

# Copia os arquivos do projeto
COPY . .

# Instala as dependências
RUN npm install
RUN npm update

# Compila o projeto
RUN npm run build

# Executa o servidor
CMD ["npm", "run", "dev"]
EXPOSE 5173
