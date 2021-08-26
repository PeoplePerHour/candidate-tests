export const getQueryFromURL = (url) => 
{
    let str_buf = ''
    const baseIdx = url.indexOf('?')

    if (baseIdx !== -1) str_buf = url.slice(baseIdx + 1)
    
    const str_param = str_buf.split('=')
    if (str_param.length < 2) return undefined

    return {
        key: str_param[0],
        value: str_param[1],
    }
}