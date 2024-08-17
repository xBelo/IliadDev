# Dockerfile for Angular frontend
FROM node:20.9

# Set working directory
WORKDIR /app

# Copy package.json and install dependencies
COPY package.json ./
#RUN npm install -g @angular/cli@latest
#RUN npm install
#RUN npm i -s -g @angular/cli
#RUN npm i -s -g @angular-devkit/build-angular:dev-server
#RUN npm i -g @angular-devkit/build-angular:application
RUN npm install -g @angular/cli@17 \
    && npm install \
	&& npm install @clr/ui @cds/core --save

# Copy the rest of the application
COPY . .

#RUN npm run build

# Expose port 4200
EXPOSE 4200

# Start the Angular application
#CMD ["npm", "start"]
CMD ["./node_modules/.bin/ng", "serve", "--host", "--poll 1", "--proxy-config proxy.conf.json", "0.0.0.0"]
