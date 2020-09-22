const months = ['янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек']


export const dateFormat = (date) =>
  (`0` + (date.getDay() + 1)).slice(-2) + `.` +
  (`0` + (date.getMonth() + 1)).slice(-2) + `.` +
  date.getFullYear()

export const textDateFormat = (date) =>
  (`0` + (date.getDay() + 1)).slice(-2) + ` ` +
  months[date.getMonth()] + ` ` +
  date.getFullYear()

export const timeFormat = (date) =>
  (`0` + (date.getHours() + 1)).slice(-2) + `:` +
  (`0` + (date.getMinutes() + 1)).slice(-2)

