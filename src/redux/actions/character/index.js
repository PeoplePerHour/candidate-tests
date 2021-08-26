import axios from 'axios'

import { baseUrl } from '../../../config/api'

// ** Get table Data
export const getData = params => {
  return async dispatch => {
    let url = `${baseUrl}/character`
    let curPage = 1
    if (params !== undefined) {
      url += '/?'
      params.forEach(element => {
        url += `${element.key}=${element.value}&`
        if (element.key === 'page') curPage = element.value
      });
      url = url.slice(0, url.length - 1)
    }

    try {
      await axios.get(url).then(response => {
        dispatch({
          type: 'GET_DATA',
          data: response.data.results,
          info: response.data.info,
          page: curPage,
          params
        })
      })
    } catch (error) {
      console.log('API request failed: ', error.message)
      alert(`API request failed: ${error.message}`)
    }
  }
}
