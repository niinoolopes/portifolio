const parseObjectToString = (dataObject, options = { required: true }) => {
  let text = ''

  let currentForEach = 0
  Object.keys(dataObject).forEach(key => {
    if (
      options.required &&
      (options.required === true && dataObject[key])
    ) {

      text += currentForEach === 0 ? '' : '&'
      text += `${key}=${dataObject[key]}`

      currentForEach++
    }
  })

  return text
}
export default parseObjectToString