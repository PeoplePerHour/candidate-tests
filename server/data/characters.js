const rawData = require('./charactersData')

let exportedMethods = {
  getData (filter) {
    let buf_data = [], count = rawData.length

    if (filter.name === '' && filter.status === '' && filter.gender === '') buf_data = rawData
    else {
      count = 0
      for (each of rawData) {
        const name = each.name.toLowerCase().replace(/\s/g, "")
        const status = each.status.toLowerCase()
        const gender = each.gender.toLowerCase()

        if (filter.name !== '') {
          if (name.indexOf(filter.name) === -1) continue
        }

        if (filter.status !== '') {
          if (status !== filter.status) continue
        }

        if (filter.gender !== '') {
          if (gender !== filter.gender) continue
        }
        count++
        buf_data.push(each)
      }
    }

    const results = buf_data.slice(20 * (filter.page - 1), 20 * filter.page)
    return {
      info: {
        count,
        pages: Math.ceil(count / 20),
      },
      results
    }
  }
}

module.exports = exportedMethods