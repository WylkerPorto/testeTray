# frontend/Dockerfile
FROM node:22

WORKDIR /app

# Define NODE_ENV como development
ENV NODE_ENV=development

# Copia apenas os arquivos de configuração primeiro
COPY package*.json ./

# Instala as dependências
RUN npm install

# Copia o restante dos arquivos do projeto
COPY . .

# Verifica a instalação do Vite
RUN npx vite --version

# Executa o servidor de desenvolvimento
CMD ["npm", "run", "dev"]
EXPOSE 5173