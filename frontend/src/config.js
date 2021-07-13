let server_url="http://127.0.0.1:8000";
let backend_url=server_url+'';
let assets_url='http://localhost:8080/';
let server_client_secret="VYAYXg4XnncjzC82chgBqHHTKmSwOyY4yW96JksB";

export const assets_path = Object.freeze({
    DEFAULT_URL: assets_url
});
export const client_details = Object.freeze({
    CLIENT_ID: "2",
    CLIENT_SECRET: server_client_secret
});
export const server_details = Object.freeze({
    SERVER_URL: backend_url+"/api/",
});