export const validateFile = (file) => {
  return (file && (
      file.type === 'image/jpeg' ||
      file.type === 'image/jpg' ||
      file.type === 'image/png' ||
      file.type === 'image/svg+xml'
    )
  )
}
