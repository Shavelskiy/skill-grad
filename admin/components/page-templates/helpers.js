import querystring from 'querystring'

export const DEFAULT_PAGE_ITEMS = 10

export const getInitStateFromUrl = (query) => {
  let initState = {
    page: 1,
    order: {},
    search: {},
    pageItemCount: DEFAULT_PAGE_ITEMS,
  }

  try {
    const queryParams = querystring.parse(query)

    if (typeof queryParams.page !== 'undefined') {
      initState.page = Number(queryParams.page)
    }

    if (typeof queryParams.order !== 'undefined') {
      initState.order = JSON.parse(queryParams.order)
    }

    if (typeof queryParams.search !== 'undefined') {
      initState.search = JSON.parse(queryParams.search)
    }

    if (typeof queryParams.pageItemCount !== 'undefined') {
      initState.pageItemCount = Number(queryParams.pageItemCount)
    }
  } catch (error) {
  }

  return initState
}
