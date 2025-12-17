const db = require("../db");

// CREATE LOAD
exports.createLoad = (req, res) => {
    const d = req.body;

    const query = `
        INSERT INTO My_Loads 
        (agent_id, load_code, category, pickup_city, pickup_state, drop_city, drop_state, 
        distance_km, freight_amount, pickup_date, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    `;

    db.query(query, [
        d.agent_id, d.load_code, d.category,
        d.pickup_city, d.pickup_state, d.drop_city, d.drop_state,
        d.distance_km, d.freight_amount, d.pickup_date, d.status
    ], (err, result) => {
        if (err) return res.status(500).json({ error: err });
        res.json({ message: "Load created successfully", id: result.insertId });
    });
};

// GET ALL LOADS (with filters, search, sort)
exports.getLoads = (req, res) => {
    let { status, search, sort } = req.query;

    let query = `SELECT * FROM My_Loads WHERE 1=1`;

    if (status) query += ` AND status='${status}'`;
    if (search) {
        query += ` AND (
            load_code LIKE '%${search}%' OR
            pickup_city LIKE '%${search}%' OR
            drop_city LIKE '%${search}%'
        )`;
    }

    if (sort === "freight") query += ` ORDER BY freight_amount DESC`;
    if (sort === "date") query += ` ORDER BY pickup_date DESC`;

    db.query(query, (err, rows) => {
        if (err) return res.status(500).json({ error: err });
        res.json(rows);
    });
};

// GET SINGLE LOAD
exports.getLoadById = (req, res) => {
    db.query(
        `SELECT * FROM My_Loads WHERE id=?`,
        [req.params.id],
        (err, rows) => {
            if (err) return res.status(500).json({ error: err });
            res.json(rows[0]);
        }
    );
};

// UPDATE
exports.updateLoad = (req, res) => {
    db.query(
        `UPDATE My_Loads SET ? WHERE id=?`,
        [req.body, req.params.id],
        (err) => {
            if (err) return res.status(500).json({ error: err });
            res.json({ message: "Load updated" });
        }
    );
};

// DELETE
exports.deleteLoad = (req, res) => {
    db.query(
        `DELETE FROM My_Loads WHERE id=?`,
        [req.params.id],
        (err) => {
            if (err) return res.status(500).json({ error: err });
            res.json({ message: "Load deleted" });
        }
    );
};

// COUNTS FOR DASHBOARD
exports.getLoadCounts = (req, res) => {
    const query = `
        SELECT 
            (SELECT COUNT(*) FROM My_Loads) AS total,
            (SELECT COUNT(*) FROM My_Loads WHERE status='active') AS active,
            (SELECT COUNT(*) FROM My_Loads WHERE status='pending') AS pending,
            (SELECT COUNT(*) FROM My_Loads WHERE status='completed') AS completed
    `;
    db.query(query, (err, rows) => {
        if (err) return res.status(500).json({ error: err });
        res.json(rows[0]);
    });
};
