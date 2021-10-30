export default function dateFormat(date, pattern, options = []) {

  date = date.length == 10 ? `${date} 00:00:00` : date

  let newDate = new Date(date);

  let DD = (newDate.getDate()).toString();
  let MM = (newDate.getMonth() + 1).toString();
  let YYYY = (newDate.getFullYear()).toString();
  let H = (newDate.getHours()).toString();
  let M = (newDate.getMinutes()).toString();
  let S = (newDate.getSeconds()).toString();

  let format = {
    DD: DD.length == 1 ? `0${DD}` : DD,
    MM: MM.length == 1 ? `0${MM}` : MM,
    YYYY: YYYY,
    H: H,
    M: M.length == 1 ? `0${M}` : M,
    S: S.length == 1 ? `0${S}` : S,
  }

  return pattern
    .filter(f => format[f])
    .map((key, i) => `${format[key]}${options[i] || ''}`)
    .join('')
}