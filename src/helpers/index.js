export function formatDate(dateStr) {
  const date = new Date(dateStr)
  const year = date.getFullYear()
  const month = date.getMonth().toString().padStart(2, "0")
  const day = date.getDay().toString().padStart(2, "0")
  const hours = date.getHours().toString().padStart(2, "0")
  const minutes = date.getMinutes().toString().padStart(2, "0")
  return `${day}/${month}/${year} - ${hours}:${minutes}`
}

export function urlParamsToObject(paramsStr) {
  const urlSearchParams = paramsStr.substring(1)
  const paramsObject = JSON.parse(
    `{"${decodeURI(urlSearchParams)
      .replace(/"/g, '\\"')
      .replace(/&/g, '","')
      .replace(/=/g, '":"')}"}`
  )
  return paramsObject
}

export function serializeParamsObject(paramsObject) {
  let str = ""
  Object.keys(paramsObject).forEach((key) => {
    if (str !== "") {
      str += "&"
    }
    if (paramsObject[key].replace(/ /g, "")) {
      str += `${key}=${paramsObject[key]}`
    }
  })

  return str
}
