const express = require('express');
const app = express();

app.get('/', (req, res) => {
    res.send("Server is working");
});

app.get('/api/loads', (req, res) => {
    res.json({ message: "GET /api/loads working" });
});

app.listen(5000, () => {
    console.log("Server started at http://localhost:5000");
});

