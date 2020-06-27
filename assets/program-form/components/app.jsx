import React from 'react'

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

import css from './app.scss?module'


const App = () => {
  return (
    <div className={css.wrap}>
      <div className={css.progressBar}>
        <ProgressBar/>
      </div>
      <div className={css.form}>
        {/*<Description/>*/}
        {/*<Design/>*/}
        {/*<Providers/>*/}
        {/*<Listeners/>*/}
        <Result/>
        {/*<Organization/>*/}
        {/*<TermOfUse/>*/}
        {/*<Gallery/>*/}
        {/*<Locations/>*/}
        {/*<AdditionalInfo/>*/}
      </div>
    </div>
  )
}

export default App
