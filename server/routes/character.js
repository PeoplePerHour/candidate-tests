const express = require('express')
const router = express.Router()
const data = require('../data')
const characterData = data.characters

const queryKeys = [
  'page',
  'name',
  'status',
  'gender',
]

router.get('*', async (req, res) => {
  try {
    const querys = req.query
    let filter = {
      page: 1,
      name: '',
      status: '',
      gender: '',
    }
    
    for (key in querys) {
      if (queryKeys.indexOf(key) === -1) throw 'Invalid filter key'
      filter[key] = querys[key]
    }

    const result = characterData.getData(filter)

    res.json(result)
  } catch (e) {
    res.status(404).json({ message: `Not Found #'${e}'` })
  }
})

router.post('/', async (req, res) => {
  // Not implemented
  res.status(501).json({ message: `Error: Post method is now allowed` })
})


module.exports = router