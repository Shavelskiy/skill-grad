import React, { useEffect } from 'react'

import axios from 'axios'
import { FETCH_CURRENT_PROVIDER, FETCH_FIELDS } from '@/utils/program-form/endpoints'

import { useDispatch } from 'react-redux'
import { setCurrentProvider, setFields } from '../redux/data/actions'

import ProgressBar from './progress-bar/progress-bar'
import Description from './description/description'
import Design from './design/design'
import Providers from './providers/providers'
import Listeners from './listeners/listeners'
import Result from './result/result'
import Organization from './organization/organization'
import TermOfUse from './term-of-use/term-of-use'
import Gallery from './gallery/gallery'
import Locations from './locations/locations'
import AdditionalInfo from './additional-info/additional-info'
import ResultButtons from './result-buttons/result-buttons'

import css from './app.scss?module'


const App = () => {
  const dispatch = useDispatch()

  useEffect(() => {
    axios.get(FETCH_FIELDS)
      .then(({data}) => dispatch(setFields(data)))

    axios.get(FETCH_CURRENT_PROVIDER)
      .then(({data}) => dispatch(setCurrentProvider(data)))
  }, [])

  return (
    <div className={css.wrap}>
      <div className={css.progressBar}>
        <ProgressBar/>
      </div>
      <div className={css.form}>
        <Description/>
        <Design/>
        <Providers/>
        <Listeners/>
        <Result/>
        <Organization/>
        <TermOfUse/>
        <Gallery/>
        <Locations/>
        <AdditionalInfo/>
        <ResultButtons/>
      </div>
    </div>
  )
}

export default App
