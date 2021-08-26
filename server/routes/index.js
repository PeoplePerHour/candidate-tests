const characterRoutes = require('./character');
const healthRoutes = require('./health');

const constructorMethod = (app) => {
  app.use('/api/character', characterRoutes);
  app.use('/ping', healthRoutes);

  app.use('*', (req, res) => {
    res.status(404).json({ error: 'Not found' });
  });
};

module.exports = constructorMethod;