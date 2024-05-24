const express = require("express");
const app = express();

const dotenv = require("dotenv");
dotenv.config();

//conexión con la base de datos
const {connection} = require("../config.db");

const getlibro = (request, response) => {
    connection.query("SELECT * FROM cursos", 
    (error, results) => {
        if(error)
            throw error;
        response.status(200).json(results);
    });
};

//ruta
app.route("/libro")
.get(getlibro);


const postlibro = (request, response) => {
    const {plato, descripcion, precio, disponible} = request.body;
    connection.query("INSERT INTO curso(plato, descripcion, precio, disponible) VALUES (?,?,?,?) ", 
    [plato, descripcion, precio, disponible],
    (error, results) => {
        if(error)
            throw error;
        response.status(201).json({"Item añadido correctamente": results.affectedRows});
    });
};

//ruta
app.route("/libro")
.post(postlibro);


const dellibro = (request, response) => {
    const id = request.params.id;
    connection.query("Delete from libro where id = ?", 
    [id],
    (error, results) => {
        if(error)
            throw error;
        response.status(201).json({"Item eliminado":results.affectedRows});
    });
};

//ruta
app.route("/libro/:id")
.delete(dellibro);


module.exports = app;