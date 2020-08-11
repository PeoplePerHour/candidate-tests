import {
  FETCH_CHARS_REQUEST,
  FETCH_CHARS_SUCCESS,
  FETCH_CHARS_ERROR,
} from "../types"
import CHARS_API_URL from "../../constants"

export function fetchChars(apiUrl) {
  return (dispatch) => {
    dispatch(fetchCharsRequest())
    const url = apiUrl || CHARS_API_URL
    fetch(url)
      .then((res) => res.json())
      .then((res) => {
        if (res && res.results) {
          dispatch(fetchCharsSuccess(res))
        } else {
          throw res.error
        }
      })
      .catch((err) => {
        dispatch(fetchCharsError(err))
      })
  }
}

const fetchCharsRequest = () => {
  return {
    type: FETCH_CHARS_REQUEST,
  }
}
const fetchCharsSuccess = (res) => {
  return {
    type: FETCH_CHARS_SUCCESS,
    chars: res.results,
    info: res.info,
  }
}
const fetchCharsError = (error) => {
  return {
    type: FETCH_CHARS_ERROR,
    error,
  }
}
