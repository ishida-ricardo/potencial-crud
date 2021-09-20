FROM node:lts-alpine

WORKDIR /app

COPY package.json ./

COPY package-lock.json ./

RUN npm config set unsafe-perm true

RUN npm install

COPY . ./

RUN chown -R node /app/node_modules

USER node

EXPOSE 3000

CMD ["npm", "start"]
