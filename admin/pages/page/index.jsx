import React from 'react'
import { actions, table } from './table'
import { FETCH_PAGES_URL } from '../../utils/api/endpoints'
import { PAGE_CREATE } from '../../utils/routes'
import IndexPageTemplate from '../../components/page-templates'


const PageIndex = () => {
  return (
    <IndexPageTemplate
      title={'Страницы'}
      icon={'sticky-note'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_PAGES_URL}
      canCreate={true}
      createLink={PAGE_CREATE}
    />
  )
}

export default PageIndex
