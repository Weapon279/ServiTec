const express = require("express");
const app = express();

const dotenv = require("dotenv");
dotenv.config();

const {connection} = require("../config.db");

const getCurso = (request, response) => {
    connection.query("SELECT * FROM curso",
    (error, result) => {
        if(error)
            throw error;
            response.status(200).json(results);
        });
};

app.route("/curso")
.get(getCurso);

const postcurso = (reques, response) => {
    const {perfil,NombreCurso,Objectivocurso} = request.body;
    connection.query("INSERT INTO curso(perfil,Nombrecurso,Objectivocurso) VALUES (?,?,?)" , [perfil,Nombrecurso,Ojectivocurso],
    (error, results) => {
        if(error)
            throw error;
        response.status(200).json({"Dato anadido correctamente": results.affectedRows});
    });
};
app.route("/curso")
.post(postcurso)

module.exports = app;