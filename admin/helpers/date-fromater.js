const dateFormat = (date) =>
  date.getFullYear() + `.` +
  (`0` + (date.getMonth() + 1)).slice(-2) + `.` +
  (`0` + (date.getDay() + 1)).slice(-2) + ` ` +

  (`0` + (date.getHours() + 1)).slice(-2) + `:` +
  (`0` + (date.getMinutes() + 1)).slice(-2) + `:` +
  (`0` + (date.getSeconds() + 1)).slice(-2)

export default dateFormat
