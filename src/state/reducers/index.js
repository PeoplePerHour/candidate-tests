import {
  FETCH_CHARS_REQUEST,
  FETCH_CHARS_SUCCESS,
  FETCH_CHARS_ERROR,
} from "../types"
import CHARS_API_URL from "../../constants"

const initialState = {
  loading: false,
  chars: [],
  error: null,
  info: null,
}

function charsReducer(state = initialState, action) {
  switch (action.type) {
    case FETCH_CHARS_REQUEST:
      return {
        ...state,
        loading: true,
      }
    case FETCH_CHARS_SUCCESS:
      const { chars, info } = action
      const stripRegexStr = `&(.*)`
      const stripParamsMatch = `${CHARS_API_URL}/?page=`
      const stripRegex = new RegExp(stripRegexStr, "g")

      const currentPage = !info.prev
        ? 1
        : !info.next
        ? info.pages
        : Number(
            info.next.replace(stripParamsMatch, "").replace(stripRegex, "") - 1
          )
      const prevPage = info.prev
        ? Number(
            info.prev.replace(stripRegex, "").replace(stripParamsMatch, "")
          )
        : ""
      const nextPage = info.next
        ? Number(
            info.next.replace(stripRegex, "").replace(stripParamsMatch, "")
          )
        : ""

      info.currentPage = currentPage
      info.prevPage = prevPage
      info.nextPage = nextPage
      return {
        ...state,
        chars,
        info,
        loading: false,
      }
    case FETCH_CHARS_ERROR:
      const { error } = action
      return {
        ...state,
        loading: false,
        chars: [],
        info: null,
        error,
      }
    default:
      return state
  }
}

export default charsReducer
