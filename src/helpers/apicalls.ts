import 'babel-polyfill'
import axios from 'axios'
import { appUrl } from "../config";

export const  afetchCharacters = async (query:string)=>{
    const response = await axios.get(appUrl + `character${query}`)
    return response.data
}