import { urlParamsToObject, serializeParamsObject } from "./index"

describe("Helpers functions test suite", () => {
  it("urlParamsToObject Should return object from string", () => {
    const strParams = "?name=John&gender=Male"
    expect(typeof urlParamsToObject(strParams)).toBe("object")
  })

  it("urlParamsToObject Should return object with name and gender", () => {
    const mockName = "John"
    const mockGender = "Male"
    const strParams = `?name=${mockName}&gender=${mockGender}`
    const paramsObj = urlParamsToObject(strParams)
    expect(paramsObj.name).toBe(mockName)
    expect(paramsObj.gender).toBe(mockGender)
  })

  it("serializeParamsObject Should return string from object", () => {
    const mockObject = {
      name: "John",
      gender: "Male",
    }
    const serialized = serializeParamsObject(mockObject)
    expect(typeof serialized).toBe("string")
  })

  it("serializeParamsObject Should return string containing properties from object", () => {
    const mockObject = {
      name: "John",
      gender: "Male",
    }
    const serialized = serializeParamsObject(mockObject)
    expect(serialized).toBe(
      `name=${mockObject.name}&gender=${mockObject.gender}`
    )
  })
})
