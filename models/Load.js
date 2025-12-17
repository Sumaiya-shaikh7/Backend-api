const mongoose = require('mongoose');

const LoadSchema = new mongoose.Schema({
  truckNumber: { type: String, required: true },
  driverName: { type: String, required: true },
  origin: { type: String, required: true },
  destination: { type: String, required: true },
  loadWeight: { type: Number, required: true },
  status: { type: String, default: "Pending" },
  createdAt: { type: Date, default: Date.now }
});

module.exports = mongoose.model('Load', LoadSchema);
