import {mockdata} from './mocks'

export default {
    get:jest.fn(()=>Promise.resolve({data:mockdata}))
  };
  