import React, { useEffect } from 'react'

import axios from 'axios'

import { useDispatch } from 'react-redux'
import { showLoader, hideLoader } from '../../redux/actions'

const ViewPageTemplate = ({children, fetchUrl, setItem}) => {
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(showLoader())

    axios.get(fetchUrl)
      .then(({data}) => {
        setItem(data)
        dispatch(hideLoader())
      })
      .catch((error) => {
        if (error.response.status === 404) {
          console.log('entity not found')
        }
      })
  }, [])

  return <>{children}</>
}

export default ViewPageTemplate
