const dateFormat = (date) =>
  (`0` + (date.getDay() + 1)).slice(-2) + `.` +
  (`0` + (date.getMonth() + 1)).slice(-2) + `.` +
  date.getFullYear()

export default dateFormat
