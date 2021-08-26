const express = require('express');
const router = express.Router();

router.get('/', async (req, res) => {
  try {
    const userList = {
      "name": "Denis Tuktarov",
      "status": "success",
    };
    res.json(userList);
  } catch (e) {
    // Something went wrong with the server!
    res.status(500).send();
  }
});

router.get('*', async (req, res) => {
  // Not implemented
  res.status(404).json({ error: 'Not found' });
});

router.post('/', async (req, res) => {
  // Not implemented
  res.status(501).send();
});

module.exports = router;