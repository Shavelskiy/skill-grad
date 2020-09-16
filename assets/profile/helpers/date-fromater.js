export const dateFormat = (date) =>
  (`0` + (date.getDay() + 1)).slice(-2) + `.` +
  (`0` + (date.getMonth() + 1)).slice(-2) + `.` +
  date.getFullYear()

export const timeFormat = (date) =>
  (`0` + (date.getHours() + 1)).slice(-2) + `:` +
  (`0` + (date.getMinutes() + 1)).slice(-2)
