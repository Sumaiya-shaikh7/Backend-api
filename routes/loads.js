const express = require("express");
const router = express.Router();
const controller = require("../controllers/loadsController.js");

// CRUD
router.post("/", controller.createLoad);
router.get("/", controller.getLoads);
router.get("/counts", controller.getLoadCounts);
router.get("/:id", controller.getLoadById);
router.put("/:id", controller.updateLoad);
router.delete("/:id", controller.deleteLoad);

module.exports = router;
