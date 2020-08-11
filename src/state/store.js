import { createStore, applyMiddleware } from "redux"
import thunk from "redux-thunk"
import charsReducer from "./reducers"

const store = createStore(charsReducer, applyMiddleware(thunk))

export default store
