// ** Initial State
const initialState = {
  data: [],
  info: {},
  page: 1,
  params: {},
}

const CharacterReducer = (state = initialState, action) => {
  switch (action.type) {
    case 'GET_DATA':
      return {
        ...state,
        data: action.data,
        info: action.info,
        page: action.page,
        params: action.params
      }
    default:
      return state
  }
}

export default CharacterReducer
