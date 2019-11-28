import mockAxios from 'axios'
import {afetchCharacters} from './apicalls'
import {mockdata} from '../__mocks__/mocks'

it('calls axios and return characters list',async()=>{
    const data = await afetchCharacters('')
    //expect (data).toEqual(mockdata)
    expect(mockAxios.get).toHaveBeenCalledTimes(1)
    expect(data).toMatchObject(mockdata)

})