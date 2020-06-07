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
  }, [])

  return <>{children}</>
}

export default ViewPageTemplate
